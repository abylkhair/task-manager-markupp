<?php
/*Восстановление пароля*/
require_once(__DIR__."/conf.php");


if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    flashError('Не передан токен безопасности!');
}
if(!isset($_POST['email'])){
  flashError('Не переданы основные поля!');
}

if(trim($_POST['email']) === ''){
  flashError('Все поля должны быть заполнены!');
}

$email = trim($_POST['email']);
$sql = "SELECT `user_status`, `id` FROM `users` WHERE `email`='".$mysqli->real_escape_string($email)."' ";
$res = $mysqli->query($sql);

if($res->num_rows === 0){
  flashError('Такого email нет в системе!');
}
$array = $res->fetch_assoc();
$id = $array['id'];
$hash = bin2hex(openssl_random_pseudo_bytes(36));
$sql = "UPDATE `users` SET `hash`='".$mysqli->real_escape_string($hash)."' WHERE `id`='".$mysqli->real_escape_string($id)."'";
$res = $mysqli->query($sql);
if(!$res){
  flashError('К сожалению восстановление временено не доступно свяжитесь с тех. поддержкой!');
}
$message = "Перейдите по этой <a href='".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/reset-form.php?hash=".$hash."'>ссылке</a> и задайте новый пароль ";
$result =  send_mail(
        'Восстановление пароля!',  // имя отправителя
        'admin@webmygames.ru', // Админская почта
        'Восстановление пароля!',    // имя получателя
        $email,   // email получателя
        'UTF-8',        // кодировка переданных данных
        'KOI8-R',   // кодировка письма
        'Восстановление пароля', // тема письма
        $message,
        true  // письмо в виде html или обычного текста
      );
      if(!$result){
          flashError('К сожалению письмо не было отправлено на почту свяжитесь с тех. поддержкой!');
      }
flashSuccess("На вашу почту отправлено письмо с дальнейшей инструкцией!");
