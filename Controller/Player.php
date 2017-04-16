<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 16/03/17
 * Time: 09:02
 */

namespace Controller;

use \Model\Game as GameModel;

class Player {
    public function register()
    {
        $view = 'views/game.php';
        $_SESSION['errors'] = [];
        $gameModel = new GameModel();
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email'] = $_POST['email'];
            $gameModel -> initGame();
        } else {
            if (!empty($_POST['email'])) {
                $_SESSION['errors'] = [
                    'email' => $_POST['email'] . ' ne semble pas être une adresse email valide',
                ];
                $_SESSION['email'] = $_POST['email'];
                $view = 'views/player.php';
            } else {
                //Le joueur ne souhaite pas qu'on mémorise sa partie
                $_SESSION['email'] = '';
                $gameModel -> initGame();
            }
        }

        return compact('view');
    }
}


