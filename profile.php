<?php
session_start();

if ($_SESSION['auth'] == 'yes_auth')
{
    include("include/db_connect.php");
    include("functions/functions.php");

    if (!empty($_GET['q'])) {$search = clear_string($link, $_GET['q']);} else $search = "";
    if ($_POST["save_submit"]) //определяем нажатие кнопки
    {
        //проверяем все наши поля. Вместо $_POST[] можно добавлять просто любую переменную
        $_POST["info_surname"] = clear_string($link, $_POST["info_surname"]);
        $_POST["info_name"] = clear_string($link, $_POST["info_name"]);
        $_POST["info_patronymic"] = clear_string($link, $_POST["info_patronymic"]);
        $_POST["info_address"] = clear_string($link, $_POST["info_address"]);
        $_POST["info_phone"] = clear_string($link, $_POST["info_phone"]);
        $_POST["info_email"] = clear_string($link, $_POST["info_email"]);

        $error = array();  //массив для сбора ошибок

        $pass   = md5($_POST["info_pass"]);
        $pass   = strrev($pass);
        $pass   = "9nm2rv8q".$pass."2yo6z";

        if($_SESSION['auth_pass'] != $pass)
        {
            $error[]='Wrong current password!';
        }else
        {

            if($_POST["info_new_pass"] != "")
            {
                if(strlen($_POST["info_new_pass"]) < 5 || strlen($_POST["info_new_pass"]) > 15)
                {
                    $error[]='New password must be form 5 to 15 symbols';
                }else
                {
                    $newpass   = md5(clear_string($link, $_POST["info_new_pass"]));
                    $newpass   = strrev($newpass);
                    $newpass   = "9nm2rv8q".$newpass."2yo6z";
                    $newpassquery = "pass='".$newpass."',"; //Для обновления в базе данных
                }
            }



            if(strlen($_POST["info_surname"]) < 5 || strlen($_POST["info_surname"]) > 15)
            {
                $error[]='Surname must be form 5 to 15 symbols';
            }


            if(strlen($_POST["info_name"]) < 5 || strlen($_POST["info_name"]) > 15)
            {
                $error[]='Name must be form 5 to 15 symbols';
            }


            if(strlen($_POST["info_patronymic"]) < 5 || strlen($_POST["info_patronymic"]) > 25)
            {
                $error[]='Patronymic must be form 5 to 25 symbols';
            }


            if(!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["info_email"])))
            {
                $error[]='Wrong email!';
            }

            if(strlen($_POST["info_phone"]) == "")
            {
                $error[]='Wrong phone!';
            }

            if(strlen($_POST["info_address"]) == "")
            {
                $error[]='Wrong address!';
            }



        }

        if(count($error))
        {
            $_SESSION['msg'] = "<p align='left' id='form-error'>".implode('<br />',$error)."</p>";
        }else
        {
            $_SESSION['msg'] = "<p align='left' id='form-success'>Data has been succesfully saved!</p>";

            $dataquery = $newpassquery."surname='".$_POST["info_surname"]."',name='".$_POST["info_name"]."',patronymic='".$_POST["info_patronymic"]."',email='".$_POST["info_email"]."',phone='".$_POST["info_phone"]."',address='".$_POST["info_address"]."'";
            $update = mysqli_query($link, "UPDATE reg_user SET $dataquery WHERE login = '{$_SESSION['auth_login']}'");

            if ($newpass){ $_SESSION['auth_pass'] = $newpass; }


            $_SESSION['auth_surname'] = $_POST["info_surname"];
            $_SESSION['auth_name'] = $_POST["info_name"];
            $_SESSION['auth_patronymic'] = $_POST["info_patronymic"];
            $_SESSION['auth_address'] = $_POST["info_address"];
            $_SESSION['auth_phone'] = $_POST["info_phone"];
            $_SESSION['auth_email'] = $_POST["info_email"];

        }

    }
    ?>


<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html" charset="UTF-8"/>
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="js/shop-script.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="js/TextChange.js"></script>

    <title>Mobile-phone shop</title>
</head>

<body>

<div id="block-body">

    <?php
    include("include/block-header.php");
    ?>

    <div id="block-right">

        <?php
        include("include/block-category.php");
        include("include/block-parameter.php");
        include("include/block-news.php");
        ?>


    </div>

    <h3 class="title-h3" >Change your profile</h3>

    <?php
    if ($_SESSION['msg']) { //проверка сесси на сообщения. ТО есть ли ошибки при введении данных и их вывод
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="post">

        <ul id="info-profile">
            <li>
                <label for="info_pass">Current password</label>
                <span class="star">*</span>
                <input type="text" name="info_pass" id="info_pass" value="" />
            </li>

            <li>
                <label for="info_new_pass">New password</label>
                <span class="star">*</span>
                <input type="text" name="info_new_pass" id="info_new_pass" value="" />
            </li>

            <li>
                <label for="info_surname">Surname</label>
                <span class="star">*</span>
                <input type="text" name="info_surname" id="info_surname" value="<?php echo $_SESSION['auth_surname']; ?>"  />
            </li>

            <li>
                <label for="info_name">Name</label>
                <span class="star">*</span>
                <input type="text" name="info_name" id="info_name" value="<?php echo $_SESSION['auth_name']; ?>"  />
            </li>

            <li>
                <label for="info_patronymic">Patronimyc</label>
                <span class="star">*</span>
                <input type="text" name="info_patronymic" id="info_patronymic" value="<?php echo $_SESSION['auth_patronymic']; ?>" />
            </li>


            <li>
                <label for="info_email">E-mail</label>
                <span class="star">*</span>
                <input type="text" name="info_email" id="info_email" value="<?php echo $_SESSION['auth_email']; ?>" />
            </li>

            <li>
                <label for="info_phone">Phone</label>
                <span class="star">*</span>
                <input type="text" name="info_phone" id="info_phone" value="<?php echo $_SESSION['auth_phone']; ?>" />
            </li>

            <li>
                <label for="info_address">Your address</label>
                <span class="star">*</span>
                <textarea name="info_address"  > <?php echo $_SESSION['auth_address']; ?> </textarea>
            </li>

        </ul>

        <p align="right"><input type="submit" id="form_submit" name="save_submit" value="Save changes" /></p>
    </form>


    <div id="block-content">

    </div>

    <?php
    include("include/block-footer.php");
    ?>

</div>

</body>
</html>

<?php
} else {
    header("Location: index.php");
}


?>