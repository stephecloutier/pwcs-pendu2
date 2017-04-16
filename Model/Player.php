<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 08:41
 */

namespace Model;

class Player extends Model {
    public function getGamesCountForCurrentPlayer()
    {
        $pdo = connectDB();
        if ($pdo) {
            $sql = sprintf('SELECT COUNT(*) FROM pendu.games WHERE username = \'%s\'', $_SESSION['email']);
            try {
                $pdoSt = $pdo->query($sql);
                return $pdoSt->fetchColumn();
            } catch (\PDOException $e) {
                return '';
            }
        } else {
            die('Quelque chose a posé problème lors de la récupération du nombre de parties');
        }
    }

    public function getGamesWonForCurrentPlayer()
    {
        $pdo = connectDB();
        if ($pdo) {
            $sql = sprintf(
                'SELECT COUNT(*) FROM pendu.games WHERE username = \'%s\' AND trials < \'%s\'',
                $_SESSION['email'],
                MAX_TRIALS
            );
            try {
                $pdoSt = $pdo->query($sql);
                return $pdoSt->fetchColumn();
            } catch (\PDOException $e) {
                return '';
            }
        } else {
            die('Quelque chose a posé problème lors de la récupération du nombre de parties gagnées');
        }
    }
}

