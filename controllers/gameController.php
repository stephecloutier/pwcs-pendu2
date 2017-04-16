<?php

function init()
{
    $_SESSION['email'] = $_SESSION['email']??'';
    return ['view' => 'views/player.php'];
}

function check()
{
    include 'models/gameModel.php';
    include 'models/playerModel.php';

    $_SESSION['attempts']++;

    $triedLetter = (ctype_alpha($_POST['triedLetter']) && strlen($_POST['triedLetter'])===1)?$_POST['triedLetter']:'';

    if(!$triedLetter) {
        header('Location: http://homestead.app/pwcs/pwcs-pendu2/errors/error_main.php');
        exit;
    }

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
        if ($triedLetter === $l){
            $letterFound = true;
            $_SESSION['replacementString'] = substr_replace($_SESSION['replacementString'],$l,$i,1);
        }
    }
    if (!$letterFound){
        $_SESSION['trials']++;
    } else {
        if ($_SESSION['word'] === $_SESSION['replacementString']){
            $_SESSION['wordFound'] = true;
        }
    }
    $_SESSION['remainingTrials'] = MAX_TRIALS - $_SESSION['trials'];


    $gamesCount = '';

    if ($_SESSION['email']) {
        if ($_SESSION['wordFound'] || !$_SESSION['remainingTrials']) {
            saveGame();
            $gamesCount = getGamesCountForCurrentPlayer();
            if ($gamesCount) {
                $gamesWon = getGamesWonForCurrentPlayer();
            }
        }
    }

    $view = 'views/game.php';
    return compact('view', 'gamesCount', 'gamesWon');
}

