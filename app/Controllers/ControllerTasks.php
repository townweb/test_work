<?php

use App\Core\Controller;
use App\Models\ModelTasks;

class ControllerTasks extends Controller
{


    /*
     Основная функция контроллера, для отправки даннаых на VIEW
     */
    function action_index()
    {

        ModelTasks::$g_sort = ModelTasks::$g_page = '';

        if (isset($_GET['sort'])) {
            ModelTasks::$g_sort = $_GET['sort'];
        }

        if (isset($_GET['page'])) {
            ModelTasks::$g_page = $_GET['page'];
        }

        $tasks = ModelTasks::getData();

        if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
            $tasks['admin'] = 'on';
        }
        if (isset($_GET['success'])) {
            $tasks['success'] = $_GET['success'];
        }
        if (isset($_GET['error'])) {
            $tasks['error'] = $_GET['error'];
        }

        $tasks['sortSelect'] = self::sortSelect();
        $this->view->generate('mainTasksView.php', 'templateView.php', $tasks);
    }


    /*
    Функция генерирует блок сортировки(сюда вынесен из-за работы с GET параметрами)
    */

    private static function sortSelect()
    {

        $sort_array = [
            ['value' => '-', 'name' => '-'],
            ['value' => 'name_ASC', 'name' => 'Имя пользователя (A-Я)'],
            ['value' => 'name_DESC', 'name' => 'Имя пользователя (Я-A)'],
            ['value' => 'email_ASC', 'name' => 'Email (A-Я)'],
            ['value' => 'email_DESC', 'name' => 'Email (Я-A)'],
            ['value' => 'status_DESC', 'name' => 'Статус А-З'],
            ['value' => 'status_ASC', 'name' => 'Статус З-А'],
        ];

        $options = '';


        foreach ($sort_array as $sort_item) {
            $options .= '
                                    <option ' .
                (!empty($sort_item['value']) ? 'value="' . $sort_item['value'] . '"' : '') . ' ' .
                (((isset($_GET['sort']) && $sort_item['value'] == $_GET['sort']) || (!isset($_GET['sort']) && empty($sort_item['value']))) ? 'selected' : '') . '>' .
                (!empty($sort_item['name']) ? $sort_item['name'] : '') . '</option>';
        }

        return <<<HTML
<form action="" id="sort" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            Сортировка
                        </div>
                        <div class="col-md-10">
                            <select class="form-select form-select-lg mb-3" id="selectSort" name="sort" aria-label=".form-select-lg example">
                              
$options

                            </select>

                        </div>
                    </div>
                </form>
HTML;


    }

}