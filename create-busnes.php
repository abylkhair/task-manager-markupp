<?php
/*добавитьт новое дело*/
require_once(__DIR__."/conf.php");

if(!auth_is_login()) {
    redirect('/login-form.php');
}
if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['name']) || !isset($_POST['date']) || !isset($_POST['priority']) || !isset($_POST['status'])){
  flashError('Не переданы основные поля!');
}

if(trim($_POST['name']) === '' || trim($_POST['date']) === '' || (int)$_POST['priority'] === 0 || (int)$_POST['status'] === 0){
  flashError('Все поля должны быть заполнены!');
}



//получение данных из $_POST
$name = trim($_POST['name']);
$date = strtotime($_POST['date']);
$status = (int)$_POST['status'];
$priority = (int)$_POST['priority'];




$sql = "INSERT INTO `business` SET `name`='".$mysqli->real_escape_string($name)."', ";
$sql .= " `date`='".$mysqli->real_escape_string($date)."', ";
$sql .= " `status`='".$mysqli->real_escape_string($status)."', ";
$sql .= " `id_user`='".$mysqli->real_escape_string($_SESSION['user_id'])."', ";
$sql .= " `priority`='".$mysqli->real_escape_string($priority)."' ";
$res = $mysqli->query($sql);
$id = (int)$mysqli->insert_id;
if($id > 0 ){
  redirect('/');
}else{
  flashError('К сожалению не удалось добавить новое дело!');
}
