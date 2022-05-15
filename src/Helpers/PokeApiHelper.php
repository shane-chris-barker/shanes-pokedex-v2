<?php

namespace App\Helpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PokeApiHelper {

    const POKEMON_ENDPOINT = "https://pokeapi.co/api/v2/pokemon/";
    const SPECIES_ENDPOINT = "https://pokeapi.co/api/v2/pokemon-species/";

    private Client $guzzleClient;
    public function __construct(Client $guzzleClient) {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $searchTerm
     * @param bool $speciesOnly
     * @param bool $andGetAbilities
     * @return array
     * @throws GuzzleException
     */
    public function getPokemon(string $searchTerm, bool $speciesOnly = false, bool $andGetAbilities = false) : array {

        // get basic info or full species data?
        $endpoint = (true === $speciesOnly) ? self::SPECIES_ENDPOINT : self::POKEMON_ENDPOINT;
        try {
            $apiResponse = $this->guzzleClient->get($endpoint.$searchTerm);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'data'  => $e->getMessage()
            ];
        }

        $decodedData['data'] = json_decode($apiResponse->getBody()->getContents());

        if ($andGetAbilities) {
            $i = 0;
            foreach($decodedData['data']->abilities as $ability) {

                try {
                    $apiResponse = $this->guzzleClient->get($ability->ability->url);
                } catch (\Exception $e) {
                    return [
                        'error' => true,
                        'data'  => $e->getMessage()
                    ];
                }
                $decodedData['data']->abilities[$i]->name = $ability->ability->name;
                $decodedData['data']->abilities[$i]->data = json_decode($apiResponse->getBody()->getContents());
                $i++;
            }
        }

        $decodedData['error']   = false;

        return $decodedData;
    }
}