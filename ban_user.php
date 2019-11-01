<?php
require_once(__DIR__."/conf.php");


if(!auth_is_admin()){
    flashError('Доступ запрещен!');
}
if(!isset($_POST['id']) || !isset($_POST['ban']) || (int)$_POST['id'] === 0){
  flashError('Не переданы основные поля!');
}



$id = (int)$_POST['id'];
$ban = (int)$_POST['ban'];
$sql = "SELECT `user_status`, `id` FROM `users` WHERE `id`='".$mysqli->real_escape_string($id)."' ";
$res = $mysqli->query($sql);

if($res->num_rows === 0){
  flashError('Такого id нет в системе!');
}

$sql = "UPDATE `users` SET `ban`='".$mysqli->real_escape_string($ban)."' WHERE `id`='".$mysqli->real_escape_string($id)."'";
$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось заблокирован/разблокирован пользователя!');
}

flashSuccess("Пользователь успешно заблокирован/разблокирован!");
