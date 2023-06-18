<?php
namespace App\Core;

class Route
{
    static function start()
    {
        session_start();
        // контроллер и действие по умолчанию
        $controller_name = 'Tasks';
        $action_name = 'index';

        self::clearUrl();

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if ( !empty($routes[1])  &&  ltrim($routes[1], '?') != $_SERVER['QUERY_STRING'])
        {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if ( !empty($routes[2])  &&  ltrim($routes[2], '?') != $_SERVER['QUERY_STRING'])
        {
            $action_name = $routes[2];
        }

        // добавляем префиксы
        $model_name = 'Model'.$controller_name;
        $controller_name = 'Controller'.$controller_name;
        $action_name = 'action_'.$action_name;

        // подцепляем файл с классом модели (файла модели может и не быть)

        $model_file = $model_name.'.php';

        $model_path = "app/Models/".$model_file;

        if(file_exists($model_path))
        {
            include $model_path;
        }

        // подцепляем файл с классом контроллера
        $controller_file = $controller_name.'.php';
        $controller_path = "app/Controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            include $controller_path;
        }
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но для упрощения сразу сделаем редирект на страницу 404
            */
            self::ErrorPage404();
        }

        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            self::ErrorPage404();
        }

    }

    private  function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

    private static function clearUrl(){

        $url = $_SERVER['REQUEST_URI'];

        if(isset($_GET['sort']) && $_GET['sort'] == '-'){
            $url = self::removeqsvar($url,'sort');
        }

        if(isset($_GET['page']) && $_GET['page'] == '1'){
            $url = self::removeqsvar($url,'page');
        }

        if($url != $_SERVER['REQUEST_URI']){
            header('Location: '.$url);
        }

    }

    private static function removeqsvar($url, $varname) {
        return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
    }
}