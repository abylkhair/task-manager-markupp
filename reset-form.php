<?php
require_once(__DIR__."/conf.php");
if(auth_is_login()) {
    redirect('/');
}
if(!isset($_GET['hash']) || trim($_GET['hash']) === ''){
  redirect('/');
}
$hash = trim($_GET['hash']);
$sql = "SELECT * FROM `users` WHERE `hash`='".$mysqli->real_escape_string($hash)."'";
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

    <title>Change password</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
    </style>
</head>

<body>
<div class="form-wrapper text-center">
    <form class="form-signin" method="post" action="/reset.php">
          <?php scrf(); ?>
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Изменить пароль</h1>
          <?php echo flash_show(); ?>
        <label for="password" class="sr-only">Пароль</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="Новый пароль" autofocus>
        <label for="password2" class="sr-only">Потвердить пароль</label>
        <input type="password" id="password2" class="form-control" name="password2" placeholder="Потвердить пароль" >
        <input type="hidden"  name="hash" value="<?php echo $hash; ?>"/>
        <button class="btn btn-lg btn-primary btn-block" name="id" value="<?php echo $array['id']; ?>" type="submit">Изменить</button>

        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
</div>
</body>
</html>
