<?php

namespace App\Services;

use GuzzleHttp\Client;

class GovernmentDataService
{
    protected $client;
    protected $resourceID;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->resourceID = 'A17030000J-000016-xC8';
        $this->baseUrl = "https://apiservice.mol.gov.tw/OdService/rest/datastore/{$this->resourceID}";
    }

    public function fetchData($limit = 32, $offset = 0)
    {
        $params = [
            'limit' => $limit,
            'offset' => $offset
        ];

        return $this->makeRequest($params);
    }
    
    protected function makeRequest(array $params)
    {
        try {

            $url = $this->baseUrl . '?' . http_build_query($params);
            $response = $this->client->get($url);
            
            if ($response->getStatusCode() !== 200) {
                return ['error' => 'Invalid response from API'];
            }
    
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => 'API request failed'];
        }
    }
}