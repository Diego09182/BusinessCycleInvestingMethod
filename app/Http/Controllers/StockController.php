<?php

namespace App\Http\Controllers;

use App\Services\TwseApiService;
use App\Services\NewsApiService;
use App\Services\FREDService;
use App\Services\GovernmentDataService;
use Illuminate\Http\Request;
use App\Models\Asset;

class StockController extends Controller
{
    protected $twseApiService;

    public function __construct(
        TwseApiService $twseApiService, 
    ) {
        $this->twseApiService = $twseApiService;
    }

    public function stock(Request $request)
    {
        $symbol = $request->input('custom_symbol') ?: $request->input('preset_symbol', '006208');
        $data = $this->twseApiService->getHistoricalStockData($symbol);

        return response()->json([
            'data' => $data,
            'symbol' => $symbol,
        ]);
    }
}
