<?php
/*удалить  дело*/
require_once(__DIR__."/conf.php");


if(!auth_is_login()){
    flashError('Доступ запрещен!');
}
if(!isset($_POST['id'])  || (int)$_POST['id'] === 0){
  flashError('Не переданы основные поля!');
}



$id = (int)$_POST['id'];

$sql = "SELECT * FROM `business` WHERE `id`='".$mysqli->real_escape_string($id)."' ";
$res = $mysqli->query($sql);

if($res->num_rows === 0){
  flashError('Такого id нет в системе!');
}

$sql = "DELETE FROM `business` WHERE `id`='".$mysqli->real_escape_string($id)."'";
$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось удалить запись!');
}

flashSuccess("Запись удалена!");
