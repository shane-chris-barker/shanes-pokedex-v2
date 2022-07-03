<?php

namespace App\Pokemon;

use App\Search\PokeApiSearchInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PokemonSearch implements PokeApiSearchInterface {

    const POKEMON_ENDPOINT = "https://pokeapi.co/api/v2/pokemon/";
    const SPECIES_ENDPOINT = "https://pokeapi.co/api/v2/pokemon-species/";

    private Client $guzzleClient;
    public function __construct(Client $guzzleClient) {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $value
     * @return array
     * @throws GuzzleException
     */
    public function get(string $value): array
    {
        try {
            $apiResponse = $this->guzzleClient->get(self::POKEMON_ENDPOINT.$value);
        } catch (\Exception $e) {
            // what is the exception?
            $errorMessage = $e->getMessage();
            if (404 === $e->getCode()) {
                // 404 means the Pokemon doesn't exist - Display a nicer error message
                $errorMessage = "Hmmm - We can't seem to find a Pokemon named {$value} - Is it spelt correctly?";
            }
            return [
                'error' => true,
                'data'  => $errorMessage
            ];
        }

        $decodedData['data'] = json_decode($apiResponse->getBody()->getContents());

        // we managed to find the basic info for the search term - Go and get the species and ability data
        // TODO SRP Principle - move this to its own method
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

        $decodedData['species']['data'] = $this->getSpeciesData($value);

        // and finally, get any evolutions chains
        $decodedData['evolution'] = $this->getEvolutionChain(
            $decodedData['species']['data']->evolution_chain->url,
            $value,
            $decodedData['data']->sprites->front_default
        );

        $decodedData['error'] = false;

        return $decodedData;

    }

    /**
     * @param string $evolutionUrl
     * @param string $pokemonName
     * @param string $selectedPokemonImageUrl
     * @return array
     * @throws GuzzleException
     */
    private function getEvolutionChain(string $evolutionUrl, string $pokemonName, string $selectedPokemonImageUrl): array {
        $data = [];
        try {
            $apiResponse = $this->guzzleClient->get($evolutionUrl);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'data'  => $e->getMessage()
            ];
        }

        $evolutionData                      = json_decode($apiResponse->getBody()->getContents());
        $data['chain'][0]['name']           = ucfirst($evolutionData->chain->species->name);
        $data['chain'][0]['isBaby']         = $evolutionData->chain->is_baby;
        // is this the Pokemon being searched for or is it an evolution of the Pokemon being searched for?
        $data['chain'][0]['currentResult']  = false;
        $data['chain'][0]['stage']          = (true === $data['chain'][0]['isBaby']) ? 'Baby' : 'Basic';
        $data['chain'][0]['image']          = $selectedPokemonImageUrl;

        if (ucfirst($data['chain'][0]['name']) === ucfirst($pokemonName)) {
            $data['chain'][0]['currentResult'] = true;
        }

        // if we have a count, it's safe to assume that array key 0 exists
        if (count($evolutionData->chain->evolves_to) > 0) {

            // TODO a single Pokemon may have multiples evolves to, based on whatever form it is - need to handle this
            $data['chain'][1]['name']           = ucwords($evolutionData->chain->evolves_to[0]->species->name);
            $data['chain'][1]['isBaby']         = $evolutionData->chain->evolves_to[0]->is_baby;
            $data['chain'][1]['currentResult']  = false;
            $data['chain'][1]['stage']          = (true === $data['chain'][0]['isBaby']) ? 'Basic' : 'Stage One';

            if (ucfirst($data['chain'][1]['name']) === ucfirst($pokemonName)) {
                $data['chain'][1]['currentResult'] = true;
            }

            // if evolution has 2 stages, we'll go up the chain here
            if (array_key_exists(0, $evolutionData->chain->evolves_to[0]->evolves_to)) {
                $data['chain'][2]['name']           = ucwords($evolutionData->chain->evolves_to[0]->evolves_to[0]->species->name);
                $data['chain'][2]['isBaby']         = $evolutionData->chain->evolves_to[0]->evolves_to[0]->is_baby;
                $data['chain'][2]['currentResult']  = false;

                if (ucfirst($data['chain'][2]['name']) === ucfirst($pokemonName)) {
                    $data['chain'][2]['currentResult'] = true;
                }
                $data['chain'][2]['stage'] =  (true === $data['chain'][0]['isBaby']) ? 'Stage One' : 'Stage Two';
            }

            // right, we've sorted the data for the evolutions, just call the generic Pokemon endpoint so
            // that we can grab the sprites for the evolution chain
            $i = 0;
            foreach ($data['chain'] as $evolution) {
                // we don't need to call and get data for the Pokemon that was initially searched for.
                try {
                    $response       = $this->guzzleClient->get(self::POKEMON_ENDPOINT.lcfirst($evolution['name']));
                    $evolvedApiData = json_decode($response->getBody()->getContents());

                } catch (\Exception $e) {
                    return [
                        'error' => true,
                        'data'  => $e->getMessage()
                    ];
                }
                $data['chain'][$i]['image'] = $evolvedApiData->sprites->front_default;
                $i++;
            }
        }
        return $data;
    }

    private function getSpeciesData(string $evolutionName) : object
    {
        $speciesResponse = $this->guzzleClient->get(self::SPECIES_ENDPOINT.$evolutionName);
        return json_decode($speciesResponse->getBody()->getContents());
    }

    //TODO - Any extra Pokemon specific validation
    public function searchTermsAreValid(string $searchTerm): bool
    {
        return true;
    }


}