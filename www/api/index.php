<?php
require_once 'src/vendor/autoload.php';
use TBollmeier\Lieblinks\Routing\Router;

$httpMethod = $_SERVER["REQUEST_METHOD"];

$url = "/api/".$_GET['url'];

$queryParams = $_GET;
unset($queryParams['url']);
$queryParamStr = implode("&", array_map(function ($key) use ($queryParams) {
    return $key."=".$queryParams[$key];
}, array_keys($queryParams)));

if (!empty($queryParamStr)) {
    $url .= "?$queryParamStr";
}

$router = new Router("TBollmeier\\Lieblinks\\Controller");

try {
    $router->route($httpMethod, $url);
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}

