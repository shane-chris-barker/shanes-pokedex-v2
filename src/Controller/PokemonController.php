<?php

namespace App\Controller;

use App\Helpers\PokeApiHelper;
use App\Helpers\PokemonDataHelper;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    private PokemonDataHelper $pokemonDataHelper;
    private PokeApiHelper $pokeApiHelper;
    public function __construct(PokemonDataHelper $pokemonDataHelper, PokeApiHelper $pokeApiHelper) {

        $this->pokemonDataHelper    = $pokemonDataHelper;
        $this->pokeApiHelper        = $pokeApiHelper;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws GuzzleException
     */
    #[Route('/pokemon/{name}', name: 'pokedex_get', methods: ['GET'])]
    public function getPokemon(Request $request)
    {
        $searchTerm     = strtolower($request->get('name')); // PokeApi expects lower case
        $error          = false;
        $errorArray     = [];
        $data           = [];
        $apiResponse    = null;

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        // if we don't have a search term, return an error to that effect
        if (empty($searchTerm)) {
            $errorArray =  [
                'error' => true,
                'data'  => "No search term provided"
            ];
            $response->setContent(json_encode($errorArray));
            return $response;
        }

        // get basic pokemon data and species data too
        $apiResponse            = $this->pokeApiHelper->getPokemon($searchTerm, false, true);

        // probably a 404 and the name searched for is a typo or something - let the front end know
        if ($apiResponse['error'] === true) {
            $response->setContent(json_encode($apiResponse));
            return $response;
        }

        $apiResponse['species'] = $this->pokeApiHelper->getPokemon($searchTerm, true);
        $data['name']       = ucfirst($searchTerm);
        $data['abilities']  = $this->pokemonDataHelper->sortAbilities($apiResponse['data']->abilities);
        $data['games']      = $this->pokemonDataHelper->getGamesAppearedIn($apiResponse['data']->game_indices);
        $data['images']     = $this->pokemonDataHelper->getSprites($apiResponse['data']->sprites);
        $data['pokedex']    = $this->pokemonDataHelper->getPokedexData($apiResponse['species']['data']);
        $data['stats']      = $this->pokemonDataHelper->getStats($apiResponse['data']->stats);


        $response->setContent(json_encode($data));
        return $response;
    }
}
