<?php

/**
 * Trait BrandTrait
 *
 * Gestiona todas las funcionalidades de las marcas
 * - Storage
 * - get data
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Http\Traits;

use App\Models\Brand;
use App\Models\Sale;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait BrandTrait
{

    /**
     * La paginación seteada
     */
    public $PAGINATE = 10;

    /**
     * Almacena el logo de la marca
     *
     * @param UploadedFile $file    Archivo subido
     * @return String               Nombre del archivo
     */
    public function uploadFile(UploadedFile $file): String
    {
        // nombre para el archivo
        $extension = $file->getClientOriginalExtension();
        $filename = 'file-' . time() . '.' . $extension;

        // guardar el archivo en el storage
        $storage = Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs(
            config('brands.folder'),
            $file,
            $filename
        );

        return $filename;
    }

    /**
     * Obtiene el logo de la marca
     *
     * @param Brand $brand          La marca
     * @return Response             El contenido del archivo
     */
    public function getBrandLogo(Brand $brand): ?Collection
    {
        $path = config('brands.folder') . '/' . $brand->logo;

        if (!Storage::exists($path)) {
            return null;
        }

        return collect([
            'content' => Storage::get($path),
            'type' => Storage::mimeType($path),
        ]);
    }

    /**
     * Elimina el logo de la marca seleccionada
     *
     * @param Brand $brand          La marca a eliminar
     * @return void
     */
    public function deleteBrandLogo(Brand $brand): void
    {
        $path = config('brands.folder') . '/' . $brand->logo;

        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    /**
     * Actualiza el logo de la marca seleccionada
     * de ser necesario o se deja el que esta por defecto
     *
     * @param Brand $brand          La marca a eliminar
     * @return string               El nombre del logo actualizado o no
     */
    public function updateOrNotLogo(UploadedFile $file, Brand $brand): string
    {
        $needToUpdate = $file->getClientOriginalName() !== $brand->logo;

        // si no son iguales los nombre se actualiza el logo
        if ($needToUpdate) {
            // elimina el logo anterior
            $this->deleteBrandLogo($brand);

            // guarda el nuevo logo
            return $this->uploadFile($file);
        }

        // sino retorna el mismo nombre del logo
        return $brand->logo;
    }

    /**
     * Devuelve un string amigable para el slug de la marca
     *
     * @param String $value          El nombre de la marca
     * @return string               El nombre del logo actualizado o no
     */
    public function createSlug(string $value): string
    {
        $string = Str::limit($value, config('brands.slug.max'));
        return Str::slug($string, '-');
    }

    /**
     * Actualiza o no  el slug de la marca
     *
     * @param String $value             El nombre de la marca
     * @return string                   El nombre del slug
     */
    public function updateOrNotSlug(string $value, Brand $brand): string
    {
        $needToUpdate = $value !== $brand->name;

        // si no son iguales los nombres se actualiza el slug
        if ($needToUpdate) {
            return $this->createSlug($value);
        }

        // sino retorna el mismo nombre del slug
        return $brand->slug;
    }

    /**
     * Devuelve una colección con los datos de la marca y todas sus ventas
     * "seteadas" con los datos necesarios para manipular en el front
     *
     * @param Brand $brand          El objeto de la marca
     * @param Int $currentPage      La página actual
     * @return Brand                El objeto de la marca junto a las ventas
     */
    public function getSalesByBrand(Brand $brand, int $currentPage = 0): Brand
    {
        $brand = $brand->load('sales');

        $brand->sales->each(function ($sale) {
            $this->setSaleData($sale);
        });

        // devuelve una nueva propiedad con las ventas paginadas
        // con el número de ventas por página
        $this->getSalePaginateData($brand, 'paginateSales', $currentPage);

        return $brand;
    }

    /**
     * Agrega datos a la colección de ventas en un formato
     * compatible para ser leído al front
     *
     * @param Sale $sale            El objeto de la venta
     * @return Sale                 El objeto de la venta con los datos agregados
     */
    public function setSaleData(Sale $sale): Sale
    {
        $sale->usd_amount = $sale->usd_amount;
        $sale->isVerified = $sale->hasItBeenVerified();

        return $sale;
    }

    /**
     * Devuelve una colección con las ventas de una marca especificada paginadas
     *
     * @param Brand $brand              La marca
     * @param string $key               La llave del array donde se guarda la colección
     * @param Int $currentPage          La página actual
     * @return Brand                    La marca con las ventas paginadas
     */
    public function getSalePaginateData(Brand $brand, string $key, int $currentPage = 0): Brand
    {
        if ($currentPage > 0) {
            $brand[$key] = $brand->sales()->paginate($this->PAGINATE, ['*'], 'page', $currentPage);
        } else {
            $brand[$key] = $brand->sales()->paginate($this->PAGINATE);
        }

        $brand->$key->each(function ($sale) {
            $this->setSaleData($sale);
        });

        return $brand;
    }
}
