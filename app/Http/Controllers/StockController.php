<?php

namespace App\Http\Controllers;

use App\Services\TwseApiService;
use Illuminate\Http\Request;

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
