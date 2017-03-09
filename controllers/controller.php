<?php
session_start();
/**
* Ce fichier sert à inclure le code nécessaire à une réponse
* HTTP en GET ou en POST. Avant de faire ces inclusions, il
* charge les mots depuis le fichier et mémorise l’Array des
* mots dans $wordsArray
*
*/


if (file_exists(SOURCE_NAME)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'controllers/postController.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'controllers/geController.php';
    } else {
        die('Houla ! Qu’est-ce que tu fais avec cette méthode HTTP ?');
    }
} else {
    die('Houla ! le fichier contenant les mots à deviner ne semble pas exister…');
}

var_dump($_SESSION['word']);
