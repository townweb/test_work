<?php

use App\Core\Controller;
use App\Models\ModelTasks;

class ControllerExit extends Controller
{
    /*
   * убиваем ссессию
   */

    function action_index()
    {

        session_destroy();
        header('Location: /');

    }


}