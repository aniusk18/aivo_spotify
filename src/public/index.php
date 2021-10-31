<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\RequestException;
use App\Controllers\HomeController;
use Slim\App;
use Slim\Container;
use Psr\Container\ContainerInterface;
require '../vendor/autoload.php';
// CREDENCIALES DE SPOTIFY
define('SPOTIFY_CLIENT_ID', '79e464ee47e64282b0d46925006b44f3');
define('SPOTIFY_CLIENT_SECRET', 'e53b4dc232fc4151922c4781c9b2c8b7');
$app = new \Slim\App();
require __DIR__ . '/../dependencies.php';
require __DIR__ . '/../routes/routes.php';
//
$app->run();