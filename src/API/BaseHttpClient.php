<?php

namespace App\API;

use Symfony\Component\HttpClient\HttpClient;

abstract class BaseHttpClient
{
    private $base_uri = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise';

    /**
     * @return \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    public function getClient()
    {
        return HttpClient::create([
            'base_uri' => $this->base_uri,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}
