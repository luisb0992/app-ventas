<?php

/**
 * Gestiona todas funcionalidades con los archivos a ser guardados
 *
 * @author  luisbardev <luisbardev@gmail.com> luisbardev.com
 */

namespace App\Http\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait StorageApp
{

  /**
   * Propiedad para manipular la instancia de storage
   *
   * @var Storage
   */
  public $storage;

  /**
   * devuelve la instancia de storage junto con el disco a utilizar
   */
  public function __construct()
  {

    // $this->storage = $storage;
    $this->storage = Storage::disk(env('FILESYSTEM_DRIVER', 'local'));

    // $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
    // $response = $dropbox->createSharedLinkWithSettings(
    //   $filename,
    //   ["requested_visibility" => "public"]
    // );
  }

  /**
   * Guarda un archivo en dropbox
   *
   * @param UploadedFile $file      Archivo a subir
   * @param String  $folder         Carpeta donde se guardará el archivo
   * @return String                 Nombre del archivo
   */
  public function uploadFile(UploadedFile $file, string $folder = '/'): ?String
  {
    // nombre para el archivo
    $extension = $file->getClientOriginalExtension();
    $filename = 'file-' . time() . '.' . $extension;

    $isSave = $this->storage->putFileAs(
      $folder,
      $file,
      $filename
    );

    if (!$isSave) {
      return null;
    }

    return $filename;
  }

  /**
   * Descarga un archivo de dropbox
   *
   * @param string $filename      Nombre del archivo
   * @param string $folder        Carpeta donde se encuentra el archivo
   * @return Response             Archivo
   */
  public function downloadFile(string $filename, string $folder = ''): StreamedResponse
  {
    return $this->storage->download($folder . $filename);
  }

  /**
   * Elimina un archivo de dropbox
   *
   * @param string $filename      Nombre del archivo
   * @param string $folder        Carpeta donde se encuentra el archivo
   * @return boolean              True si se eliminó, false si no
   */
  public function deleteFile(string $filename, string $folder = ''): bool
  {
    return $this->storage->delete($folder . $filename);
  }

  /**
   * Devuelve el archivo de dropbox
   *
   * @param string $filename      Nombre del archivo
   * @param string $folder        Carpeta donde se encuentra el archivo
   * @return string               Archivo
   */
  public function getFile(string $filename, string $folder = ''): string
  {
    if ($this->storage->exists($folder . $filename)) {
      return $this->storage->get($folder . $filename);
    }

    return '';
  }

  /**
   * Devuelve una url dinámica para descargar un archivo de dropbox
   *
   * @param string $filename      Nombre del archivo
   * @param string $folder        Carpeta donde se encuentra el archivo
   * @return string               Path del archivo
   */
  public function getUrl(string $filename, string $folder = ''): string
  {
    return $this->storage->url($folder . $filename);
  }

  /**
   * Devuelve el path del archivo de dropbox
   *
   * @param string $filename      Nombre del archivo
   * @param string $folder        Carpeta donde se encuentra el archivo
   * @return string               Path del archivo
   */
  public function getPath(string $filename, string $folder = ''): string
  {
    return $this->storage->path($folder . $filename);
  }
}
