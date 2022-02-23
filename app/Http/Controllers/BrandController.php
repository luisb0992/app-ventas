<?php

namespace App\Http\Controllers;

// request
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

// traits
use App\Http\Traits\BrandTrait;

// modelos
use App\Models\Brand;

// redirect
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;

// utils
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Utils\AppRedirect;
use Inertia\Inertia;

class BrandController extends Controller
{

    use BrandTrait;

    /**
     * Rederiza el componente de listado de marcas
     *
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Brand/Index', [
            'brands' => Brand::getOrderBrands(),
        ]);
    }

    /**
     * Crea un nuevo registro de marca
     *
     * @return RedirectResponse         Listado de marcas
     */
    public function store(CreateBrandRequest $request): RedirectResponse
    {
        $data = $request->all();

        // Guardar y getear el nombre el logo
        $data['logo'] = $this->uploadFile($data['logo']);

        // slug
        $data['slug'] = $this->createSlug($data['name']);

        // Guardar los datos de la marca
        Brand::create($data);

        return Redirect::route('brands.index');
    }

    /**
     * Devuelve toda la info de una marca
     *
     * @param  Brand  $brand        La marca
     * @return InertiaResponse      Componente de la marca
     */
    public function show(Brand $brand): InertiaResponse
    {
        return AppRedirect::inertiaRender('Brand/Show', [
            'brand' => $this->getSalesByBrand($brand),
            'brands' => Brand::getOrderBrands(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->all();

        // Guardar y getear el nombre el logo
        $data['logo'] = $this->updateOrNotLogo($data['logo'], $brand);

        // slug
        $data['slug'] = $this->updateOrNotSlug($data['name'], $brand);

        // actualizar los datos de la marca
        $brand->update($data);

        return Redirect::route('brands.index');
    }

    /**
     * Elimina de manera soft la marca seleccionada
     *
     * @param  \App\Models\Brand  $brand    La marca a eliminar
     * @return RedirectResponse             Las marcas restantes
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        // eliminar el logo
        $this->deleteBrandLogo($brand);

        // eliminar la marca
        $brand->delete();

        return Redirect::route('brands.index');
    }

    /**
     * Obtiene el logo de la marca
     *
     * @param  \App\Models\Brand  $brand    La marca a eliminar
     * @return Response                     El logo de la marca o null si no existe
     */
    public function getLogo(Brand $brand): ?Response
    {
        $logo = $this->getBrandLogo($brand);

        if (!$logo) {
            return null;
        }

        return response($logo['content'])->withHeaders([
            'Content-Type' => $logo['type']
        ]);
    }
}
