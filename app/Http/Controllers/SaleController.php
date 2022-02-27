<?php

namespace App\Http\Controllers;

// request

use App\Events\SendEmailNotifyingSaleVerifiedEvent;
use App\Events\SendSaleEmailNotificationEvent;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Traits\StorageApp;

// modelos
use App\Models\Brand;
use App\Models\Sale;

// utils
use App\Utils\AppRedirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response as InertiaResponse;

class SaleController extends Controller
{

    /**
     * Trait para manipular la instancia de storage
     */
    use StorageApp;

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

        $isFailed = DB::transaction(function () use ($data, $brand) {

            // Guardar y getear el nombre el comprobante
            $filename = $this->uploadFile($data['voucher'], config('sales.folder'));

            // si no se pudo subir el archivo, se retorna  un error
            if (!$filename) {
                return true;
            }

            // setear el nombre del archivo
            $data['voucher'] = $filename;

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

    /**
     * Devuelve la vista con la venta realizada
     *
     * @param Sale $sale            La venta
     * @return InertiaResponse      El componente
     */
    public function show(Sale $sale): InertiaResponse
    {
        return AppRedirect::inertiaRender('Sale/Show', [
            'sale'     => $sale,
        ]);
    }

    /**
     * Marca una venta como verificada y devuelve la vista actualizada
     *
     * @param Sale $sale            La venta a marcar como verificada
     * @param Brand $brand          La marca de la venta
     * @return JsonResponse         Listado de ventas actualizado
     */
    public function saleVerify(Sale $sale, Brand $brand): JsonResponse
    {

        $isFailed = DB::transaction(function () use ($sale) {

            // marcar como verificada
            $sale->verifySale();

            // notificar via email que ha sido verificado
            event(new SendEmailNotifyingSaleVerifiedEvent($sale));
        });

        // Si hubo un error no hacer nada
        if ($isFailed) {
            return null;
        }

        // actualizar el listado de ventas
        $currentPage = request()->get('currentPage');
        $brand = $brand->getSalesByBrand($brand, $currentPage);
        $sales = $brand->paginateSales;

        return AppRedirect::jsonResponse($sales->toArray());
    }
}
