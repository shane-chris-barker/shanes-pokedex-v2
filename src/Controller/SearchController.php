<?php

namespace App\Controller;

use App\Item\ItemSearch;
use App\Location\LocationSearch;
use App\Pokemon\PokemonSearch;
use App\Pokemon\PokemonSort;
use App\Search\Search;
use App\Services\ResponderService;
use App\Sort\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private Search $search;
    private Sort $sort;
    private ResponderService $responderService;
    public function __construct(Search $search, Sort $sort, ResponderService $responderService) {
        $this->search           = $search;
        $this->sort             = $sort;
        $this->responderService = $responderService;
    }

    /**
     * @param String $name
     * @param PokemonSearch $pokemonSearch
     * @param PokemonSort $pokemonSort
     * @return Response
     */
    #[Route('/pokemon/{name}', name: 'pokemon_get', methods: ['GET'])]
    public function searchForPokemon(
        string $name,
        PokemonSearch $pokemonSearch,
        PokemonSort $pokemonSort
    ): Response
    {
        $response = $this->responderService->createResponse();

        // do the search
        if (false === $this->search->searchTermsAreValid($name, $pokemonSearch)) {
            $errorArray =  [
                'error' => true,
                'data'  => "No search term provided"
            ];
            $response->setContent(json_encode($errorArray));
            return $response;
        }
        $apiResponse  = $this->search->doSearch($name, $pokemonSearch);

        if (true === $apiResponse['error']) { // didn't find anything
            $response->setContent(json_encode($apiResponse));
            return $response;
        }

        $sortedData = $this->sort->sort($apiResponse,  $pokemonSort);
        $response->setContent(json_encode($sortedData));
        return $response;
    }

    /**
     * @param String $name
     * @param LocationSearch $locationSearch
     * @return Response
     */
    #[Route('/location/{name}', name: 'location_get', methods: ['GET'])]
    public function searchForLocation(
        string $name,
        LocationSearch $locationSearch
    ): Response
    {
        $response = $this->responderService->createResponse();

        if (false === $this->search->searchTermsAreValid($name, $locationSearch)) {
            $errorArray =  [
                'error' => true,
                'data'  => "The search term was invalid"
            ];
            $response->setContent(json_encode($errorArray));
            return $response;
        }

        // do the search
        $apiResponse  = $this->search->doSearch($name, $locationSearch);
        if (true === $apiResponse['error']) { // didn't find anything
            $response->setContent(json_encode($apiResponse));
            return $response;
        }

        // location data is so simple that we don't need a sort method.
        $response->setContent(json_encode($apiResponse));

        return $response;
    }

    /**
     * @param String $name
     * @param ItemSearch $itemSearch
     * @return Response
     */
    #[Route('/item/{name}', name: 'item_get', methods: ['GET'])]
    public function searchForItem(
        string $name,
        ItemSearch $itemSearch,
    ): Response
    {
        $response = $this->responderService->createResponse();

        // if we don't have a search term, return an error to that effect
        if (false === $this->search->searchTermsAreValid($name, $itemSearch)) {
            $errorArray =  [
                'error' => true,
                'data'  => "No search term provided"
            ];
            $response->setContent(json_encode($errorArray));
            return $response;
        }

        // do the search
        $apiResponse  = $this->search->doSearch($name, $itemSearch);

        if (true === $apiResponse['error']) { // didn't find anything
            $response->setContent(json_encode($apiResponse));
            return $response;
        }

        $response->setContent(json_encode($apiResponse));
        return $response;
    }
}
