<?php
require_once(__DIR__."/conf.php");
if(auth_is_login()) {
    redirect('/');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
    </style>
</head>

<body>
<div class="form-wrapper text-center">
    <form class="form-signin" method="post" action="/login.php">
          <?php scrf(); ?>
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
        <?php echo flash_show(); ?>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email" autofocus>
        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Пароль">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        <a href="register-form.php">Зарегистрироваться</a> | <a href="forgot-form.php">Забылы пароль?</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
</div>
</body>
</html>
