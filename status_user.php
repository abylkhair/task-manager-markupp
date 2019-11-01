<?php
/*изменение статуса пользователя*/
require_once(__DIR__."/conf.php");


if(!auth_is_admin()){
    flashError('Доступ запрещен!');
}
if(!isset($_POST['id']) || !isset($_POST['user_status']) || (int)$_POST['id'] === 0){
  flashError('Не переданы основные поля!');
}



$id = (int)$_POST['id'];
$user_status = (int)$_POST['user_status'];
$sql = "SELECT `user_status`, `id` FROM `users` WHERE `id`='".$mysqli->real_escape_string($id)."' ";
$res = $mysqli->query($sql);

if($res->num_rows === 0){
  flashError('Такого id нет в системе!');
}

$sql = "UPDATE `users` SET `user_status`='".$mysqli->real_escape_string($user_status)."' WHERE `id`='".$mysqli->real_escape_string($id)."'";
$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось изменить статус пользователя!');
}

flashSuccess("Cтатус пользователя успешно изменен!");
