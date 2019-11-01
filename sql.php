<?php
	    //sql.php
	    $server = "localhost"; //Ваш сервер MySQL
	    $user = "root"; //Ваше имя пользователя MySQL
	    $pass = ""; //пароль
	 
	    $conn = mysql_connect($server, $user, $pass);//соединение с сервером
	    $db = mysql_select_db("panel", $conn);//выбор базы данных
	 
	    if(!$db) { //если не может выбрать базу данных
	        echo "Извините, ошибка :(/>";//Показывает сообщение об ошибке
	        exit(); //Позволяет работать остальным скриптам PHP
	    }
	?>