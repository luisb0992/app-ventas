<?php

/**
 * Gestiona todas las datos necesarios para el componente principal de gráficos
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Utils;

use App\Models\Brand;
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

  /**
   * Devuelve un array con los meses del año seleccionado
   * con la colección de ventas de todas las marcas sumadas
   *
   * @param Brand $brand        La Marca
   * @param integer $year       El año (default o actual)
   * @return array              Array con los meses del año seleccionado
   */
  public static function getSumSalesByMonth(Brand $brand, int $year = 0): array
  {
    // si no se especifica el año, se toma el actual
    $year = $year ? $year : date('Y');

    // se obtienen las ventas de la marca en el año especificado
    $sales = $brand->sales()->whereYear('created_at', $year)->get();

    // agregar un array con los meses y sus respectivas ventas
    $salesByMonth = [];

    // se obtienen todos los meses del año y  se suman sus respectivas ventas
    $salesByMonth = $sales->groupBy(fn ($sale) => (int) $sale->created_at->format('m'))
      ->map(fn ($sale) => $sale->sum('amount'));

    // rellenar los demás meses faltantes con 0
    self::fillMissingMonths($salesByMonth);

    // ordenar las ventas por mes (de menor a mayor)
    $salesByMonth = $salesByMonth->sortKeys();

    // eliminar las keys del array
    $salesByMonth = $salesByMonth->values();

    // retornar el array con las ventas por mes
    return $salesByMonth->toArray();
  }

  /**
   * Devuelve un array con los días del mes faltantes
   *
   * @param Array|Object $data      La data a evaluar
   * @return void                   Array con los días del mes faltantes
   */
  public static function fillMissingMonths($data)
  {

    for ($i = 1; $i <= 12; $i++) {
      if (!isset($data[$i])) {
        $data[$i] = 0;
      }
    }

    return $data;
  }
}
