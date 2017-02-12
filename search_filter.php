<?php

include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");

if (!empty($_GET['q'])) {$search = clear_string($link, $_GET['q']);} else $search = "";
//$cat = clear_string($link,$_GET["cat"]); //вставляем очищенные(защищенные от вирусов) теги и ссылки
//$type = clear_string($link,$_GET["type"]);

?>

<!DOCTYPE HTML>
<html>
<head>
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

    <title>Search by parameters</title>
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

        if (!empty($_GET['brand'])) { //если в строке есть хоть 1 бренд
            $check_brand = implode(',',$_GET['brand']);
        }

        $start_price = (int)$_GET['start_price']; //вбиваем цену в глобальный массив
        $end_price = (int)$_GET['end_price'];


        if (!empty($check_brand) OR !empty($end_price)) {
            if (!empty($check_brand)) { $query_brand = " AND brand_id IN($check_brand)"; } else $query_brand = " ";
            if (!empty($end_price)) $query_price = " AND price BETWEEN $start_price AND $end_price";
        }

        $result = mysqli_query($link, "SELECT * FROM  `table_products` WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC");
        if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        echo '

                <div id="block-sorting">
            <p id="nav-breadcrums"><a href="index.php">Main page</a> \ <span>All products</span></p>
            <ul id="options-list">
                <li>View: </li>
                <li><img id="style-grid" src="/images/icon-grid.png"></li>
                <li><img id="style-list" src="/images/icon-list.png"></li>                   
            </ul>
        </div>

         <ul id="block-product-grid">

                ';
        do {

            if ($row["image"] != "" && file_exists("./uploads_images/" . $row["image"])) { //формируем картинку определенного размера под вид 1

                $img_path = './uploads_images/' . $row["image"];
                $max_width = 200;
                $max_height = 200;
                list($width, $height) = getimagesize($img_path);
                $ratioh = $max_height / $height;
                $ratiow = $max_width / $width;
                $ratio = min($ratioh, $ratiow);
                $width = intval($ratio * $width);
                $height = intval($ratio * $height);
            } else {
                $img_path = "/images/no-image.png";
                $width = 110;
                $height = 200;
            }
            //выводим картинку определенного размера
            echo('

                        <li>
                        <div class="block-images-grid">
                        <img src="' . $img_path . '" width="' . $width . '" height="' . $height . '">
                        </div>

                        <p class="style-title-grid"><a href=" ">' . $row["title"] . '</a></p>

                        <ul class="reviews-and-counts-grid">
                        <li><img src="/images/eye-icon.png"><p>0</p></li>
                        <li><img src="/images/comment-icon.png"><p>0</p></li>
                        </ul>
                        <a class="add-cart-style-grid" href=" "></a>
                        <p class="style-price-grid"><strong>' . $row["price"] . '</strong> $</p>

                        <div class="mini-features">
                        ' . $row["mini_features"] . '
                        </div>
                        </li>

                        ');
        } while ($row = mysqli_fetch_array($result));

        ?>﻿
        </ul>

        <ul id="block-product-list">
            <?php
            $result = mysqli_query($link, "SELECT * FROM  `table_products` WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {

                    if ($row["image"] != "" && file_exists("./uploads_images/" . $row["image"])) { //формируем картинку определенного размера под вид 1

                        $img_path = './uploads_images/' . $row["image"];
                        $max_width = 150;
                        $max_height = 150;
                        list($width, $height) = getimagesize($img_path);
                        $ratioh = $max_height / $height;
                        $ratiow = $max_width / $width;
                        $ratio = min($ratioh, $ratiow);
                        $width = intval($ratio * $width);
                        $height = intval($ratio * $height);
                    } else {
                        $img_path = "/images/no-image.png";
                        $width = 80;
                        $height = 70;
                    }

                    echo('

                        <li>
                        <div class="block-images-list">
                        <img src="' . $img_path . '" width="' . $width . '" height="' . $height . '">
                        </div>

                        <ul class="reviews-and-counts-list">
                        <li><img src="/images/eye-icon.png"><p>0</p></li>
                        <li><img src="/images/comment-icon.png"><p>0</p></li>
                        </ul>

                        <p class="style-title-list"><a href=" ">' . $row["title"] . '</a></p>

                        <a class="add-cart-style-list" href=" "></a>
                        <p class="style-price-list"><strong>' . $row["price"] . '</strong> $</p>

                        <div class="style-text-list">
                        ' . $row["mini_description"] . '
                        </div>
                        </li>

                        ');
                } while ($row = mysqli_fetch_array($result));
            }
            } else {
                $total = " ";
                echo '<h3>This category doesnt exist</h3>';
            }

            ?>

        </ul>
    </div>

    <?php
    include("include/block-footer.php");
    ?>

</div>

</body>
</html>