<?php

namespace App\Sort;
class Sort {

    private array $sorts;

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