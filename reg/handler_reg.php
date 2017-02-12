<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
//    define('myeshop', true);
    include("../include/db_connect.php");
    include("../functions/functions.php");

    $error = array(); //создание из переменной массива, идут проверки. Более детально, чтобы валидация проходила правильно.Массива нужен чтобы создаваать много переменных,а не одно сообщение об ошибке

    $login = clear_string($link, $_POST['reg_login']); //засение переменных, так же перекодировка для локального сервера(потом надо убрать)
    $pass = clear_string($link, $_POST['reg_pass']);
    $surname =clear_string($link, $_POST['reg_surname']);

    $name = clear_string($link, $_POST['reg_name']);
    $patronymic = clear_string($link, $_POST['reg_patronymic']);
    $email = clear_string($link, $_POST['reg_email']);

    $phone = clear_string($link, $_POST['reg_phone']);
    $address = clear_string($link, $_POST['reg_address']);


    if (strlen($login) < 5 or strlen($login) > 20) // проверка логина на длину
    {
        $error[] = "from 5 to 20 symbols";
    }

    else
    {
        $result = mysqli_query($link, "SELECT login FROM reg_user WHERE login = '$login'");
        If (mysqli_num_rows($result) > 0)
        {
            $error[] = "Login is unavailable!";
        }

    }

    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "from 5 to 20 symbols";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "from 5 to 20 symbols";
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "from 5 to 20 symbols";
    if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "from 5 to 20 symbols";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) $error[] = "incorrect email"; //проверка почты.
    if (!$phone) $error[] = "Phone number is not correct";
    if (!$address) $error[] = "address is not correct";

    if ($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "Text from picture is not correct!";
    unset($_SESSION['img_captcha']);

    if (count($error)) {

        echo implode('<br />', $error); //выводим ошибки на экран. implode делает из массива строку и указываем как бьудем разделять сообщения. Разделяем с помощью бр

    } else {
        $pass   = md5(clear_string($link, $_POST["pass"]));  //нижние 3 строки шифрует пароль(в данном случае устаревший
        $pass = strrev($pass);
        $pass = "9nm2rv8q" . $pass . "2yo6z";

        $ip = $_SERVER['REMOTE_ADDR']; //добавление ip(необязательно)

        mysqli_query($link, "INSERT INTO reg_user(login,pass,surname,name,patronymic,email,phone,address,datetime,ip)
						VALUES(
						    
							'" . $login . "',
							'" . $pass . "',
							'" . $surname . "',
							'" . $name . "',
							'" . $patronymic . "',
                            '" . $email . "',
                            '" . $phone . "',
                            '" . $address . "',
                            NOW(),
                            '" . $ip . "'							
						)");
        echo '1';
    }
}
?>