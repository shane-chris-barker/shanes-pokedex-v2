<?php

namespace App\Location;

class LocationResponse
{
    public string $name;
    public string $region;
    public string $area;
    public array $pokemonEncounters;

    public function __construct()
    {
        $this->name = '';
        $this->region = '';
        $this->area = "";
        $this->pokemonEncounters = [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * Removes any '-'s and adds capitals where needed
     */
    public function setName(string $name): void
    {
        $this->name = ucwords(str_replace('-', ' ', $name));
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = ucwords(str_replace('-', ' ', $region));
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->area = ucwords(str_replace('-', ' ', $area));
    }

    /**
     * @return array
     */
    public function getPokemonEncounters(): array
    {
        return $this->pokemonEncounters;
    }

    /**
     * @param array $pokemonEncounters
     */
    public function setPokemonEncounters(array $pokemonEncounters): void
    {
        $this->pokemonEncounters = $pokemonEncounters;
    }
}
