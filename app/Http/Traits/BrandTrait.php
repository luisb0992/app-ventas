<?php

/**
 * Trait BrandTrait
 *
 * Gestiona todas las funcionalidades de las marcas
 * - Storage
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Http\Traits;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait BrandTrait
{
    /**
     * Almacena el logo de la marca
     *
     * @param UploadedFile $file    Archivo subido
     * @return String               Nombre del archivo
     */
    public function uploadFile(UploadedFile $file): String
    {

        // $file->getClientOriginalName();
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
}
