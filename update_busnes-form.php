<?php

require_once(__DIR__."/conf.php");
if(!auth_is_login()) {
    redirect('/');
}
if(!isset($_GET['id']) || trim($_GET['id']) === ''){
  redirect('/');
}
$id = trim($_GET['id']);
$sql = "SELECT * FROM `business` WHERE `id`='".$mysqli->real_escape_string($id)."'";
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

    <title>Update busnes</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
    </style>
</head>

<body>
<div class="form-wrapper text-center">
    <form class="form-signin" method="post" action="/update_busnes.php">
          <?php scrf(); ?>
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Отредактировать дело</h1>
          <?php echo flash_show(); ?>
          <label for="inputEmail" class="sr-only">Описание дела</label>
          <textarea name="name" class="form-control" cols="30" rows="10" placeholder="Описание дела"><?php echo $array['name']; ?></textarea>


          <input type="date" class="form-control" value="<?php echo date("Y-m-d", $array['date']); ?>" name="date">
          <select name="priority" class="form-control">
              <option value="1" <?php echo (int)$array['priority'] === 1 ? 'selected' : ''; ?>>Очень важное</option>
              <option value="2" <?php echo (int)$array['priority'] === 2 ? 'selected' : ''; ?>>Важное</option>
              <option value="3" <?php echo (int)$array['priority'] === 3 ? 'selected' : ''; ?>>Среднее</option>
              <option value="4" <?php echo (int)$array['priority'] === 4 ? 'selected' : ''; ?>>Минимальный приоритет</option>
          </select>
              <br/>
          <select name="status" class="form-control">
              <option value="3" <?php echo (int)$array['status'] === 3 ? 'selected' : ''; ?>>не выполнено</option>
                <option value="2" <?php echo (int)$array['status'] === 2 ? 'selected' : ''; ?>>В процессе</option>
              <option value="1" <?php echo (int)$array['status'] === 1 ? 'selected' : ''; ?>>Выполнено</option>
          </select>
              <br/>

        <button class="btn btn-lg btn-primary btn-block" name="id" value="<?php echo $array['id']; ?>" type="submit">Изменить</button>

        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
</div>
</body>
</html>
