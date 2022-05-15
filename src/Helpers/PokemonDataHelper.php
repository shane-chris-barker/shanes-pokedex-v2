<?php

namespace App\Helpers;

class PokemonDataHelper {

    /**
     * @param array $abilities
     * @return array
     */
    public function sortAbilities(array $abilities): array
    {
        $abilityArray       = [];
        $abilityCount       = 0;

        foreach ($abilities as $ability) {

            $abilityArray[$abilityCount]['name'] = ucwords(str_replace('-', " ", $ability->ability->name));
            $abilityArray[$abilityCount]['hidden'] = $ability->is_hidden;

            // any overworld effects
            if (array_key_exists(0, $ability->data->effect_changes)) {
                foreach ($ability->data->effect_changes[0]->effect_entries as $effect) {
                    if ($effect->language->name === 'en') {
                        $abilityArray[$abilityCount]['effect'] = $effect->effect;
                    }
                }
            }

            // the effects
            foreach ($ability->data->effect_entries as $effect) {
                if ($effect->language->name === 'en') {
                    $abilityArray[$abilityCount]['affect'] = $effect->effect;
                }
            }

            $abilityCount++;
        }

        return $abilityArray;
    }

    /**
     * @param array $games
     * @return array
     */
    public function getGamesAppearedIn(array $games): array
    {
        $gameArray = [];
        $gameCount = 0;
        foreach ($games as $game)  {
            $gameArray[$gameCount]['name'] = (ucfirst($game->version->name));
            $gameCount++;
        }

        return $gameArray;
    }

    /**
     * @param object $pokemonSprites
     * @return array
     */
    public function getSprites(object $pokemonSprites) : array
    {
        $spriteData     = [];
        $i = 0;
        $spriteData['default']['back']['image']     = $pokemonSprites->back_default;
        $spriteData['default']['front']['image']    = $pokemonSprites->front_default;
        $spriteData['shiny']['front']['image']      = $pokemonSprites->front_shiny;
        $spriteData['shiny']['back']['image']       = $pokemonSprites->back_shiny;

        return $spriteData;
    }

    /**
     * @param object $speciesData
     * @return array
     */
    public function getPokedexData(object $speciesData) : array
    {
        $data                   = [];
        $data['happiness']      = $speciesData->base_happiness;
        $data['evolutionChain'] = $speciesData->evolution_chain;

        // do we have a pokedex description? We should have. Grab the first one.
        if (property_exists($speciesData, 'flavor_text_entries')) {
            if (count($speciesData->flavor_text_entries) > 0 ) {
                $data['pokedexDescription'] = $speciesData->flavor_text_entries[0]->flavor_text;
            }
        }

        return $data;
    }

}