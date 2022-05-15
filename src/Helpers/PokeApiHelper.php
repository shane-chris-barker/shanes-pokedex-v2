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
            // what is the exception?
            $errorMessage = $e->getMessage();
            if (404 === $e->getCode()) {
                // 404 means the Pokemon doesn't exist - Display a nicer error message
                $errorMessage = "Hmmm - We can't seem to find a Pokemon named {$searchTerm} - Is it spelt correctly?";
            }
            return [
                'error' => true,
                'data'  => $errorMessage
            ];
        }

        $decodedData['data'] = json_decode($apiResponse->getBody()->getContents());

        // if we also want the Pokemon's abilities, we'll grab the info from the abilities endpoint
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