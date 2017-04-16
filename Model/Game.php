<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 08:41
 */
namespace Model;

class Game extends Model {
    public function getLettersArray()
    {
        return [
            'a' => true,
            'b' => true,
            'c' => true,
            'd' => true,
            'e' => true,
            'f' => true,
            'g' => true,
            'h' => true,
            'i' => true,
            'j' => true,
            'k' => true,
            'l' => true,
            'm' => true,
            'n' => true,
            'o' => true,
            'p' => true,
            'q' => true,
            'r' => true,
            's' => true,
            't' => true,
            'u' => true,
            'v' => true,
            'w' => true,
            'x' => true,
            'y' => true,
            'z' => true,
        ];
    }

    public function getWordsArray()
    {
        return @file(SOURCE_NAME, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: false;
    }

    public function getWord()
    {
        $dbPendu = $this->connectDB();
        if($dbPendu) {
            $dbPendu->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            try {
                $req = 'SELECT word FROM pendu.words ORDER BY RAND() LIMIT 1';
                $pdoSt = $dbPendu->query($req);

                return strtolower($pdoSt->fetchColumn());
            } catch(\PDOException $error) {
                echo 'file error connect';
            }
        }
        $wordsArray = $this->getWordsArray();
        return str_replace(' ', '', strtolower($wordsArray[rand(0, count($wordsArray) - 1)]));
    }

    function getReplacementString($lettersCount)
    {
        return str_pad('', $lettersCount, REPLACEMENT_CHAR);
    }

    function initGame()
    {
        $_SESSION['wordFound'] = false;
        $_SESSION['remainingTrials'] = MAX_TRIALS;
        $_SESSION['trials'] = 0;
        $_SESSION['triedLetters'] = '';
        $_SESSION['lettersArray'] = $this->getLettersArray();
        $_SESSION['word'] = $this->getWord();
        $_SESSION['lettersCount'] = strlen($_SESSION['word']);
        $_SESSION['replacementString'] = $this->getReplacementString($_SESSION['lettersCount']);
        $_SESSION['attempts'] = 0;
    }

    function saveGame()
    {
        $pdo = $this->connectDB();
        if ($pdo) {
            $sql = 'INSERT INTO pendu.games(`username`, `trials`, `word`, `attempts`) VALUES (:email, :trials, :word, :attempts)';
            try {
                $pdoSt = $pdo->prepare($sql);
                $pdoSt->execute([
                    ':email' => $_SESSION['email'],
                    ':trials' => $_SESSION['trials'],
                    ':word' => $_SESSION['word'],
                    ':attempts' => $_SESSION['attempts'],
                ]);
            } catch(\PDOException $e) {
                die('Quelque chose a posé problème lors de l\'enregistrement');
            }
        } else {
            die('Quelque chose a posé problème lors de l\'enregistrement');
        }
    }
}
