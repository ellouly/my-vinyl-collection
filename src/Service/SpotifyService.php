<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function authenticate ()
    {
        $response =$this->client->request('POST', 'https://accounts.spotify.com/api/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.base64_encode ('6f7cc388cea244669ab0c4b2f283b804:c0f43568e5e54cfc967a64229c1e0d67')
            ],
            'body' => ['grant_type' => 'client_credentials'],
        ]);
    }

}