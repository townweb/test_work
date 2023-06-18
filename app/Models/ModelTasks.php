<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Config;

class ModelTasks extends Model
{
    // переменные для того чтобы не тащить в модель get параметры
    public static $g_sort = '';
    public static $g_page = '';

    // формируем кусок кода с пагинацией. Проверяем чтобы нам точно передали цифру
    private static function preparePage($param)
    {

        if (!is_numeric($param)) {
            return 'LIMIT 0,3';
        }

        return 'LIMIT ' . (($param - 1) * 3) . ',3';

    }

    // Проверяем по словарю типы сортировки, чтобы избежать инъекций
    private static function prepareSort($param)
    {

        $orders = array(
            'id',
            'name',
            'email',
            'status'
        );

        $types = array(
            'DESC',
            'ASC'
        );

        $param = explode('_', $param);

        return ['orders' => $orders[array_search($param[0], $orders)], 'sort' => $types[array_search($param[1], $types)]];

    }

    //фукция обработки получения данных из бд
    private static function dbResult($result)
    {
        if ($result) {
            $result_obj = [];
            while ($obj = $result->fetch_object()) {
                if (isset($obj->status)) {
                    $obj->status = ($obj->status == 1 ? 'Активная' : 'Завершена');
                }
                $result_obj[] = $obj;
            }
            return $result_obj;
        }
        return false;
    }

    // формируем запрос из переменных. Так как у нас все переменные по шаблоны изи цифры, prepare было решено не делать.
    private static function doBuildGetQuery()
    {

        $db_connect = Config::db_connect();

        $sort = (!empty(self::$g_sort)) ? self::prepareSort(self::$g_sort) : ['orders' => 'id', 'sort' => 'ASC'];
        $orderBy = $sort['orders'];
        $order = $sort['sort'];
        $page = (!empty(self::$g_page)) ? self::preparePage(self::$g_page) : 'LIMIT 0,3';
        $query = "SELECT `id`,`status`,`name`,`email`,`text` FROM `to_do_list` ORDER BY $orderBy $order $page";
        $result = $db_connect->query($query);
        return self::dbResult($result);

    }

    // считаем количество всего задач
    private static function CountTasks()
    {
        $db_connect = Config::db_connect();
        $query = "SELECT count(id) as count_tasks FROM `to_do_list`";
        $result = self::dbResult($db_connect->query($query));
        $str_page = ceil($result[0]->count_tasks / 3);

        return $str_page;

    }

    //строим html пагинации
    private static function buildPaginationHtml($count_page, $current_page)
    {

        $paginationHtml = '';

        if ($count_page < 2) {
            return $paginationHtml;
        }

        $link = '?page=';

        if (!empty(self::$g_sort)) {
            $link = '?sort=' . self::$g_sort. '&page=';
        }

        for ($i = 1; $i <= $count_page; $i++) {


            $paginationHtml .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '"><a class="page-link" href="' . $link . $i . '">' . $i . '</a></li>';
        }

        $paginationHtml = <<<HTML
<nav aria-label="Page navigation example">
  <ul class="pagination">
  $paginationHtml
</ul>
</nav>
HTML;
        return $paginationHtml;

    }

    private static function pagination()
    {

        return self::buildPaginationHtml(self::CountTasks(), (!empty(self::$g_page)) ? self::$g_page : '1');

    }

    public static function getData()
    {
        $tasks = self::doBuildGetQuery();
        $pagination = self::pagination();

        if ($tasks) {
            return ['tasks' => $tasks, 'pagination' => $pagination];
        }

        return ['error' => 'нет задач'];

    }


    // функция добавления задачи, испольцовал параметризацию
    public static function addData($name, $email, $text)
    {

        $db_connect = Config::db_connect();
        $active = 1;
        if ($stmt = $db_connect->prepare("INSERT INTO `to_do_list`(`status`, `name`, `email`, `text`) VALUES ((?), (?), (?), (?)) ")) {
            $stmt->bind_param('isss', $active, $name, $email, $text);
            $stmt->execute();
            return 'success=Успешно добавлена задача ' . $name;
        }

        return 'error=ошибка при добавлении задачи ' . $name;

    }

    // функция редактирования задачи, испольцовал параметризацию
    public static function editData($id, $stopTask = null, $text)
    {

        $db_connect = Config::db_connect();

        $status = (!empty($stopTask) && $stopTask == 1 ? 0 : 1);

        if ($stmt = $db_connect->prepare("UPDATE `to_do_list` SET `status` = (?), `text` = (?) WHERE `to_do_list`.`id` = (?);")) {
            $stmt->bind_param('isi', $status, $text, $id);
            $stmt->execute();
            return 'success=Успешно обвнолена задача ' . $id;
        }


        return 'error=ошибка при обновлении задачи ' . $id;

    }
}