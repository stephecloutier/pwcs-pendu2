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
    $cnxDatas = parse_ini_file('DB.ini');

    $dsn = sprintf('mysql:dbname=%s;host=%s', $cnxDatas['DB_NAME'], $cnxDatas['DB_HOST']);

    try {
        $dbPendu = new PDO($dsn, $cnxDatas['DB_USER'], $cnxDatas['DB_PASS']);
    }
    catch(PDOException $cnxError){
        return false;
    }

    return $dbPendu;
}

function getWord()
{
    $dbPendu = connectDB();
    if(!$dbPendu) {
        $wordsArray = getWordsArray();
        return str_replace(' ', '', strtolower($wordsArray[rand(0, count($wordsArray) - 1)]));
    }

    $req = 'SELECT word FROM pendu.words ORDER BY RAND() LIMIT 1';
    $pdoSt = $dbPendu->query($req);

    return strtolower($pdoSt->fetchColumn());
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
