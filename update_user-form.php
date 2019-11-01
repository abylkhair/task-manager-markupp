<?php
require_once(__DIR__."/conf.php");
if(!auth_is_admin()) {
    redirect('/');
}
if(!isset($_GET['id']) || trim($_GET['id']) === ''){
  redirect('/');
}
$id = trim($_GET['id']);
$sql = "SELECT * FROM `users` WHERE `id`='".$mysqli->real_escape_string($id)."'";
$res = $mysqli->query($sql);
if($res->num_rows === 0){
    redirect('/');
}
$array = $res->fetch_assoc();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Update user</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
    </style>
</head>

<body>
<div class="form-wrapper text-center">
    <form class="form-signin" method="post" action="/update_user.php">
          <?php scrf(); ?>
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Отредактировать пользователя</h1>
          <?php echo flash_show(); ?>
          <label for="name" class="sr-only">Имя</label>
          <input type="text" id="name" class="form-control" value="<?php echo $array['username']; ?>" name="username" placeholder="Имя" >
          <label for="Email" class="sr-only">Email</label>
          <input type="email" id="Email" class="form-control" name="email" value="<?php echo $array['email']; ?>" placeholder="Email" >
        <label for="password" class="sr-only">Пароль</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="Новый пароль" >
        <label for="password2" class="sr-only">Потвердить пароль</label>
        <input type="password" id="password2" class="form-control" name="password2" placeholder="Потвердить пароль" >

        <button class="btn btn-lg btn-primary btn-block" name="id" value="<?php echo $array['id']; ?>" type="submit">Изменить</button>

        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
</div>
</body>
</html>
