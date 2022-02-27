<?php

/**
 * Gestiona todos los path de los archivos de la app
 *
 * @author  luisbardev <luisbardev@gmail.com> luisbardev.com
 */

namespace App\Utils;

class AppFilePath
{
  /**
   * Path para carpeta de los archivos de los logos de cada marcas
   *
   * @return string         Path completo
   */
  public static function brandLogos(): string
  {
    return url('/') . '/storage/' . config('brands.folder') . '/';
  }

  /**
   * Path para carpeta de los archivos de los
   * comprobantes o distintos archivos de cada ventas
   *
   * @return string        Path completo
   */
  public static function saleVouchers(): string
  {
    return url('/') . '/storage/' . config('sales.folder') . '/';
  }
}
