<?php

namespace App\Classes;

use App\Classes\Location\LocationSearch;
use App\Classes\Pokemon\PokemonSearch;
use App\Services\PokeApiSearchInterface;


class Search {

    private array $possibleSearches;

    /**
     * @param LocationSearch $locationSearch
     * @param PokemonSearch $pokemonSearch
     */
    public function __construct(LocationSearch $locationSearch, PokemonSearch $pokemonSearch) {
        $this->possibleSearches = [
            'location' => $locationSearch,
            'pokemon'  => $pokemonSearch
        ];
    }


    /**
     * @param string $searchTerm
     * @param PokeApiSearchInterface $searchInterface
     * @return array
     */
    public function doSearch(string $searchTerm, PokeApiSearchInterface $searchInterface): array {
        $searchTermSlug = str_replace(" ", "-", $searchTerm);
        return $searchInterface->get($searchTermSlug);
    }

    /**
     * @return array
     */
    public function getPossibleSearches(): array
    {
        $searches = [];

        foreach ($this->possibleSearches as $key => $value) {
            $searches[$key] = $value;
        }

        return $searches;
    }



}