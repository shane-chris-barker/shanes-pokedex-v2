<?php

namespace App\Search;

class Search {

    /**
     * @param string $searchTerm
     * @param PokeApiSearchInterface $searchInterface
     * @return array
     */
    public function doSearch(string $searchTerm, PokeApiSearchInterface $searchInterface): array {
        return $searchInterface->get($searchTerm);
    }

    /**
     * @param string $searchTerm
     * @param PokeApiSearchInterface $searchInterface
     * @return bool
     */
    public function searchTermsAreValid(string $searchTerm, PokeApiSearchInterface $searchInterface): bool {
        return !empty($searchTerm) && $searchInterface->searchTermsAreValid($searchTerm);
    }

}
