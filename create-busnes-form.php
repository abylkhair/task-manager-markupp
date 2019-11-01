<?php

require_once(__DIR__."/conf.php");
if(!auth_is_login()) {
    redirect('/login-form.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Create Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>

    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" method="post" action="/create-busnes.php" enctype="multipart/form-data">
              <?php scrf(); ?>
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Добавить дело</h1>
          <?php echo flash_show(); ?>
        <label for="inputEmail" class="sr-only">Описание дела</label>
        <textarea name="name" class="form-control" cols="30" rows="10" placeholder="Описание дела"></textarea>


        <input type="date" class="form-control" name="date">
        <select name="priority" class="form-control">
            <option value="1">Очень важное</option>
            <option value="2">Важное</option>
            <option value="3">Среднее</option>
            <option value="4">Минимальный приоритет</option>
        </select>
            <br/>
        <select name="status" class="form-control">
            <option value="3">не выполнено</option>
              <option value="2">В процессе</option>
            <option value="1">Выполнено</option>
        </select>
            <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
