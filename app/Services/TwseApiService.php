<?php

namespace App\Services;

use GuzzleHttp\Client;

class TwseApiService
{
    protected $client;

    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client;
        $this->baseUrl = 'https://www.twse.com.tw/exchangeReport/STOCK_DAY?response=json';
    }

    public function getHistoricalStockData($symbol)
    {
        $previousMonthDate = now()->subMonth()->format('Ymd');

        $params = [
            'date' => $previousMonthDate,
            'stockNo' => $symbol,
        ];

        return $this->makeRequest($params);
    }

    protected function makeRequest(array $params)
    {
        try {
            $url = $this->baseUrl.'&'.http_build_query($params);
            $response = $this->client->get($url);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => 'API request failed'];
        }
    }
}
