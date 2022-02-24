<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Utils\AppRedirect;
use App\Utils\Chart;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Rederiza el componente principal de gráficos
     * para el dashboard
     *
     * @return Response Inertia
     */
    public function index(): Response
    {
        // las marcas
        $brands = Brand::getOrderBrands();

        // la suma de todas las ventas de cada marca junto a la data de marcas
        $sumDataBrands = Chart::getSumDataBrands($brands);

        // la suma de todas las ventas de todas las marcas
        $sumAllSales = Chart::getSumAllSales($brands);

        return AppRedirect::inertiaRender('Chart/Index', [
            'brands'        => $sumDataBrands,
            'sumAllSales'   => $sumAllSales,
        ]);
    }
}
