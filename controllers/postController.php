<?php

/**
 * La lettre qui vient d’être essayée
 */
$triedLetter = (ctype_alpha($_POST['triedLetter'])&&strlen($_POST['triedLetter'])===1)?$_POST['triedLetter']:'';
if(!$triedLetter) die('Houla, vous n’avez pas essayé une lettre…');

/**
 * Modification de la chaîne des lettres déjà essayées
 * en y ajoutant la nouvelle essayée par le joueur
 */
$_SESSION['triedLetters'] .= $triedLetter;

/** Modification du statut de la lettre qui vient d’être essayée.
 * Son statut est mis à false dans le tableau $lettersArray
 */
$_SESSION['lettersArray'][$triedLetter] = false;

$letterFound = false;
for ($i = 0; $i < $_SESSION['lettersCount']; $i++) {
    $l = substr($_SESSION['word'], $i, 1);
    if($triedLetter === $l){
        $letterFound = true;
        $_SESSION['replacementString'] = substr_replace($_SESSION['replacementString'],$l,$i,1);
    }
}
if(!$letterFound){
    $_SESSION['trials']++;
}else{
    if($_SESSION['word'] === $_SESSION['replacementString']){
        $_SESSION['wordFound'] = true;
    }
}
$_SESSION['remainingTrials'] = MAX_TRIALS - $_SESSION['trials'];
