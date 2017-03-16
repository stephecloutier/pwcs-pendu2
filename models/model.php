<?php
/**
 * Retourne le tableau des lettres disponibles pour jouer au pendu
 * avec leur statut, disponible ou pas pour constituer le select
 * qui permettra au joueur de proposer une lettre.
 *
 * @return array
 */
function getLettersArray()
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

/**
 * Retourne l’array des mots depuis le fichier qui en contient la liste
 *
 * @return mixed
 */
function getWordsArray()
{
    return @file(SOURCE_NAME, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: false;
}

/**
 * Retourne un mot du tableau des mots
 *
 * @return string
 */

function connectDB()
{
    $dsn = '';
    $db_config = ['DB_USER' => '', 'DB_PASS' => ''];

    if(file_exists(INI_FILE)){
        $db_config = parse_ini_file(INI_FILE);
        $dsn = sprintf('mysql:dbname=%s;host=%s', $db_config['DB_NAME'], $db_config['DB_HOST']);
    }

    try {
        return new PDO(
            $dsn,
            $db_config['DB_USER'],
            $db_config['DB_PASS'],
            [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]
        );
    }
    catch(PDOException $exception){
        return false;
    }
}

function getWord()
{
    $dbPendu = connectDB();
    if($dbPendu) {
        $dbPendu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $req = 'SELECT word FROM pendu.words ORDER BY RAND() LIMIT 1';
            $pdoSt = $dbPendu->query($req);

            return strtolower($pdoSt->fetchColumn());
        } catch(PDOException $error) {
            echo 'file error connect';
        }
    }
    $wordsArray = getWordsArray();
    return str_replace(' ', '', strtolower($wordsArray[rand(0, count($wordsArray) - 1)]));
}

/**
 * Retourne la chaine de remplacement
 *
 * @param integer $lettersCount Le nombre de lettres du mot
 *
 * @return string
 */
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
    $_SESSION['lettersArray'] = getLettersArray();
    $_SESSION['word'] = getWord();
    $_SESSION['lettersCount'] = strlen($_SESSION['word']);
    $_SESSION['replacementString'] = getReplacementString($_SESSION['lettersCount']);
    $_SESSION['attempts'] = 0;
}

function saveGame()
{
    $pdo = connectDB();
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
        } catch(PDOException $e) {
            die('Quelque chose a posé problème lors de l\'enregistrement');
        }
    } else {
        die('Quelque chose a posé problème lors de l\'enregistrement');
    }
}

function getGamesCountForCurrentPlayer()
{
    $pdo = connectDB();
    if ($pdo) {
        $sql = sprintf('SELECT COUNT(*) FROM pendu.games WHERE username = \'%s\'', $_SESSION['email']);
        try {
            $pdoSt = $pdo->query($sql);
            return $pdoSt->fetchColumn();
        } catch (PDOException $e) {
            return '';
        }
    } else {
        die('Quelque chose a posé problème lors de la récupération du nombre de parties');
    }
}

function getGamesWonForCurrentPlayer()
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
        } catch (PDOException $e) {
            return '';
        }
    } else {
        die('Quelque chose a posé problème lors de la récupération du nombre de parties gagnées');
    }
}

