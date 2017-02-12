<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    session_start();
    unset($_SESSION['auth']); //в auth хранятся данные авторизации этой сессии
    setcookie('rememberme','',0,'/'); //без этого кук не очищается
    echo 'logout'; //ответ аяксу
}
?>