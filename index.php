<?php
/**
 * Ce fichier est le point d’entrée dans le jeu.
 * Il se contente d’inclure les fichiers nécessaires.
 */
include 'configs/config.php';
require 'vendor/autoload.php';
include './router.php';
include 'views/layout.php';
