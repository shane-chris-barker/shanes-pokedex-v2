<?php

namespace App\Classes;

use App\Classes\Location\LocationSort;
use App\Classes\Pokemon\PokemonSort;
use App\Services\PokeApiSortInterface;

class Sort {

    private array $sorts;

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
     * @return array
     */
    public function getPossibleSorts(): array
    {
        $sorts = [];

        foreach ($this->sorts as $key => $value) {
            $sorts[$key] = $value;
        }

        return $sorts;
    }

    /**
     * @param array $data
     * @param PokeApiSortInterface $sortInterface
     * @return array
     */
    public function sort(array $data, PokeApiSortInterface $sortInterface): array
    {
        return $sortInterface->sort($data);
    }
}