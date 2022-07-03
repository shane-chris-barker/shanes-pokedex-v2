<?php

namespace App\Location;

use App\Search\PokeApiSearchInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class LocationSearch implements PokeApiSearchInterface {

    const LOCATION_URL = "https://pokeapi.co/api/v2/location/";
    private Client $client;
    private LocationResponse $locationResponse;

    public function __construct(Client $client, LocationResponse $locationResponse) {
        $this->client = $client;
        $this->locationResponse = $locationResponse;
    }

    /**
     * @param string $value
     * @return array
     * @throws GuzzleException
     */
    public function get(string $value): array
    {
        try {
            $apiResponse = $this->client->get(self::LOCATION_URL.$value);
        } catch (\Exception $e) {
            // what is the exception?
            $errorMessage = $e->getMessage();
            if (404 === $e->getCode()) {
                // 404 means the Location doesn't exist - Display a nicer error message
                $errorMessage = "Hmmm - We can't seem to find a location named {$value} - Is it spelt correctly?";
            }

            return [
                'error' => true,
                'data'  => $errorMessage
            ];
        }

        $responseData   = json_decode($apiResponse->getBody()->getContents());
        $areaData       = [];

        if (property_exists($responseData, 'areas')) {
            $areaData = $this->getAreaData($responseData->areas[0]->url);
            $errorMessage = "Hmmm - There was a problem searching for {$value} - Please try again";
            if ($areaData['error']) {
                return [
                    'error' => true,
                    'data'  => $errorMessage
                ];
            }
        }

        $this->locationResponse->setName($responseData->name);
        $this->locationResponse->setArea($responseData->areas[0]->name);
        $this->locationResponse->setRegion($responseData->region->name);
        $this->locationResponse->setPokemonEncounters($areaData);

        if (!empty($areaData)) {
            $this->locationResponse->setPokemonEncounters($areaData['data']->pokemon_encounters);
        }

        return [
            'error' => false,
            'data' => $this->locationResponse
        ];
    }

    /**
     * @param string $areaUrl
     * @return array
     * @throws GuzzleException
     */
    private function getAreaData(string $areaUrl): array {
        try {
            $apiResponse = $this->client->get($areaUrl);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'data'  => $e->getMessage()
            ];
        }

        return [
            'error' => false,
            'data'  => json_decode($apiResponse->getBody()->getContents())
        ];
    }

    //TODO - Any extra Location specific validation
    public function searchTermsAreValid(string $searchTerm): bool
    {
        return true;
    }
}