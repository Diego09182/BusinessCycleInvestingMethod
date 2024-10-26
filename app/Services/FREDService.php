<?php

namespace App\Services;

use GuzzleHttp\Client;

class FREDService
{
    protected $client;

    protected $apiKey;

    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client;
        $this->apiKey = env('FRED_API_KEY');
        $this->baseUrl = 'https://api.stlouisfed.org/fred/series/';
    }

    public function getUnemploymentRate()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'UNRATE',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getInflationRate()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'CPIAUCSL',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getRealGDPGrowthRate()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'A191RL1Q225SBEA',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getProducerPriceIndex()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'PPIACO',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getManufacturersNewOrders()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'AMTUNO',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 48,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-2 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getManufacturersInventoriesToSalesRatio()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'ISRATIO',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCompositeLeadingIndicator()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'NOFDISA066MSFRBNY',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getInitialClaims()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'ICSA',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'frequency' => 'w',
                'limit' => 52,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCorporateProfitsAfterTax()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'CP',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-1 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getRealImportsOfGoodsAndServices()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'IMPGSCA',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-2 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function federalFundsEffectiveRate()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'DFF',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-2 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function m2()
    {
        $response = $this->client->get($this->baseUrl.'observations', [
            'query' => [
                'series_id' => 'WM2NS',
                'api_key' => $this->apiKey,
                'file_type' => 'json',
                'limit' => 24,
                'sort_order' => 'asc',
                'observation_start' => date('Y-m-d', strtotime('-2 year')),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
