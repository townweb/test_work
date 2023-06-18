<?php
use App\Core\Controller;
use App\Models\ModelLogin;

class ControllerLogin extends Controller
{
    /*
   * Основная функция Контроллера, проверяем входящие данные и если не хватает возвращаем.
   * Сделано через редиректы, не самое удачное решение, можно сделать через ajax по нормальному.
   */

    function action_index()
    {

        $login = (isset($_POST['login']) ? $_POST['login'] : '');
        $password = (isset($_POST['password']) ? $_POST['password'] : '');

        if(empty($login) || empty($password)){
            header('Location: /?error=Пустые поля в логине или пароле');
        }
        $text = ModelLogin::checkUser($login,$password);

        header('Location: /?'. $text);

    }


}