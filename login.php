<?php
require_once(__DIR__."/conf.php");


if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['email']) || !isset($_POST['password'])){
  flashError('Не переданы основные поля!');
}

if(trim($_POST['email']) === '' || trim($_POST['password']) === ''){
  flashError('Все поля должны быть заполнены!');
}

$email = trim($_POST['email']);
$password = md5(trim($_POST['password']));

$sql = "SELECT * FROM `users` WHERE `email`='".$mysqli->real_escape_string($email)."' AND ";
$sql .= " `password`='".$mysqli->real_escape_string($password)."' ";
$res = $mysqli->query($sql);

if($res->num_rows === 0){
  flashError('Введен неверно логин и/или пароль!');
}
$array = $res->fetch_assoc();
if(!isset($array['ban']) || (int)$array['ban'] === 1){
  flashError('Данный аккаунт был заблокирован!');
}
$_SESSION['user_id'] = $array['id'];
$_SESSION['status'] = $array['user_status'];
  redirect('/');
die();
//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost;dbname=task_manager', 'root', '');
$sql = 'SELECT id,username,email from users where email=:email AND password=:password';
$statement = $pdo->prepare($sql);
$statement->execute([
	':email'	=>	$email,
	':password'	=>	md5($password)
]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
//Не нашли пользователя
if(!$user) {
    $errorMessage = 'Неверный логин или пароль';
    include 'errors.php';
    exit;
}
//Нашли и записываем нужные данные в сессию
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];
//переадресовываем на главную
header('Location: /index.php');
exit;
