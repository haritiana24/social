<?php

/**
 * @author Haritiana24
 */
session_start();
use App\Router\Route;

require "../vendor/autoload.php";

// Items of the path used for the application
$uri = $_SERVER["REQUEST_URI"];
$bootstrap = "/bootstrap/css/bootstrap.min.css";
$css = "/bootstrap/css/index.css";
$font = "/bootstrap/css/font-awesome.min.css";
$jquery = "/jquery/jquery-3.3.1.js";
$js = "/bootstrap/js/index.js";
$view = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views';
$route = require dirname(__DIR__) . "/web/config.php";

//  initiate the Route Application  
$router = new Route($route);
if(!empty($_GET)){
    $uri =  substr($uri, 0 , strpos($uri, "?"));
}else{
    $route = $_SERVER['REQUEST_URI'];
}
// the title for the one page
$title = "Zarao $uri"; 
ob_start();
$router->map($uri, $view);
$content = ob_get_clean();

require $view . "/layout.php";