<?php

use App\Core\Controller;
use App\Models\ModelTasks;

class ControllerEditTask extends Controller
{

    /*
   * Основная функция Контроллера, проверяем входящие данные и если не хватает возвращаем.
   * Сделано через редиректы, не самое удачное решение, можно сделать через ajax по нормальному.
   */

    function action_index()
    {

        $id = (isset($_POST['id']) ? $_POST['id'] : '');
        $stopTask = (isset($_POST['stopTask']) ? $_POST['stopTask'] : '');
        $text = (isset($_POST['text']) ? $_POST['text'] : '');

        if(empty($id) || (empty($stopTask) && empty($text) ) || !is_numeric($id)){
            header('Location: /?error=невозможно отредактировать');
        }

        header('Location: /?'. ModelTasks::editData($id,$stopTask,$text));

    }


}