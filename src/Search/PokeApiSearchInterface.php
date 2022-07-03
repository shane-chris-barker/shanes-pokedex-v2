<?php

namespace App\Search;

interface PokeApiSearchInterface {

    public function get(string $value) : array;

    public function searchTermsAreValid(string $searchTerm): bool;

}