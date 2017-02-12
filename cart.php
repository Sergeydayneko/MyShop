<?php

include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");

if (!empty($_GET['q'])) {$search = clear_string($link, $_GET['q']);} else $search = "";

//  unset($_SESSION['auth']);
//    setcookie('rememberme', '', 0, '/');  //в auth.php мы устанавливали значения прежде

if (!empty($_GET['id'])){ $id = clear_string($link, $_GET["id"]); } else $id = ""; //для удаление товаров
$action = clear_string($link, $_GET["action"]);

switch ($action) { //проверка есть ли в переменной action какое-либо ключевое слово( или clear или delete )
    case 'clear':
        $clear = mysqli_query($link, "DELETE FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
        break;

    case 'delete':
        $delete = mysqli_query($link, "DELETE FROM cart WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
        break;

}

//если нажимаем кнопку, то добавляем данные в сессию
if (isset($_POST["submitdata"]))
{
    $_SESSION["order_delivery"] = $_POST["order_delivery"];
    $_SESSION["order_fio"] = $_POST["order_fio"];
    $_SESSION["order_mail"] = $_POST["order_mail"];
    $_SESSION["order_phone"] = $_POST["order_phone"];
    $_SESSION["order_address"] = $_POST["order_address"];
    $_SESSION["order_note"] = $_POST["order_note"];

    header("Location: cart.php?action=completion"); //перенаправляем пользователя дальше(на 3 ступень)
}

//Для вывода финальной суммы на странице 3х3
$result = mysqli_query($link, "SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
If (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $int = 0;
    do {
        $int = $int + ($row["price"] * $row["cart_count"]);
    } while  ($row = mysqli_fetch_array($result));

    $itogpricecart = $int;
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

    <title>Shop-cart</title>
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

        <?php
        $action = clear_string($link, $_GET["action"]);
        switch ($action) {

            case 'oneclick':
                echo '
                <div id="block-step">       
                <div id="name-step">
                <ul>
                <li><a class="active">1. The cart</a></li>
                <li><span>	&rarr;</span></li>
                <li><a>2. Contact informationt</a></li>
                <li><span>	&rarr;</span></li>
                <li><a>3. Last step</a></li>                       
                </ul>
                 </div>
                <p>Step 1 of 3</p>       
                </div>
                ';


                    //айпи сервера узнаем по глобальной команде REMOTE_ADDR. Её можно узнавать только вызыввая в фигурных скобках. Здесь выбираем товары, который выбрал пользователь с данным айпи
        $result = mysqli_query($link, "SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
        If (mysqli_num_rows($result) > 0)
        {
        $row = mysqli_fetch_array($result);

        echo '
                <div id="header-list-cart">    
                <div id="head1">Image</div>
                <div id="head2">Name of product</div>
                <div id="head3">Quantity</div>
                <div id="head4">Price</div>
                </div>
                ';
        $all_price = 0;
        do {
            $int = $row["cart_price"] * $row["cart_count"]; //определение общей цены
            $all_price = $all_price + $int; //прибавляем цену товара к общей цене

            if (strlen($row["image"]) > 0 && file_exists("./uploads_images/" . $row["image"])) {
                $img_path = './uploads_images/' . $row["image"];
                $max_width = 100;
                $max_height = 100;
                list($width, $height) = getimagesize($img_path);
                $ratioh = $max_height / $height;
                $ratiow = $max_width / $width;
                $ratio = min($ratioh, $ratiow);
                $width = intval($ratio * $width);
                $height = intval($ratio * $height);
            } else {
                $img_path = "images/noimages.jpeg";
                $width = 120;
                $height = 105;
            }


            echo '
            
                <div class="block-list-cart">
    <div class="img-cart">
        <p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></p>
    </div>
    
    <div class="title-cart">
        <p><a href="">'.$row["title"].'</a></p>
        <p class="cart-mini-features">
        '.$row["mini_features"].'
        </p>
    </div>
    
    <div class="count-cart">
        <ul class="input-count-style">
        <li>
        <p align="center" id="" class="count-minus">-</p>
        </li>
        <li>
        <p align="center"><input id="" id="" class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'" /></p>
        </li>
        <li>
        <p align="center" iid="" class="count-plus">+</p>
        </li>
        </ul>
    </div>
    
    <div id="tovar" class="price-product"><h5><span class="span-count" >'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p>'.$int.'</p></div>
        <div class="delete-cart"><a  href="cart.php?id='.$row["cart_id"].'&action=delete" ><img src="images/bsk_item_del.png" /></a></div>
        <div id="bottom-cart-line"></div>
    </div>
                ';

        }
        while ($row = mysqli_fetch_array($result));

            echo '
 <h2 class="itog-price" align="right">In total: <strong>'.($all_price).'</strong> $</h2>
 <p align="right" class="button-next" ><a href="cart.php?action=confirm" >Next</a></p> 
 ';

        }
        else
        {
            echo '<h3 id="clear-cart" align="center">Cart is emty</h3>';
        }

            break;


            case 'confirm':

                echo '
                <div id="block-step">
                
                <div id="name-step">
                <ul>
                <li><a href="cart.php?action=oneclick">1. The cart</a></li>
                <li><span>	&rarr;</span></li>
                <li><a class="active">2. Contact informationt</a></li>
                <li><span>	&rarr;</span></li>
                <li><a>3. Last step</a></li>                       
                </ul>
                 </div>
                
                <p>Step 2 of 3</p>
                
                </div>
                ';
                    //сессии нужны чтобы при возврате назад, введенные данные сохрнились

                if ($_SESSION['order_delivery'] == "By mail") { $chck1 = "checked"; } else $chck1 = "";
                if ($_SESSION['order_delivery'] == "By courier") { $chck2 = "checked"; } else $chck2 = "";
                if ($_SESSION['order_delivery'] == "By yourself") { $chck3 = "checked"; } else $chck3 = "";

                echo '

    <h3 class="title-h3" >Way of delivery:</h3>
    <form method="post">
        <ul id="info-radio"> 
        
            <li>
            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="By mail" '.$chck1.'  />
            <label class="label_delivery" for="order_delivery1">By mail</label>
            </li>
        
            <li>
            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="By courier" '.$chck2.' />
            <label class="label_delivery" for="order_delivery2">By courierì</label>
            </li>
        
            <li>
            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="By yourself" '.$chck3.' />
            <label class="label_delivery" for="order_delivery3">By yourself</label>
             </li>
        </ul>
    <h3 class="title-h3" >Information for delivery:</h3>
    <ul id="info-order">
                ';


                if (!isset($_SESSION['auth'])) //проверка для того чтобы узнать вывоить все строки заполнение или уже кто-то авторизовался и эти строки брать из учетной записи
                {

                echo '

                <li><label for="order_fio"><span>*</span>Full name</label><input type="text" name="order_fio" id="order_fio" value="'.$_SESSION["order_fio"].'" /><span class="order_span_style" >Example: Johny Johny Johny</span></li>
                <li><label for="order_email"><span>*</span>E-mail</label><input type="text" name="order_email" id="order_email" value="'.$_SESSION["order_mail"].'" /><span class="order_span_style" >Example: ivanov@mail.ru</span></li>
                <li><label for="order_phone"><span>*</span>Phone</label><input type="text" name="order_phone" id="order_phone" value="'.$_SESSION["order_phone"].'" /><span class="order_span_style" >Example: 8 950 100 12 34</span></li>
                <li><label class="order_label_style" for="order_address"><span>*</span>Address<br />of delivery</label><input type="text" name="order_address" id="order_address" value="'.$_SESSION["order_address"].'" /><span>Example: NYC <br />Lenina st. 58\3</span></li>
                    
                    ';}

                echo '
                <li><label class="order_label_style" for="order_note">Note</label><textarea name="order_note"  >'.$_SESSION["order_note"].'</textarea><span>Give us more information<br />For example,<br />near Atomic Station</span></li>
                </ul>
                <p align="right" ><input type="submit" name="submitdata" id="confirm-button-next" value="Next" /></p>
                </form>
                    ';

                break;



            case 'completion':
                echo '
                <div id="block-step">
                
                <div id="name-step">
                <ul>
                <li><a href=cart.php?action=oneclick">1. The cart</a></li>
                <li><span>	&rarr;</span></li>
                <li><a href="cart.php?action=confirm">2. Contact informationt</a></li>
                <li><span>	&rarr;</span></li>
                <li><a class="active">3. Last step</a></li>                       
                </ul>
                
                 </div>
                <p>Step 3 of 3</p>
                </div>
                <h3 id="FN">Final information</h3>
                ';

        if (!empty($_SESSION['auth']) && $_SESSION['auth'] == 'yes_auth' )
        {
            echo '
    <ul id="list-info" >
        <li><strong>Delivery way:</strong>'.$_SESSION['order_delivery'].'</li>
        <li><strong>Email:</strong>'.$_SESSION['auth_email'].'</li>
        <li><strong>Full name:</strong>'.$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymic'].'</li>
        <li><strong>Address of delivery:</strong>'.$_SESSION['auth_address'].'</li>
        <li><strong>Phone:</strong>'.$_SESSION['auth_phone'].'</li>
        <li><strong>Note: </strong>'.$_SESSION['order_note'].'</li>
        </ul>
        '; } else
        {
            echo '
    <ul id="list-info" >
        <li><strong>Delivery way:</strong>'.$_SESSION['order_delivery'].'</li>
        <li><strong>E-mail:</strong>'.$_SESSION['order_mail'].'</li>
        <li><strong>Full name:</strong>'.$_SESSION['order_fio'].'</li>
        <li><strong>Address of delivery:</strong>'.$_SESSION['order_address'].'</li>
        <li><strong>Phone:</strong>'.$_SESSION['order_phone'].'</li>
        <li><strong>Note: </strong>'.$_SESSION['order_note'].'</li>
    </ul>
    '; }

    echo '
    <h2 class="itog-price" align="right">In total: <strong>'.$itogpricecart.'</strong> $ </h2>
  <p align="right" class="button-next" ><a href="" >Pay</a></p> 
 
 ';


                break;

            default:

                echo '
                <div id="block-step">       
                <div id="name-step">
                <ul>
                <li><a class="active">1. The cart</a></li>
                <li><span>	&rarr;</span></li>
                <li><a>2. Contact informationt</a></li>
                <li><span>	&rarr;</span></li>
                <li><a>3. Last step</a></li>                       
                </ul>
                 </div>
                <p>Step 1 of 3</p>
                <a href="cart.php?action=clear">Clear</a>             
                </div>
                ';


                //айпи сервера узнаем по глобальной команде REMOTE_ADDR. Её можно узнавать только вызыввая в фигурных скобках. Здесь выбираем товары, который выбрал пользователь с данным айпи
                $result = mysqli_query($link, "SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
                If (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_array($result);

                    echo '
                <div id="header-list-cart">    
                <div id="head1">Image</div>
                <div id="head2">Name of product</div>
                <div id="head3">Quantity</div>
                <div id="head4">Price</div>
                </div>
                ';
                    $all_price = 0;
                    do {
                        $int = $row["cart_price"] * $row["cart_count"]; //определение общей цены
                        $all_price = $all_price + $int; //прибавляем цену товара к общей цене

                        if (strlen($row["image"]) > 0 && file_exists("./uploads_images/" . $row["image"])) {
                            $img_path = './uploads_images/' . $row["image"];
                            $max_width = 100;
                            $max_height = 100;
                            list($width, $height) = getimagesize($img_path);
                            $ratioh = $max_height / $height;
                            $ratiow = $max_width / $width;
                            $ratio = min($ratioh, $ratiow);
                            $width = intval($ratio * $width);
                            $height = intval($ratio * $height);
                        } else {
                            $img_path = "images/noimages.jpeg";
                            $width = 120;
                            $height = 105;
                        }


                        echo '
            
                <div class="block-list-cart">
    <div class="img-cart">
        <p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></p>
    </div>
    
    <div class="title-cart">
        <p><a href="">'.$row["title"].'</a></p>
        <p class="cart-mini-features">
        '.$row["mini_features"].'
        </p>
    </div>
    
    <div class="count-cart">
        <ul class="input-count-style">
        <li>
        <p align="center" id="" class="count-minus">-</p>
        </li>
        <li>
        <p align="center"><input id="" id="" class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'" /></p>
        </li>
        <li>
        <p align="center" iid="" class="count-plus">+</p>
        </li>
        </ul>
    </div>
    
    <div id="tovar" class="price-product"><h5><span class="span-count" >'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p>'.$int.'</p></div>
        <div class="delete-cart"><a  href="cart.php?id='.$row["cart_id"].'&action=delete" ><img src="images/bsk_item_del.png" /></a></div>
        <div id="bottom-cart-line"></div>
    </div>
                ';

                    }
                    while ($row = mysqli_fetch_array($result));

                    echo '
 <h2 class="itog-price" align="right">In total: <strong>'.($all_price).'</strong> $</h2>
 <p align="right" class="button-next" ><a href="cart.php?action=confirm" >Next</a></p> 
 ';

                }
                else
                {
                    echo '<h3 id="clear-cart" align="center">Cart is emty</h3>';
                }
                break;
        }


        ?>






    </div>

    <?php
    include("include/block-footer.php");
    ?>

</div>

</body>
</html>