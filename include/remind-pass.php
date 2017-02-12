<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //define('myeshop', true);
    include("db_connect.php");
    include("../functions/functions.php");
    $email = clear_string($link, $_POST["email"]);
    if ($email != "")
    {

        $result = mysqli_query($link, "SELECT email FROM reg_user WHERE email='$email'");
        If (mysqli_num_rows($result) > 0)
        {

// генерация пароля
            $newpass = fungenpass(); //создали в functions

// шифрование пароля
            $pass   = md5($newpass);
            $pass   = strrev($pass);
            $pass   = strtolower("9nm2rv8q".$pass."2yo6z");

// Передача обновленного пароля в базу данных
            $update = mysqli_query ($link, "UPDATE reg_user SET pass='$pass' WHERE email='$email'");

// Îòïðàâêà íîâîãî ïàðîëÿ.

            send_mail( 'noreply@shop.ru',
                $email,
                'New password MyShop.ru',
                'now your password is: '.$newpass);

            echo 'yes';

        }else
        {
            echo 'Wrong E-mail';
        }
    }
    else
    {
        echo 'Input your E-mail';
    }
}
?>