<?php

namespace App\Item;

use App\Search\PokeApiSearchInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class ItemSearch implements PokeApiSearchInterface {

    const ITEM_URL = "https://pokeapi.co/api/v2/item/";
    private Client $client;
    private ItemResponse $itemResponse;

    public function __construct(Client $client, ItemResponse $itemResponse) {
        $this->client = $client;
        $this->itemResponse = $itemResponse;
    }


    /**
     * @param string $value
     * @return array
     * @throws GuzzleException
     */
    public function get(string $value): array
    {
        try {
            $apiResponse = $this->client->get(self::ITEM_URL.$value);
        } catch (\Exception $e) {
            // what is the exception?
            $errorMessage = $e->getMessage();
            if (404 === $e->getCode()) {
                // 404 means the Location doesn't exist - Display a nicer error message
                $errorMessage = "Hmmm - We can't seem to find an item named {$value} - Is it spelt correctly?";
            }
            return [
                'error' => true,
                'data'  => $errorMessage
            ];
        }

        $itemData = json_decode($apiResponse->getBody()->getContents());
        $this->itemResponse->setName($itemData->name);
        $this->itemResponse->setCategory($itemData->category->name);
        $this->itemResponse->setImageUrl($itemData->sprites->default);
        $this->itemResponse->setDescriptionText($itemData->flavor_text_entries[0]->text);
        $this->itemResponse->setEffectText($itemData->effect_entries[0]->short_effect);

        return [
            'error' => false,
            'data' => $this->itemResponse
        ];
    }

    /**
     * @param string $areaUrl
     * @return array
     * @throws GuzzleException
     */
    private function getAreaData(string $areaUrl): array {
        try {
            $apiResponse = $this->client->get($areaUrl);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'data'  => $e->getMessage()
            ];
        }

        return [
            'error' => false,
            'data'  => json_decode($apiResponse->getBody()->getContents())
        ];
    }


    //TODO - Any extra item specific validation
    public function searchTermsAreValid(string $searchTerm): bool
    {
        return true;
    }
}