<?php
    if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'yes_auth' && !empty($_COOKIE["rememberme"])) //если авторизирован и файл кук существует
    {

    $str = $_COOKIE["rememberme"]; //переманная ремембер из ауса

    // вся длина строки стрлен - подсчитывает длину строки
    $all_len = strlen($str);
    // длина логинаё   . + это разделитель логина и пароля. Таким образом определяем количество символов до плюса
    $login_len = strpos($str,'+');
    //Обрезаем лишнее, учитывая вышеперечисленное
    $login = clear_string($link, substr($str,0,$login_len));

    // Обрезаем лишнее, учитывая вышеперечисленное
    $pass = clear_string($link, substr($str,$login_len+1,$all_len));

    $result = mysqli_query($link, "SELECT * FROM reg_user WHERE (login = '$login' or email = '$login') AND pass = '$pass'");
    If (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        session_start();
        $_SESSION['auth'] = 'yes_auth';
        $_SESSION['auth_pass'] = $row["pass"];
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_address'] = $row["address"];
        $_SESSION['auth_phone'] = $row["phone"];
        $_SESSION['auth_email'] = $row["email"];
    }

}
?>
