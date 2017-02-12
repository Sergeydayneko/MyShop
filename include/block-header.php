<!--Основной блок хедер-->
<div id="block-header">
<!-- Верхний блок с навигацией-->
    <div id="header-top-block">
<!--Список с навигацией-->
        <ul id="header-top-menu">
            <li>Your city - <span>Moscow</span></li>
            <li><a href="About us.php">About us</a></li>
            <li><a href="Shops.php">Shops</a></li>
            <li><a href="Contacts.php">Contacts</a></li>
        </ul>
<!--Вход и регистрация-->

        <?php
        if (!empty($_SESSION['auth']) == 'yes_auth' && ($_SESSION['auth']) == 'yes_auth' )
        {

            echo '<p id="auth-user-info" align="right"><img src="../images/user.png" />Welcome, '.$_SESSION['auth_name'].'!</p>';

        } else{

            echo '<p id="reg-auth-title" align="right"><a class="top-auth">Enter</a><a href="registration.php">Registration</a></p>';

        }

        ?>


    <div id="block-top-auth">
        <div class="corner"></div>
        <form method="post">
            <ul id="input-email-pass">
                <h3>Input information</h3>
                <p id="message-auth">Incorrect login or(and) password</p>
                <li><center><input type="text" id="auth_login" placeholder="Login or email"></center></li>
                <!-- И пароль и класс нужен для прикрпления джава скрипта, чтобы отследить нажатие. По умолчанию пароль мы видим -->
                <li><center><input type="password" id="auth_pass" placeholder="Password"><span id="button-pass-show-hide" class="pass-show"></center></span></li>
                <ul id="list-auth">
                <!--Присваиваем в спане rememberme  в функции for для того чтобы можно было ставить галочку при запоминании-->
                    <li><input type="checkbox" name="rememberme" id="rememberme"><label for="rememberme">remember me</label></li>
                    <li><a id="remindpass" href="#">Forgot password?</a></li>
                </ul>
                <p align="right" id="button-auth"><a>Enter</a></p>
                <p align="right" class="auth-loading"><img src="../images/loading.gif"></p>
            </ul>
        </form>

        <div id="block-remind">
            <h3>Restore<br /> password</h3>
                  <!-- проверка email'a -->
            <p id="message-remind" class="message-remind-success" ></p>
            <!--поле для внесения e-mail'a-->
            <center><input type="text" id="remind-email" placeholder="Your E-mail" /></center>
            <p align="right" id="button-remind" ><a>Done</a></p> <!--кнопка для выполнения -->
            <p align="right" class="auth-loading" ><img src="/images/loading.gif" /></p> <!--гифка загрузка нужна чтобы пользователь понимал что идет загрузка -->
            <p id="prev-auth">Back</p>
        </div>



    </div>


    </div>
<!--  Линия -->
    <div id="top-line"></div>

    <div id="block-user" >
        <div class="corner2"></div>
        <ul>
            <li><img src="../images/user_info.png" /><a href="profile.php">Your profile</a></li>
            <li><img src="../images/logout.png" /><a id="logout" >Log out </a></li>
        </ul>
    </div>



<!-- Верхняя картинка с компъютером -->
    <a href="index.php"><img src="../images/logo.jpg" width="330" height="150" id="img-logo"/></a>
<!--Информационный блок-->
    <div id="personal-info">
        <p>Call us for free</p>
        <h3>8-800-700-55-33</h3>

        <img src="../images/phone.png" width="40" height="40"/>

        <p>Opening ours</p>
        <p>8:00 to 22:00 Weekends</p>
        <p>Saturday-Sunday weekend</p>

        <img src="../images/time.png" width="45" height="45"/>

    </div>
<!-- Форма для поиска-->
    <div id="block-search">
        <form method="GET" action="search.php?q=" >
            <input type="text" id="input-search" name="q" placeholder="Click and Find what you need" value="<?php echo $search;?>" />
            <input type="submit" id="button-search" value="Search" />
        </form>

        <ul id="result-search">

        </ul>


    </div>

</div>
<!--Меню под картинкой компьютера на главной странице-->
<div id="top-menu">

    <ul>
        <li><img src="../images/best-price.png"><a href="">Best price</a></li>
        <li><img src="../images/People-choice.png"><a href="">People choice</a></li>
        <li><img src="../images/most-popular.png"><a href="">Most popular</a></li>
        <li><img src="../images/novelty.png"><a href="">Novelty</a></li>
    </ul>

    <p align="right" id="block-basket"><img src="../images/block-basket.png"><a href="cart.php?action=oneclick">Cart is empty</a></p>
    <hr>

</div>

