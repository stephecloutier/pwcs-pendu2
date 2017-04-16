<?php

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