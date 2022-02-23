<?php

/**
 * Trait SaleTrait
 *
 * Gestiona todas las funcionalidades extras de las ventas
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Http\Traits;

use App\Models\Sale;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait SaleTrait
{
    /**
     * Almacena el logo de la marca
     *
     * @param UploadedFile $file    Archivo subido
     * @return String               Nombre del archivo
     */
    public function uploadSaleFile(UploadedFile $file): String
    {

        // $file->getClientOriginalName();
        // nombre para el archivo
        $extension = $file->getClientOriginalExtension();
        $filename = 'file-' . time() . '.' . $extension;

        // guardar el archivo en el storage
        Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs(
            config('sales.folder'),
            $file,
            $filename
        );

        return $filename;
    }
}
