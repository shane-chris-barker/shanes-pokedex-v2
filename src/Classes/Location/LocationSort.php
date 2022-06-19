<?php

namespace App\Classes\Location;

use App\Services\PokeApiSortInterface;

class LocationSort implements PokeApiSortInterface {

    public function sort(array $data): array
    {
        return [];

    }

}