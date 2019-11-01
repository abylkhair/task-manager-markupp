<?php
require_once(__DIR__."/conf.php");


if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])){
  flashError('Не переданы основные поля!');
}

if(trim($_POST['username']) === '' || trim($_POST['email']) === '' || trim($_POST['password']) === ''){
  flashError('Все поля должны быть заполнены!');
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    flashError('Передан некоректный email!');
}

//получение данных из $_POST
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = md5(trim($_POST['password']));


$sql = "SELECT `id` FROM `users` WHERE `email`='".$mysqli->real_escape_string($email)."'";
$res = $mysqli->query($sql);
if($res->num_rows > 0){
  flashError('Пользователь с таким email уже зарегистрирован в системе!');
}

$sql = "INSERT INTO `users` SET `username`='".$mysqli->real_escape_string($username)."', ";
$sql .= " `email`='".$mysqli->real_escape_string($email)."', ";
$sql .= " `password`='".$mysqli->real_escape_string($password)."' ";
$res = $mysqli->query($sql);
$id = (int)$mysqli->insert_id;
if($id > 0 ){
  $_SESSION['user_id'] = $id;
  redirect('/');
}else{
  flashError('К сожалению не удалось зарегистрироваться, напишите в тех. поддрежку!');
}

die();



//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost;dbname=task_manager', 'root', '');
$sql = 'SELECT id from users where email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email'	=>	$email]);
$user = $statement->fetchColumn();
if($user) {
    $errorMessage = 'Пользователь с таким email уже существует';
    include 'errors.php';
    exit;
}
$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);
//password hash
$_POST['password'] = md5($_POST['password']);
$result = $statement->execute($_POST);
if(!$result) {
    $errorMessage = 'Ошибка регистрации';
    include 'errors.php';
    exit;
}
//переадресация на авторизацию(login-form.php)
header('Location: /login-form.php'); exit;
