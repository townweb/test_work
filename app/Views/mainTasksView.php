<main>
    <div class="container">

        <?
        if(isset($data['error'])){
            ?>

            <div class="alert alert-danger" role="alert">
                <?= $data['error'] ?>
            </div>
            <?
        }
        if(isset($data['success'])){
            ?>
            <div class="alert alert-success" role="alert">
                <?= $data['success'] ?>
            </div>
            <?
        }
        ?>
        <h1>Список задач</h1>

        <div class="row mb-3 text-center">
            <div class="col-6 themed-grid-col">
                <?     if(isset($data['admin']) && $data['admin'] == 'on'){
                    ?>   <a href="/Exit" type="button" class="btn btn-primary">
                        Выход из админа
                    </a><?
                }else{
                    ?>  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Админка
                    </button><?
                }?>

            </div>
            <div class="col-6 themed-grid-col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    Добавить задачу
                </button>
            </div>
        </div>
        <div class="row mb-3 text-center">
            <div class="col-12 mb-3">
                <?
                if(isset($data['sortSelect'])){
                    echo $data['sortSelect'];
                }
                ?>
            </div>
        </div>
        <?
        if(isset($data['tasks'])){
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
                    <div class="tname-<?= $task->id?> col-2 themed-grid-col">id:<?= $task->id?> <?= $task->name?></div>
                    <div class="temail-<?= $task->id?> col-2 themed-grid-col"><?= $task->email?></div>
                    <div class="tstatus-<?= $task->id?>  col-2 themed-grid-col"><?= $task->status ?></div>
                    <? if(isset($data['admin']) && $data['admin'] == 'on'){
                        ?><div class="ttext-<?= $task->id?> col-5 themed-grid-col"><?= $task->text ?></div>
                        <div class="col-1 themed-grid-col"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id-task="<?= $task->id?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg></i>
                        </button></div><?
                    }else{
                        ?><div class="col-6 themed-grid-col"><?= $task->text ?></div><?
                    }?>

                </div>
                <?
            }
        }
        ?>

        <div class="row">
            <?= $data['pagination'] ?>
        </div>



        <div class="row">
            <!-- Button trigger modal -->


            <!-- Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Логин</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/Login" method="post">
                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1">Логин</label>
                                    <input type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="admin">

                                </div>
                                <div class="form-group mb-3">
                                    <label for="exampleInputPassword1">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="123">
                                </div>
                                <button type="submit" name="send" class="btn btn-primary">Войти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить задачу</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="addTask" method="POST">
                                <div class="form-group mb-2">
                                    <label for="taskEmail">Email</label>
                                    <input type="email" class="form-control" id="taskEmail" name="email" placeholder="name@example.com" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="taskName">Имя</label>
                                    <input type="text" class="form-control" name="name" id="taskName" placeholder="Максимильян" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="taskText">Текст задачи</label>
                                    <textarea class="form-control" id="taskText" name="text" rows="3" required></textarea>
                                </div>
                                <button type="submit" name="send" class="btn btn-primary">
                                    Добавить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <? if(isset($data['admin']) && $data['admin'] == 'on'){
                ?>
                <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Редактировать задачу</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="EditTask" method="POST">
                                    <input type="hidden" class="form-control" id="editID" name="id" placeholder="" >
                                    <div class="form-group mb-2">
                                        <label for="taskEmail">Email</label>
                                        <input type="email" class="form-control" id="editTaskEmail" placeholder="name@example.com" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="taskName">Имя</label>
                                        <input type="text" class="form-control" id="editTaskName" placeholder="Максимильян" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="taskText">Статус</label>
                                        <div class="form-check">
                                            <input class="form-check-input" value="1" name="stopTask" type="checkbox" value="" id="editStatusTask">
                                            <label class="form-check-label" for="editStatusTask">
                                                Закрыть задачу
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="taskText">Текст задачи</label>
                                        <textarea class="form-control" nameEditText id="editTaskText" name="text" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" name="send" class="btn btn-primary">
                                        Сохранить изменения
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?
            }?>
        </div>


</main>