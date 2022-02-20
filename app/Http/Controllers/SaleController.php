<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaleRequest;
use App\Http\Traits\SaleTrait;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
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

        if (!$brand) {
            return Redirect::route('main')->with('status', 'La marca que intenta ver no existe');
        }

        return Inertia::render('Sale/Create', [
            'brand' => $brand,
        ]);
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

        // Guardar y getear el nombre el comprobante
        $data['voucher'] = $this->uploadFile($data['voucher']);

        // crear la venta
        $brand->sales()->create($data);

        return Redirect::route('sales.createWithBrand', $brand->slug);
    }
}
