<?php

namespace App\Controller;

use App\Email\ResultEmail;
use App\Location\LocationSearch;
use App\Location\LocationSort;
use App\Message\SendResultEmail;
use App\Pokemon\PokemonResultEmail;
use App\Pokemon\PokemonSearch;
use App\Pokemon\PokemonSort;
use App\Search\Search;
use App\Services\ResponderService;
use App\Sort\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class SendController extends AbstractController
{
    private Search $search;
    private Sort $sort;
    private ResponderService $responderService;
    private ResultEmail $resultEmail;
    public function __construct(Search $search, Sort $sort, ResponderService $responderService, ResultEmail $resultEmail) {
        $this->search           = $search;
        $this->sort             = $sort;
        $this->responderService = $responderService;
        $this->resultEmail      = $resultEmail;
    }

    #[Route('/send/result/pokemon/{name}/{email}', name: 'app_send_pokemon_result')]
    public function sendPokemonResult(
        string $name,
        string $email,
        MessageBusInterface $messageBus,
        PokemonSort $pokemonSort,
        PokemonSearch $pokemonSearch,
        PokemonResultEmail $pokemonResultEmail

    ): Response
    {
        $response       = $this->responderService->createResponse();
        $apiResponse    = $this->search->doSearch($name, $pokemonSearch);

        if (true === $apiResponse['error']) { // didn't find anything
            $response->setContent(json_encode($apiResponse));
            return $response;
        }
        $sortedData = $this->sort->sort($apiResponse, $pokemonSort);

        $this->resultEmail->setEmail($email);
        $this->resultEmail->setSearchTerm($name);
        $this->resultEmail->setData($sortedData);
        $this->resultEmail->buildResultEmail($pokemonResultEmail);
        $messageBus->dispatch(new SendResultEmail($this->resultEmail));

        $errorArray =  [
            'error' => false,
            'data'  => "Email Sent"
        ];
        $response->setContent(json_encode($errorArray));
        return $response;
    }

//    #[Route('/send/result/location/{name}/{email}', name: 'app_send_location_result')]
//    public function sendLocationResult(
//        string $name,
//        string $email,
//        string $type,
//        MessageBusInterface $messageBus,
//        LocationSearch $locationSearch,
//        LocationSort $locationSort
//    ): Response
//    {
//
//        $response = $this->responderService->createResponse();
//        $apiResponse = $this->search->doSearch($name, $locationSearch);
//
//        if (true === $apiResponse['error']) { // didn't find anything
//            $response->setContent(json_encode($apiResponse));
//            return $response;
//        }
//
////        $message = new SendResultEmail($email, $name);
//        $messageBus->dispatch($message);
//
//        $errorArray =  [
//            'error' => false,
//            'data'  => "Email Sent"
//        ];
//        $response->setContent(json_encode($errorArray));
//        return $response;
//    }
}
