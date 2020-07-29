<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyService
{
    private $client;
    private $session;
    private $clientId;
    private $clientSecret;

    public function __construct(HttpClientInterface $client, SessionInterface $session, $client_id, $client_secret)
    {
        $this->client = $client;
        $this->session = $session;
        $this->clientId = $client_id;
        $this->clientSecret = $client_secret;
    }

    public function authenticate()
    {
        $response = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . base64_encode($this->clientId .':' .$this->clientSecret)
            ],
            'body' => ['grant_type' => 'client_credentials'],
        ]);

        $content = json_decode($response->getContent(), true);
        $this->session->set('access-token', $content['access_token']);
    }

    public function searchAlbum($albumName)
    {
        $response = $this->client->request('GET', 'https://api.spotify.com/v1/search?type=album&q=' . $albumName, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->session->get('access-token')]
        ]);
    }
}