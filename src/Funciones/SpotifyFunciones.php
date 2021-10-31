<?php
namespace App\Funciones;

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\RequestException;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
class SpotifyFunciones{
    public function getToken($response,$spotify_client_id,$spotify_api_client_secret){
        $client = new Client;
        $responseToken = $client->request('POST', 'https://accounts.spotify.com/api/token', [
            'form_params' => ["grant_type" => "client_credentials"],
            'headers' => ['Authorization' => 'Basic ' . base64_encode($spotify_client_id . ':' . $spotify_api_client_secret)]
                ]
        );
        $responseToken = json_decode($responseToken->getBody());
        $token = $responseToken->access_token;
        return $token;
    }
    public function getArtista($token,$query){
        $client = new Client;
        $Artist =  $client->get('https://api.spotify.com/v1/search', [
            'query' => [
                    'q' => $query,
                    'type' => 'artist',
            ],
            'headers' => ['Authorization' => 'Bearer  ' . $token]
        ]);
        $responseArtist =json_decode($Artist->getBody());
        return $responseArtist;
    }
    public function getAlbums($token,$artists){
                
        $responseAlbumsDetail = [];
        foreach ($artists as $artist) {
                $client = new Client;
                $responseAlbums = $client->get('https://api.spotify.com/v1/artists/'. $artist->id . '/albums', [
                    'headers' => [
                                    'Authorization' => 'Bearer  ' . $token,
                                    'Accept' => 'application/json', 
                                    'Content-Type' => 'application/json'
                                ]
                ]);
                $responseAlbums = json_decode($responseAlbums->getBody());
                foreach ($responseAlbums->items as $item) {
                    $responseAlbumsDetail[] = [
                        
                        'name' => $item->name,
                        // released date in format d-m-Y
                        'released' => date('d-m-Y', strtotime($item->release_date)),
                        'tracks' => $item->total_tracks,
                        'cover' => [
                            'height' => $item->images{0}->height,
                            'width' => $item->images{0}->width,
                            'url' => $item->images{0}->url,
                        ]
                    ];
                }
                //$responseArtist = json_decode($responseAlbumsDetail);
            
        }
        return $responseAlbumsDetail;
    }
}