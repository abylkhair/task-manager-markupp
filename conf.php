<?php

session_start();
//Подключение к базе данных
$mysqli = new mysqli('localhost', 'root', '', 'task_manager');
$mysqli->set_charset('utf8');

/*Универсальная функция редиректа можно передавать адрес перенаправления по умолчанию редирект идет на страницу откудапришел пользователь!*/
function redirect($uri = ""){

  if($uri === ''){
    $uri = '/';
    if(isset($_SERVER['HTTP_REFERER'])){
      $uri = $_SERVER['HTTP_REFERER'];
    }
  }
  header("Location: ".$uri);
  exit();
}

/*функция вывода сообщений*/
function flash_show(){
  if(isset($_SESSION['error']) && trim($_SESSION['error']) !== ''){
    $error = $_SESSION['error'];
      unset($_SESSION['error']);
    return $error;

  }
  if(isset($_SESSION['success']) && trim($_SESSION['success']) !== ''){
    $success = $_SESSION['success'];
        unset($_SESSION['success']);
    return $success;

  }
}

/*Вывод ошибки*/
function flashError($message){
  $_SESSION['error'] = "<p style='color:red; text-align:center;'>".$message."</p>";
  redirect();
}
/*Вывод успешного сообщения*/
function flashSuccess($message){
  $_SESSION['success'] = "<p style='color:green; text-align:center;'>".$message."</p>";
  redirect();
}
/*Генерация scrf токена*/
function scrf(){
  $token = bin2hex(openssl_random_pseudo_bytes(33));
  $_SESSION['token'] = $token;
  echo "<input type='hidden' name='token' value='".$token."'/>";
}
/*Проверка авторизации пользователя */
function auth_is_login(){
  if(!isset($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0){
      return false;
  }
  return true;
}


/*Проверка администратора */
function auth_is_admin(){
  if(!auth_is_login() || !isset($_SESSION['status']) || (int)$_SESSION['status'] === 0){
      return false;
  }
  return true;
}



/*функции для отправки почты */
function send_mail(
          $n_from,    # имя отправителя
          $e_from,   # email отправителя
          $n_to,      # имя получателя
          $e_to,     # email получателя
          $charset, # кодировка переданных данных
          $charset2, # кодировка письма
          $theme,      # тема письма
          $text,         # текст письма
          $flag          # письмо в виде html или обычного текста
        ) {

        $to = header_encode($n_to, $charset, $charset2) . ' <' . $e_to . '>';
        $theme = header_encode($theme, $charset, $charset2);
        $from =  header_encode($n_from, $charset, $charset2) .' <' . $e_from . '>';

        if($charset != $charset2) {
          $text = iconv($charset, $charset2, $text);
        }

      $headers = "From: $from\r\n";
      $type = ($flag) ? 'html' : 'plain';
      $headers .= "Content-type: text/$type; charset=$charset2\r\n";
      $headers .= "Mime-Version: 1.0\r\n";

      return mail ($to, $theme, $text, $headers);
}

function header_encode($string, $charset, $charset2) {
  if($charset != $charset2) {
    $string = iconv($charset, $charset2, $string);
  }
  return '=?' . $charset2 . '?B?' . base64_encode($string) . '?=';
}
