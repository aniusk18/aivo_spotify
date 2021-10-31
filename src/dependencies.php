<?php
use  App\Controllers\SpotifyController;
use App\Funciones\SpotifyFunciones;

$container = $app->getContainer();
$container['spf'] = function() {
    return new SpotifyFunciones();
};
$container['SpotifyController'] = function($c) {
    return new SpotifyController($c);
};