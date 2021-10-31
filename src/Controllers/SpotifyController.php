<?php
namespace App\Controllers;
use Psr\Container\ContainerInterface;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use GuzzleHttp\Exception\RequestException;

class SpotifyController{
    protected $container;
    // constructor receives container instance$spf
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    public function home(){
        return "ok";
    }
    public function albums(Request $request,Response $response,$args){

        
        try {
            if (empty($_GET['q'])) {
                throw new \Exception('Name artist param is required');
            }
            $q=$_GET['q'];
        } catch (\Exception $ex) {
            $responseSpotifyApi = [
                'status' => 'failed',
                'error' => $ex->getMessage()
            ];
            return $response->withJson($responseSpotifyApi);
        }
        try{
             /** OBTENER EL TOKEN **/
            $token = $this->container->spf->getToken($response,SPOTIFY_CLIENT_ID,SPOTIFY_CLIENT_SECRET);
            
            /** BUSCAR EL  ARTISTA O ARTISTAS POR TERMINO**/
            $responseArtist= $this->container->spf->getArtista($token,$q);
            $artists = $responseArtist->artists->items;
            /** buscar datos de disco de artista o artistas por cada  artista id en los resultados de la busqueda **/
            $responseSpotifyApi = $this->container->spf->getAlbums($token,$artists);
            return $response->withJson($responseSpotifyApi);

        } catch (RequestException $exception) {
            $responseSpotifyApi = [
                'status' => 'failed',
                'error' => $exception->getMessage()
            ];
            return $response->withJson($responseSpotifyApi);
        }
       



    }
}