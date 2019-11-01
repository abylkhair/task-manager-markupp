<?php
/*Подключение файла*/
require_once(__DIR__."/conf.php");
/*Проверка на администатора*/
if(!auth_is_admin()) {
    redirect('/');
}
/*Условия на ошибки*/
if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['id'])  || (int)$_POST['id'] === 0){
  flashError('Доступ к данной странице закрыт!');
}


if(!isset($_POST['password']) || !isset($_POST['password2'])){
    flashError('Все поля должны быть заполнены!');
}

if(!isset($_POST['username']) || !isset($_POST['email']) || trim($_POST['username']) === "" || trim($_POST['email']) === ""){
    flashError('Все поля должны быть заполнены!');
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = "";
if(trim($_POST['password']) !== ''){
  if($_POST['password'] !== $_POST['password2']){
      flashError('Пароли не совпадают!');
  }
  $password = md5(trim($_POST['password']));
}


$id = $_POST['id'];



$sql = "UPDATE `users` SET `username`='".$mysqli->real_escape_string($username)."' ,";
if(trim($password) !== ''){
  $sql .= "  `password`='".$mysqli->real_escape_string($password)."', ";
}
$sql .= "   `email`='".$mysqli->real_escape_string($email)."' ";
$sql .= "  WHERE `id`='".$mysqli->real_escape_string($id)."' ";

$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению не удалось отредактировать информацию!');
}

redirect('/');
