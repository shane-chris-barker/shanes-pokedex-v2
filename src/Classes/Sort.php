<?php

namespace App\Classes;

use App\Classes\Location\LocationSearch;
use App\Classes\Location\LocationSort;
use App\Classes\Pokemon\PokemonSearch;
use App\Classes\Pokemon\PokemonSort;
use App\Services\PokeApiSortInterface;

class Sort {

    /**
     * @param LocationSort $locationSort
     * @param PokemonSort $pokemonSort
     */
    public function __construct(LocationSort $locationSort, PokemonSort $pokemonSort) {
        $this->sorts = [
            'location' => $locationSort,
            'pokemon'  => $pokemonSort
        ];
    }



    /**
     * @param array $data
     * @param PokeApiSortInterface $sortInterface
     * @return array
     */
    public function sort(array $data, PokeApiSortInterface $sortInterface) {
        return $sortInterface->sort($data);
    }
}