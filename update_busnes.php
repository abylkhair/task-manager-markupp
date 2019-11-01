<?php
/*редактирования дела*/
require_once(__DIR__."/conf.php");
if(!auth_is_login()) {
    redirect('/');
}

if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['id'])  || (int)$_POST['id'] === 0){
  flashError('Доступ к данной странице закрыт!');
}

if(!isset($_POST['name']) || !isset($_POST['date']) || !isset($_POST['priority']) || !isset($_POST['status'])){
    flashError('Все поля должны быть заполнены!');
}


if(trim($_POST['name']) === "" || trim($_POST['date']) === "" || (int)$_POST['priority'] === 0 || (int)$_POST['status'] === 0){
    flashError('Все поля должны быть заполнены!');
}
$name = trim($_POST['name']);
$priority= trim($_POST['priority']);
$status = trim($_POST['status']);
$date = strtotime($_POST['date']);




$id = $_POST['id'];



$sql = "UPDATE `business` SET `name`='".$mysqli->real_escape_string($name)."' ,";
$sql .= "  `priority`='".$mysqli->real_escape_string($priority)."', ";
$sql .= "  `status`='".$mysqli->real_escape_string($status)."', ";
$sql .= "   `date`='".$mysqli->real_escape_string($date)."' ";
$sql .= "  WHERE `id`='".$mysqli->real_escape_string($id)."' ";

$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось отредактировать информацию!');
}

redirect('/');
