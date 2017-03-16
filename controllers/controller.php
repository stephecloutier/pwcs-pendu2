<?php
session_start();
/**
* Ce fichier sert à inclure le code nécessaire à une réponse
* HTTP en GET ou en POST. Avant de faire ces inclusions, il
* charge les mots depuis le fichier et mémorise l’Array des
* mots dans $wordsArray
*
*/


if (file_exists(INI_FILE) || file_exists(SOURCE_NAME)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['email'])) {
            include 'controllers/postPlayerController.php';
        } else {
            include 'controllers/postGameController.php';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'controllers/getGameController.php';
    } else {
        header('Location: http://homestead.app/pwcs/pwcs-pendu2/errors/error405.php');
        exit;
    }
} else {
    header('Location: http://homestead.app/pwcs/pwcs-pendu2/errors/error_main.php');
    exit;
}

//var_dump($_SESSION['word']);
