<main>
    <div class="container">

        <h1>Список задач</h1>

        <div class="row mb-3 text-center">
            <div class="col-6 themed-grid-col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Админка
                </button>
            </div>
            <div class="col-6 themed-grid-col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    Добавить задачу
                </button>
            </div>
        </div>
        <div class="row mb-3 text-center">
            <div class="col-12 mb-3">
                <form action="" id="sort" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            Сортировка
                        </div>
                        <div class="col-md-10">
                            <select class="form-select form-select-lg mb-3" id="selectSort" name="sort" aria-label=".form-select-lg example">
                                <?
                                $sort_array = [
                                        [ 'value' => '-', 'name' => '-'],
                                        [ 'value' => 'name_ASC', 'name' => 'Имя пользователя (A-Я)'],
                                        [ 'value' => 'name_DESC', 'name' => 'Имя пользователя (Я-A)'],
                                        [ 'value' => 'email_ASC', 'name' => 'Email (A-Я)'],
                                        [ 'value' => 'email_DESC', 'name' => 'Email (Я-A)'],
                                        [ 'value' => 'active_ASC', 'name' => 'Статус А-З'],
                                        [ 'value' => 'active_DESC', 'name' => 'Статус З-А'],
                                ];
                                foreach ($sort_array as $sort_item){
                                    ?>
                                    <option
                                        <?= !empty($sort_item['value']) ? 'value="'.$sort_item['value'].'"': '' ?>
                                        <?= ($sort_item['value'] == $_GET['sort'] || (!isset($_GET['sort']) && empty($sort_item['value'])) ) ? 'selected': '' ?>>
                                        <?= !empty($sort_item['name']) ? $sort_item['name']: '' ?>
                                    </option>

                                    <?
                                }
                                 ?>


                            </select>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?
        if(isset($data['error'])){
            echo $data['error'];
        }else{
            ?>
            <div class="row text-center mb-3">
                <div class="col-2 themed-grid-col"><h3>Имя пользователя</h3></div>
                <div class="col-2 themed-grid-col"><h3>Email</h3></div>
                <div class="col-2 themed-grid-col"><h3>Статус</h3></div>
                <div class="col-6 themed-grid-col"><h3>Текст задачи</h3></div>
            </div>

            <?
            foreach ($data['tasks'] as $task) {
                ?>
                <div class="row text-center mb-1">
                    <div class="hr col-12"></div>
                    <div class="col-2 themed-grid-col"><?= $task->name?></div>
                    <div class="col-2 themed-grid-col"><?= $task->email?></div>
                    <div class="col-2 themed-grid-col"><?= $task->status ?></div>
                    <div class="col-6 themed-grid-col"><?= $task->text ?></div>
                </div>
                <?
            }
        }
        ?>
        <div class="row">
            <?= $data['pagination'] ?>
        </div>

        <div class="row">
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Логин</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить задачу</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="addTask" method="post">
                                <div class="form-group mb-2">
                                    <label for="taskEmail">Email</label>
                                    <input type="email" class="form-control" id="taskEmail" placeholder="name@example.com">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="taskName">Имя</label>
                                    <input type="text" class="form-control" id="taskName" placeholder="Максимильян">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="taskText">Текст задачи</label>
                                    <textarea class="form-control" id="taskText" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Добавить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</main>