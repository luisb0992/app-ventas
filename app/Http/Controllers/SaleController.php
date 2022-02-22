<?php

namespace App\Http\Controllers;

use App\Events\SendSaleEmailNotificationEvent;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Traits\SaleTrait;
use App\Models\Brand;
use App\Utils\AppRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response as InertiaResponse;

class SaleController extends Controller
{

    use SaleTrait;

    /**
     * Devuelve el componente de creación de la venta
     *
     * @param String $brandSlug         Slug de la marca
     * @return RedirectResponse|InertiaResponse          El componente
     */
    public function createWithBrand(string $slug)
    {
        $brand = Brand::getBrandForSlug($slug);

        // si no existe la marca, redirecciona a la ruta principal
        if (!$brand) {
            $route = route('main');
            return AppRedirect::withSession($route, 'status', 'La marca que intenta ver no existe');
        }

        return AppRedirect::inertiaRender('Sale/Create', [
            'brand'     => $brand,
            'failed'    => session('failed'),
        ], 'status');
    }

    /**
     * Guarda una venta desde una marca
     *
     * @param  Brand    $brand          La marca
     * @param  Request  $request        El request
     * @return RedirectResponse         Listado de ventas
     */
    public function saveWithBrand(CreateSaleRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->all();

        // SI todo salió bien, guardar el voucher
        // guardar la venta y enviar el correo
        $isFailed = DB::transaction(function () use ($data, $brand) {

            // Guardar y getear el nombre el comprobante
            $data['voucher'] = $this->uploadFile($data['voucher']);

            // crear la venta
            $sale = $brand->sales()->create($data);

            // notificar via email
            event(new SendSaleEmailNotificationEvent($sale));
        });

        // la ruta a redireccionar
        $route = route('sales.createWithBrand', $brand->slug);

        // Si hubo un error, redirigir a la ruta de creación
        // y mostrar un mensaje de error
        if ($isFailed) {
            return AppRedirect::withSession($route, 'failed', 'Error al crear la venta, intente nuevamente');
        }

        // Eliminar la sesión de error y redirigir a la vista de creación
        return AppRedirect::forgettingProperty($route, 'failed');
    }
}
