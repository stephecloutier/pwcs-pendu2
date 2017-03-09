<?php
/**
 * Ce controller représente l’étape d’initialisation
 * des variables utiles au fonctionnement du jeu.
 * Chaque fois que ce controller est exécuté, le jeu
 * est réinitialisé et on commence une nouvelle partie.
 */

/**
 * Un indicateur booléen du fait que le mot a été trouvé ou pas
 */
$_SESSION['wordFound'] = false;

/**
 * Le nombre d’essais qu’il reste au joueur pour trouver le mot.
 */
$_SESSION['remainingTrials'] = MAX_TRIALS;

/**
 * Le nombre d’essais infructueux déjà faits
 */
$_SESSION['trials'] = 0;

/**
 * Les lettres déjà essayées
 */
$_SESSION['triedLetters'] = '';

/**
 * Un tableau des lettres utilisables pour faire le select
 */
$_SESSION['lettersArray'] = getLettersArray();

/**
 * Le mot à trouver
 */
$_SESSION['word'] = strtolower($pdoSt->fetch(PDO::FETCH_COLUMN,0));


/*if (!isset($cnxError)) {
    $_SESSION['word'] = strtolower($pdoSt->fetch(PDO::FETCH_COLUMN,0));
 } else {
    $_SESSION['word'] = getWord();
 }*/


/**
 * Le nombre de lettres du mot
 */
$_SESSION['lettersCount'] = strlen($_SESSION['word']);

/**
 * La chaîne fantôme qui masque les lettres du mot avec un caractère de remplacement
 */
$_SESSION['replacementString'] = getReplacementString($_SESSION['lettersCount']);
