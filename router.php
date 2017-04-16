<?php

session_start();

if(!file_exists(INI_FILE) && !file_exists(SOURCE_NAME)) {
    header('Location: http://homestead.app/pwcs/pwcs-pendu2/errors/error_main.php');
    exit;
}

require 'configs/routes.php';
$default_route = $routes['default'];
$route_parts = explode('/', $default_route);
$method = $_SERVER['REQUEST_METHOD'];  // récupérer la Méthode
$a = $_REQUEST['a']??$route_parts[1];  // récupérer l'Action
$r = $_REQUEST['r']??$route_parts[2];  // récupérer la Ressource

if (!in_array($method . '/' . $a . '/' . $r, $routes)) {
    die('ce que vous cherchez n’est pas ici');
}


$controllerName = 'Controller\\' . ucfirst($r);
$controller = new $controllerName();

$data = call_user_func([$controller, $a]);