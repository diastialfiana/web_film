<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class OmdbService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'http://www.omdbapi.com/';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OMDB_API_KEY');
    }

    /**
     * Search movies by title.
     *
     * @param string $query
     * @param string $type
     * @param string $year
     * @param int $page
     * @return array
     * @throws Exception
     */
    public function search($query, $type = '', $year = '', $page = 1)
    {
        try {
            $params = [
                'apikey' => $this->apiKey,
                's' => $query,
                'page' => $page,
            ];

            if ($type) {
                $params['type'] = $type;
            }

            if ($year) {
                $params['y'] = $year;
            }

            $response = $this->client->get($this->baseUrl, [
                'query' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            return ['Response' => 'False', 'Error' => $e->getMessage()];
        }
    }

    /**
     * Get movie detail by IMDb ID.
     *
     * @param string $imdbId
     * @return array
     * @throws Exception
     */
    public function getById($imdbId)
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'apikey' => $this->apiKey,
                    'i' => $imdbId,
                    'plot' => 'full'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            return ['Response' => 'False', 'Error' => $e->getMessage()];
        }
    }
}
