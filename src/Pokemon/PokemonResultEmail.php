<?php

namespace App\Pokemon;

use App\Email\ResultEmailInterface;

class PokemonResultEmail implements ResultEmailInterface {

    public function buildResultEmail(array $emailData): string
    {
        return "<h1>Hello</h1>";
    }


}