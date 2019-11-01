<?php
/*сброс пароля*/
require_once(__DIR__."/conf.php");


if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['hash']) || !isset($_POST['id']) || trim($_POST['hash']) === '' || (int)$_POST['id'] === 0){
  flashError('Доступ к данной странице закрыт!');
}
if(!isset($_POST['password']) || !isset($_POST['password2'])){
    flashError('Все поля должны быть заполнены!');
}
if(trim($_POST['password']) === '' || trim($_POST['password2']) === ''){
      flashError('Все поля должны быть заполнены!');
}
if($_POST['password'] !== $_POST['password2']){
    flashError('Пароли не совпадают!');
}

$password = md5(trim($_POST['password']));
$id = $_POST['id'];
$hash = $_POST['hash'];


$sql = "UPDATE `users` SET `password`='".$mysqli->real_escape_string($password)."' ,";
$sql .= " `hash`='' WHERE `id`='".$mysqli->real_escape_string($id)."' AND ";
$sql .= " `hash`='".$mysqli->real_escape_string($hash)."'";
$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось изменить пароль!');
}

redirect('/');
