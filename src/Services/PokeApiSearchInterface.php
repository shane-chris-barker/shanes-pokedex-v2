<?php

namespace App\Services;

interface PokeApiSearchInterface {

    public function get(string $value) : array;

}