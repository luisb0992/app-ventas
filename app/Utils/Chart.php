<?php

/**
 * Gestiona todas las datos necesarios para el componente principal de gráficos
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Utils;

use Illuminate\Support\Collection;

class Chart
{
  /**
   * Devuelve la suma de todas las ventas por marca
   *
   * @param Collection $brands      Colección de marcas
   * @return Collection             Colección de marcas con las sumas de ventas de cada marca
   */
  public static function getSumDataBrands(Collection $brands): Collection
  {
    $brands->each(function ($brand) {
      $brand->sumSales = $brand->sales()->sum('amount');
    });

    return $brands;
  }

  /**
   * Devuelve la suma de todas las ventas de todas las marcas
   *
   * @param Collection $brands    Colección de marcas
   * @return decimal              Suma de todas las ventas
   */
  public static function getSumAllSales(Collection $brands)
  {
    $sumAllSales = 0;

    $brands->each(function ($brand) use (&$sumAllSales) {
      $sumAllSales += $brand->sales()->sum('amount');
    });

    return $sumAllSales;
  }

  /**
   * Devuelve la colección de ventas de todas las marcas sumadas por año (actual)
   *
   * @param Collection $brands      Colección de marcas
   * @return Collection             Colección de marcas con las sumas de ventas de cada marca
   */
  public static function getYearlyData(Collection $brands): Collection
  {
    $brands->each(function ($brand) {
      $brand->sumSales = $brand->sales()
        ->whereYear('created_at', date('Y'))
        ->sum('amount');
    });

    return $brands;
  }

  /**
   * Devuelve la colección de ventas de todas las marcas sumadas por mes (actual)
   *
   * @param Collection $brands      Colección de marcas
   * @return Collection             Colección de marcas con las sumas de ventas de cada marca
   */
  public static function getMonthlyData(Collection $brands): Collection
  {
    $brands->each(function ($brand) {
      $brand->sumSales = $brand->sales()
        ->whereYear('created_at', date('Y'))
        ->whereMonth('created_at', date('m'))
        ->sum('amount');
    });

    return $brands;
  }

  /**
   * Devuelve la colección de ventas de todas las marcas sumadas por dia (actual)
   *
   * @param Collection $brands      Colección de marcas
   * @return Collection             Colección de marcas con las sumas de ventas de cada marca
   */
  public static function getDailyData(Collection $brands): Collection
  {
    $brands->each(function ($brand) {
      $brand->sumSales = $brand->sales()
        ->whereYear('created_at', date('Y'))
        ->whereMonth('created_at', date('m'))
        ->whereDay('created_at', date('d'))
        ->sum('amount');
    });

    return $brands;
  }
}
