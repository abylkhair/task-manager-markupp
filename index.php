<?php
require_once(__DIR__."/conf.php");
if(!auth_is_login()) {
    redirect('/login-form.php');
}
$sql = "SELECT * FROM `users`";
$res = $mysqli->query($sql);
$users = [];
while($row = $res->fetch_assoc()){
  $users[$row['id']] = $row;
}
$id = $_SESSION['user_id'];

$business = [];
$sql = "SELECT * FROM `business`";
$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()){
  $business[$row['id']] = $row;
}
//подготовка и выполнение запроса к БД
require_once(__DIR__."/database_connection.php");
$sql = 'SELECT * from tasks where user_id=:user_id';
$statement = $pdo->prepare($sql);
$statement->execute([
  ':user_id' =>  $_SESSION['user_id']
]);
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Tasks</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>

  <body>

    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-md-7 py-4">
              <h4 class="text-white">О проекте</h4>
              <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
            </div>
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white">john@example.com</h4>
              <ul class="list-unstyled">
                <li><a href="/logout.php" class="text-white">Выйти</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            <strong>
              <?php echo $users[$id]['username']; ?>
              (<?php echo $users[$id]['email']; ?>)
             </strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>

    <main role="main">

      <section class="jumbotron text-center">
        <?php if(auth_is_admin()){?>
        <h4>Пользователи</h4>
        <?php echo flash_show(); ?>
        <style>
          table{
            width:100%;
          }
          table tr{
            border-bottom:1px solid black;
          }
        </style>
        <table>
          <thead>
            <tr>
              <th>
                  Имя
              </th>
              <th>
                  Email
              </th>
              <th>
                Cтатус
              </th>
              <th>
                Изменить
              </th>
              <th>
                Бан
              </th>
              <th>
                Удалить
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $key => $value) { ?>
              <?php if((int)$id !== (int)$key) { ?>
                <tr>
                    <td>
                      <?php echo htmlspecialchars($value['username']); ?>
                    </td>
                    <td>
                      <?php echo htmlspecialchars($value['email']); ?>
                    </td>
                    <td>
                        <form method="post" action="/status_user.php">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>"/>
                            <?php if((int)$value['user_status'] === 0) { ?>
                              <button class="btn btn-primary my-2" name="user_status" value="1" type="submit">Назначить администратором</button>
                            <?php } else { ?>
                              <button class="btn btn-primary my-2" name="user_status" value="0" type="submit">Назначить пользователем</button>
                            <?php } ?>
                        </form>
                    </td>
                    <td>
                      <a href="/update_user-form.php?id=<?php echo $value['id']; ?>">Изменить</a>
                    </td>
                    <td>
                        <form method="post" action="/ban_user.php">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>"/>
                            <?php if((int)$value['ban'] === 0) { ?>
                              <button class="btn btn-danger my-2" name="ban" value="1" type="submit">Заблокировать</button>
                            <?php } else { ?>
                              <button class="btn btn-danger my-2" name="ban" value="0" type="submit">Разблокировать</button>
                            <?php } ?>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="/delete_user.php">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>"/>
                              <button class="btn btn-danger my-2"  type="submit">Удалить</button>
                              </form>
                    </td>
                </tr>
            <?php } ?>
          <?php } ?>
          </tbody>
        </table>
      <?php } ?>
        <div class="container">

          <h1 class="jumbotron-heading">Проект "Карта ключевых задач"</h1>
          <p class="lead text-muted">Карта ключевых задач поможет вам автоматизировать список и подачу задач, сделать их более удобными и понятными для восприятия.</p>
          <p>
            <a href="/create-form.php" class="btn btn-primary my-2">Добавить задачу</a>
                <a href="/create-busnes-form.php" class="btn btn-primary my-2">Добавить дело</a>
          </p>
        </div>


        <h4>Список дел</h4>
        <?php echo flash_show(); ?>
        <style>
          table{
            width:100%;
          }
          table tr{
            border-bottom:1px solid black;
          }
        </style>
        <table>
          <thead>
            <tr>
              <th>
                  Дело
              </th>
              <th>
                  Дата
              </th>
              <th>
                Приоритет
              </th>
              <th>
                Cтатус
              </th>
              <th>
                Изменить
              </th>
              <th>
                Удалить
              </th>
            </tr>
          </thead>
          <tbody>
              <?php foreach($business as $item) { ?>
                <?php if(auth_is_admin() || (int)$item['id_user'] === (int)$_SESSION['user_id']){ ?>
                <tr>
                  <td>
                    <?php echo  htmlspecialchars($item['name']); ?>
                  </td>
                  <td>
                      <?php echo  date("d-m-Y",$item['date']); ?>
                  </td>
                  <td>
                      <?php echo (int)$item['priority'] === 1 ? 'Очень важное' : '';   ?>
                      <?php echo (int)$item['priority'] === 2 ? 'Важное' : '';   ?>
                      <?php echo (int)$item['priority'] === 3 ? 'Среднее' : '';   ?>
                      <?php echo (int)$item['priority'] === 4 ? 'Минимальный приоритет' : '';   ?>
                  </td>
                  <td>
                    <?php echo (int)$item['status'] === 1 ? 'Выполнено' : '';   ?>
                    <?php echo (int)$item['status'] === 2 ? 'В процессе' : '';   ?>
                    <?php echo (int)$item['status'] === 3 ? 'Не выполнено' : '';   ?>
                  </td>
                  <td>
                    <a href="/update_busnes-form.php?id=<?php echo $item['id']; ?>">Изменить</a>
                  </td>
                  <td>
                      <form method="post" action="/delete_busnes.php">
                          <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
                            <button class="btn btn-danger my-2"  type="submit">Удалить</button>
                            </form>
                  </td>
                </tr>
              <?php } ?>
              <?php } ?>
          </tbody>
        </table>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            <?php foreach($tasks as $task): ?>
             <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <!-- <img class="card-img-top" src="/uploads/<?php echo $task['image'];?>"> -->
                <div class="card-body">
                  <p class="card-text"><?php echo $task['title'];?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="/show.php?id=<?php echo $task['id'];?>" class="btn btn-sm btn-outline-secondary">Подробнее</a>
                      <a href="/edit-form.php?id=<?php echo $task['id'];?>" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="/delete.php?id=<?php echo $task['id'];?>" class="btn btn-sm btn-outline-secondary" onclick="confirm('are you sure?')">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach;?>

            <!--<div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="assets/img/no-image.jpg">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-sm btn-outline-secondary">Просмотреть</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="#" class="btn btn-sm btn-outline-secondary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>

    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Наверх</a>
        </p>
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
