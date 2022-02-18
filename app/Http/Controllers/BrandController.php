<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBrandRequest;
use App\Http\Traits\BrandTrait;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Crea un nuevo registro de marca
     *
     * @return InertiaResponse
     */
    public function store(CreateBrandRequest $request): InertiaResponse
    {
        $data = $request->all();

        // Guardar el logo
        $data['logo'] = $this->uploadFile($data['logo']);

        // Guardar los datos de la marca
        Brand::create($data);

        return Inertia::render('Brand/Index', [
            'brands' => Brand::getOrderBrands(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Elimina de manera soft la marca seleccionada
     *
     * @param  \App\Models\Brand  $brand    La marca a eliminar
     * @return InertiaResponse                 Las marcas restantes
     */
    public function destroy(Brand $brand): InertiaResponse
    {
        $brand->delete();

        return Inertia::render('Brand/Index', [
            'brands' => Brand::getOrderBrands(),
        ]);
    }
}
