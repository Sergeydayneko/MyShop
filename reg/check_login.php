<?php
if($_SERVER["REQUEST_METHOD"] == "POST") //проверка что обратились методом пост и проверка данного файла на нужное имя(казывали в регистрация.пхп)
{
    //define('myeshop', true);
    include("../include/db_connect.php"); //подключеник к бд
    include("../functions/functions.php"); //для очищения строк от лишнего
    $login = clear_string($link, $_POST['reg_login']); //указываем название поля куда вводим логин name = reg_login
    $result = mysqli_query($link, "SELECT login FROM reg_user WHERE login = '$login'"); //проверка на наличие такого же
    If (mysqli_num_rows($result) > 0)
    {
        echo 'false';
    }
    else
    {
        echo 'true';
    }
}
?>