<?php

/**
 * Gestiona todas funcionalidades con firebase
 *
 * @author  luisbardev <luisbardev@gmail.com> luisbardev.com
 */

namespace App\Utils;

use Illuminate\Http\UploadedFile;

class Firebase
{

  /**
   * Guarda un archivo en firebase
   *
   * @param UploadedFile $file      Archivo subido
   * @param String  $folder         Carpeta donde se guardará el archivo
   * @return String                 Nombre del archivo
   */
  public static function uploadFile(UploadedFile $file, string $folder = ''): String
  {
    // conecta con firebase
    $storage = app('firebase.storage');

    // obtener el archivo
    $extension = $file->getClientOriginalExtension();

    // nombre para el archivo
    $filename = 'file-' . time() . '.' . $extension;

    // guardar el archivo en el storage con el folder indicado
    $storage->getBucket()->upload(
      fopen($file, 'r'),
      [
        'name' => $folder . $filename,
        'metadata' => [
          'contentType' => $file->getClientMimeType(),
        ],
      ]
    );

    return $filename;
  }
}
