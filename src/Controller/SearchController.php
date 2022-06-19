<?php

namespace App\Controller;

use App\Classes\Search;
use App\Classes\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private Search $search;
    private Sort $sort;
    public function __construct(Search $search, Sort $sort) {
        $this->search   = $search;
        $this->sort     = $sort;
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/search/{name}', name: 'pokedex_get', methods: ['GET'])]
    public function search(Request $request): Response
    {
        $searchTerm     = strtolower($request->get('name')); // PokeApi expects lower case
        $searchType     = $request->get('searchType');
        $searchType     = 'pokemon';
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

        // do the search
        $searches       = $this->search->getPossibleSearches();
        $apiResponse    = $this->search->doSearch($searchTerm, $searches[$searchType]);

        // do the sort
        $sorts          = $this->sort->getPossibleSorts();
        $sortedData     = $this->sort->sort($apiResponse, $sorts[$searchType]);

        $response->setContent(json_encode($sortedData));
        return $response;
    }
}
