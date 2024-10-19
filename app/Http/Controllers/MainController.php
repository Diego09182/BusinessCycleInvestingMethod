<?php

namespace App\Http\Controllers;

use App\Services\TwseApiService;
use App\Services\NewsApiService;
use App\Services\FREDService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $twseApiService;
    protected $newsApiService;
    protected $fredService;

    public function __construct(TwseApiService $twseApiService, NewsApiService $newsApiService, FREDService $fredService)
    {
        $this->twseApiService = $twseApiService;
        $this->newsApiService = $newsApiService;
        $this->fredService = $fredService;
    }

    public function index(Request $request)
    {
        $symbol = $request->input('custom_symbol') ?: $request->input('preset_symbol', '0050');

        $data = $this->twseApiService->getHistoricalStockData($symbol);
        $newsData = $this->newsApiService->getTopHeadlines();
        $unemploymentData = $this->fredService->getUnemploymentRate();
        $inflationData = $this->fredService->getInflationRate();
        $gdpGrowthData = $this->fredService->getRealGDPGrowthRate();
        $producerPriceIndexData = $this->fredService->getProducerPriceIndex();
        $manufacturersNewOrdersData = $this->fredService->getManufacturersNewOrders();
        $inventoriesToSalesRatioData = $this->fredService->getManufacturersInventoriesToSalesRatio();
        $compositeLeadingIndicatorData = $this->fredService->getCompositeLeadingIndicator();
        $initialClaimsData = $this->fredService->getInitialClaims();
        $corporateProfitsData = $this->fredService->getCorporateProfitsAfterTax();
        $realImportsData = $this->fredService->getRealImportsOfGoodsAndServices();

        return view('main', compact(
            'data', 
            'symbol', 
            'newsData', 
            'unemploymentData', 
            'inflationData', 
            'gdpGrowthData', 
            'producerPriceIndexData', 
            'manufacturersNewOrdersData', 
            'inventoriesToSalesRatioData', 
            'compositeLeadingIndicatorData', 
            'initialClaimsData', 
            'corporateProfitsData', 
            'realImportsData'
        ));
    }

    public function request(Request $request)
    {
        $symbol = $request->input('custom_symbol') ?: $request->input('preset_symbol', '0050');

        $data = $this->twseApiService->getHistoricalStockData($symbol);
        $newsData = $this->newsApiService->getTopHeadlines();
        $unemploymentData = $this->fredService->getUnemploymentRate();
        $inflationData = $this->fredService->getInflationRate();
        $gdpGrowthData = $this->fredService->getRealGDPGrowthRate();
        $producerPriceIndexData = $this->fredService->getProducerPriceIndex();
        $manufacturersNewOrdersData = $this->fredService->getManufacturersNewOrders();
        $inventoriesToSalesRatioData = $this->fredService->getManufacturersInventoriesToSalesRatio();
        $compositeLeadingIndicatorData = $this->fredService->getCompositeLeadingIndicator();
        $initialClaimsData = $this->fredService->getInitialClaims();
        $corporateProfitsData = $this->fredService->getCorporateProfitsAfterTax();
        $realImportsData = $this->fredService->getRealImportsOfGoodsAndServices();

        return response()->json([
            'data' => $data,
            'symbol' => $symbol,
            'newsData' => $newsData,
            'unemploymentData' => $unemploymentData,
            'inflationData' => $inflationData,
            'gdpGrowthData' => $gdpGrowthData,
            'producerPriceIndexData' => $producerPriceIndexData,
            'manufacturersNewOrdersData' => $manufacturersNewOrdersData,
            'inventoriesToSalesRatioData' => $inventoriesToSalesRatioData,
            'compositeLeadingIndicatorData' => $compositeLeadingIndicatorData,
            'initialClaimsData' => $initialClaimsData,
            'corporateProfitsData' => $corporateProfitsData,
            'realImportsData' => $realImportsData
        ]);
    }

}