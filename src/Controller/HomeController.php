<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('', name: 'pokedex_home', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render(
            'home.html.twig'
        );
    }

    #[Route('/pokemon', name: 'pokedex_get', methods: ['GET'])]
    public function getPokemon()
    {

        $pokemon = [
            [
                'id' => 1,
                'name' => 'Pikachu'
            ],
            [
                'id' => 2,
                'name' => 'Squirtle'
            ]
        ];
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($pokemon));

        return $response;
    }
}
