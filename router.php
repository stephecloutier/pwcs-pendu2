<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 16/03/17
 * Time: 11:46
 */
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

$controllerFile = $r . 'Controller.php';
require 'Controller/' . $controllerFile;
$data = call_user_func($a);