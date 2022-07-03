<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class ResponderService {

    public function createResponse(): Response
    {
        $response  = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}