<?php

namespace App\Core;

class Config
{

    public static function db_connect()
    {
        $servername = 'localhost';
        $username = 'townweq0_test_wo';
        $database = 'townweq0_test_wo';
        $password = '&cLo&t6I';

        return mysqli_connect($servername, $username, $password, $database );

    }
}

