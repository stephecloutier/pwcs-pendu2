<?php
/**
 * Ce controller représente l’étape d’initialisation
 * des variables utiles au fonctionnement du jeu.
 * Chaque fois que ce controller est exécuté, le jeu
 * est réinitialisé et on commence une nouvelle partie.
 */

$_SESSION['email'] = $_SESSION['email']??'';

$view = 'views/player.php';