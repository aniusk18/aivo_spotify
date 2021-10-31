<?php
/* use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/hello/{name}', function(Request  $request, Response $response, array $args){
    $name= $args['name'];
    $response->getBody()->write("hello, $name");
    return $response;
}); */

$app->get('/', 'SpotifyController:home');
$app->get('/api/v1/albums', 'SpotifyController:albums');