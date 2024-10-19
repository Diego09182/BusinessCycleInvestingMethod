<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NewsApiService
{
    protected $apiKey;
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('NEWSAPI_KEY');
        $this->client = new Client();
        $this->baseUrl = 'https://newsapi.org/v2/top-headlines';
    }

    public function getTopHeadlines($country = 'us', $category = 'business', $max = 8)
    {
        $params = [
            'country' => $country,
            'category' => $category,
            'apiKey' => $this->apiKey,
            'pageSize' => $max
        ];

        return $this->makeRequest($params);
    }

    protected function makeRequest(array $params)
    {
        try {
            $url = $this->baseUrl . '?' . http_build_query($params);
            $response = $this->client->get($url);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('News API request failed: ' . $e->getMessage());
            return ['error' => 'API request failed'];
        }
    }
}
