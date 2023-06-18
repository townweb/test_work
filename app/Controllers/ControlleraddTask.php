<?php

use App\Core\Controller;
use App\Models\ModelTasks;

class ControlleraddTask extends Controller
{

    /*
     * Основная функция Контроллера, проверяем входящие данные и если не хватает возвращаем.
     * Сделано через редиректы, не самое удачное решение, можно сделать через ajax по нормальному.
     */

    function action_index()
    {
        $name = (isset($_POST['name']) ? $_POST['name'] : '');
        $email = (isset($_POST['email']) ? $_POST['email'] : '');
        $text = (isset($_POST['text']) ? $_POST['text'] : '');

        if(empty($name) || empty($email) || empty($text) ){
            header('Location: /?error=Пустые поля в задаче');
        }


        header('Location: /?'. ModelTasks::addData($name,$email,$text));

    }


}