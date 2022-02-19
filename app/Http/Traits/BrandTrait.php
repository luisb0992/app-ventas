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
}
