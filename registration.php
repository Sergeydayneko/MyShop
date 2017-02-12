<?php

    include("include/db_connect.php");
    include("functions/functions.php");
    session_start();
    include("include/auth_cookie.php");


// $_SESSION['auth'] = ' ';
// unset($_SESSION['auth']);


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
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="js/TextChange.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_reg').validate
            ({
                    //правила при проверке
                    rules:{
                        "reg_login":{
                            required:true, //не пустое ли поле (тру нельзя быть пустым, и наоборот)
                            minlength:5, //минимальная длина значения
                            maxlength:20,
                            remote: { //проверка на занятость логина(методом пост)
                                type: "post",
                                url: "/reg/check_login.php"
                            }
                        },

                        //далее задаем правила для каждой строки по айди
                        "reg_pass":{
                            required:true,
                            minlength:5,
                            maxlength:20
                        },
                        "reg_surname":{
                            required:true,
                            minlength:5,
                            maxlength:20
                        },
                        "reg_name":{
                            required:true,
                            minlength:5,
                            maxlength:20
                        },
                        "reg_patronymic":{
                            required:true,
                            minlength:5,
                            maxlength:20
                        },
                        "reg_email":{
                            required:true,
                            email:true //означает проверку по шаблону( test@test.ru )
                        },
                        "reg_phone":{
                            required:true
                        },
                        "reg_address":{
                            required:true
                        },
                        "reg_captcha":{
                            required:true,
                            remote: { //выполняемое действие хранится до конца сессии(пока пользователь не выйдет), зате мзакрывается
                                type: "post",
                                url: "/reg/check_captcha.php" //проверка капчи

                            }

                        }
                    },

                    //выводим сообщение при нарушении соответствующих правил
                    messages:{
                        "reg_login":{
                            required:"Input login!",
                            minlength:"from 5 to 20 symbols",
                            maxlength:"from 5 to 20 symbols",
                            remote: "Login is unavailable" //если логин занят
                        },
                        "reg_pass":{
                            required:"Input password!",
                            minlength:"from 5 to 20 symbols",
                            maxlength:"from 5 to 20 symbols"
                        },
                        "reg_surname":{
                            required:"Input surname!",
                            minlength:"from 5 to 20 symbols",
                            maxlength:"from 5 to 20 symbols"
                        },
                        "reg_name":{
                            required:"Input name!",
                            minlength:"from 5 to 20 symbols",
                            maxlength:"from 5 to 20 symbols"
                        },
                        "reg_patronymic":{
                            required:"Input patronymic",
                            minlength:"from 5 to 20 symbols",
                            maxlength:"from 5 to 20 symbols"
                        },
                        "reg_email":{
                            required:"Input email!",
                            email:"Incorrect email"
                        },
                        "reg_phone":{
                            required:"Input phone number!"
                        },
                        "reg_address":{
                            required:"Input address"
                        },
                        "reg_captcha":{
                            required:"Input text from picture!",
                            remote: "Text from picture is not correct!"
                        }
                    },


                    //то что будет происходит при нажатии на кнопку регистрации, то есть проверка информации на правильность
                    submitHandler: function(form){
                        $(form).ajaxSubmit({
                            success: function(data) {
                                //проверка информации на правильность
                                if (data == '1')
                                {
                                    $("#block-form-registration").fadeOut(300,function() { //fadeOut - означает что мы плавно убираем всё окно, чтобы написать что вы успешно зарегистрированы
                                        //айд рег меседж присваиваем класс рег месседжд гуд и выводим надпись
                                        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("You has been successfully registered");
                                        $("#form_submit").hide();

                                    });

                                } else { //если дата оказалась фолс, то выведем эррор и блок будет красного цвета
                                    $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data);
                                }
                            }
                        });
                    }
                });
        });

    </script>

    <title>Registration</title>
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


    <div id="block-content">


      <h2 class="h2-title">Registration</h2>
      <form method="post" id="form_reg" action="/reg/handler_reg.php">
      <p id="reg_message"></p>

      <div id="block-form-registration">
          <ul id="form-registration">

              <li>
                  <label>Login</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_login" id="reg_login">
              </li>

              <li>
                  <label>Password</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_pass" id="reg_pass">
                  <span id="genpass">Generate</span>
              </li>

              <li>
                  <label>Surname</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_surname" id="reg_surname">
              </li>

              <li>
                  <label>Name</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_name" id="reg_name">
              </li>

              <li>
                  <label>Patronymic</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_patronymic" id="reg_patronymic">
              </li>

              <li>
                  <label>Email</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_email" id="reg_email">
              </li>

              <li>
                  <label>Mobile phone</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_phone" id="reg_phone">
              </li>

              <li>
                  <label>Address</label>
                  <span class="star">*</span>
                  <input type="text" name="reg_address" id="reg_address">
              </li>


              <li>
                  <div id="block-captcha">
                      <img src="/reg/reg_captcha.php">
                      <input type="text" name="reg_captcha" id="reg_captcha">
                      <p id="reloadcaptcha">Refresh</p>
                  </div>
              </li>

          </ul>
      </div>

          <p align="right"><input type="submit" name="reg_submit" id="form_submit" value="Registration"> </p>

      </form>

    </div>

    <?php
    include("include/block-footer.php");
    ?>

</div>

</body>
</html>