<?php

namespace App\Models;
use App\Core\Model;

class ModelLogin extends Model
{

    //Базово проверяем логин/пароль
    public static function checkUser($login,$password){

        if($login == 'admin' && $password== '123'){
            $_SESSION['user'] = 'admin';
            return 'success=Добро пожаловать админ';
        }

        return 'error=ошибка в логине/пароле';
    }

}