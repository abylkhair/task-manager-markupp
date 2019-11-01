<?php
/*удалить  пользователя*/
require_once(__DIR__."/conf.php");


if(!auth_is_admin()){
    flashError('Доступ запрещен!');
}
if(!isset($_POST['id'])  || (int)$_POST['id'] === 0){
  flashError('Не переданы основные поля!');
}



$id = (int)$_POST['id'];

$sql = "SELECT `user_status`, `id` FROM `users` WHERE `id`='".$mysqli->real_escape_string($id)."' ";
$res = $mysqli->query($sql);

if($res->num_rows === 0){
  flashError('Такого id нет в системе!');
}

$sql = "DELETE FROM `users` WHERE `id`='".$mysqli->real_escape_string($id)."'";
$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось удалить пользователя!');
}

flashSuccess("Пользователь удалить!");
