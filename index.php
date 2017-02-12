<?php

    include("include/db_connect.php");
    include("functions/functions.php");
    session_start();
    include("include/auth_cookie.php");
    if (!empty($_GET['q'])) {$search = clear_string($link, $_GET['q']);} else $search = "";

//  unset($_SESSION['auth']);
//    setcookie('rememberme', '', 0, '/');  //в auth.php мы устанавливали значения прежде


$sorting = isset($_GET['sort']) ? $_GET['sort'] : null;
    switch ($sorting){

        case 'price-asc';
            $sorting = 'price ASC';
            $sort_name = 'Price up';
            break;

        case 'price-desc';
            $sorting = 'price DESC';
            $sort_name = 'Price down';
            break;

        case 'popular';
            $sorting = 'datetime DESC';
            $sort_name = 'Popular';
            break;

        case 'news';
            $sorting = 'datetime DESC';
            $sort_name = 'New products';
            break;

        case 'brand';
            $sorting = 'brand';
            $sort_name = 'From A to Z';
            break;

        default:
            $sorting = "products_id DESC";
            $sort_name = "No sorting";
            break;
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


<div id="block-content">

    <div id="block-sorting">
        <p id="nav-breadcrums"><a href="">Main page</a> \ <span>All products</span></p>
        <ul id="options-list">
            <li>View: </li>
            <li><img id="style-grid" src="/images/icon-grid.png"></li>
            <li><img id="style-list" src="/images/icon-list.png"></li>
            <li>Sort by:</li>
            <li><a id="select-sort"><?php echo $sort_name; ?></a>
            <ul id="sorting-list">
                <li class="a"><a href="index.php?page=1&sort=price-asc">Price up</a></li>
                <li class="a"><a href="index.php?page=1&sort=price-desc">Price down</a></li>
                <li class="a"><a href="index.php?page=1&sort=popular">Popular</a></li>
                <li class="a"><a href="index.php?page=1&sort=news">New products</a></li>
                <li class="a"><a href="index.php?page=1&sort=brand">From A to Z</a></li>
            </ul>
            </li>
        </ul>
    </div>


    <?php


    ?>

    <ul id="block-product-grid">

    <?php

    $num = 4; //сколько я хочу выводить товаров на сайт( на 1 странице )
    if (!empty($_GET['page'])) { $page = (int)$_GET['page']; } else $page=""; //помещение в переменную значение страницы

    $count = mysqli_query($link, "SELECT COUNT(*) FROM table_products WHERE visible = '1'"); //каунт подсчитывает все товары
    $temp = mysqli_fetch_array($count); //формирует количество товаров

    If ($temp[0] > 0)
    {
        $tempcount = $temp[0]; //помещаем количество товаров
        $total = (($tempcount - 1) / $num) + 1; //количество товаров делитсян а сколько надо выводить на 1 странице и поулчается общеее количетсво страниц
        $total =  intval($total); //округление расчтета странице и помещение в урл
        $page = intval($page); //округление количетсва страниц
        if(empty($page) or $page < 0) $page = 1; //проверка переменной пейдж, если равна нулю, то она равна 1. Фигурных скобок нет, так как нет else, и мы экономим код

        if($page > $total) $page = $total; //проверка если значени пейдж, больше корличества страниц(урл и факт), то мы их приравниваем.

        $start = $page * $num - $num; //с какого порядкового номера товара нужно выводить товар
        $qury_start_num = " LIMIT $start, $num"; //запрос, сколько выводить товаров, их лимит и от какого стартовать
    }
                $result =  mysqli_query($link, "SELECT * FROM  `table_products` WHERE visible='1' ORDER BY $sorting $qury_start_num");
                if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    do {

                        if ($row["image"] != "" && file_exists("./uploads_images/".$row["image"])) {

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

                        echo('
                        
                        <li>
                        <div class="block-images-grid">
                        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'">
                        </div>
                        
                        <p class="style-title-grid"><a href=" ">'.$row["title"].'</a></p>
                        
                        <ul class="reviews-and-counts-grid">
                        <li><img src="/images/eye-icon.png"><p>0</p></li>
                        <li><img src="/images/comment-icon.png"><p>0</p></li>
                        </ul>
                        <a class="add-cart-style-grid" tid="'.$row["products_id"].'"></a>
                        <p class="style-price-grid"><strong>'.group_numerals($row["price"]).'</strong> $</p>
                        
                        <div class="mini-features">
                        '.$row["mini_features"].'                        
                        </div>                     
                        </li>
                        
                        ');
                    }
                    while ($row = mysqli_fetch_array($result));
                }
            ?>﻿
    </ul>

    <ul id="block-product-list">
        <?php
        $result =  mysqli_query($link, "SELECT * FROM  table_products WHERE visible='1' ORDER BY $sorting $qury_start_num");
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            do {

                if ($row["image"] != "" && file_exists("./uploads_images/".$row["image"])) {

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
                        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'">
                        </div>
                        
                        <ul class="reviews-and-counts-list">
                        <li><img src="/images/eye-icon.png"><p>0</p></li>
                        <li><img src="/images/comment-icon.png"><p>0</p></li>
                        </ul>
                        
                        <p class="style-title-list"><a href=" ">'.$row["title"].'</a></p>
                        
                        <a class="add-cart-style-list" tid="'.$row["products_id"].'"></a>
                        <p class="style-price-list"><strong>'.group_numerals($row["price"]).'</strong> $</p>
                        
                        <div class="style-text-list">
                        '.$row["mini_description"].'                        
                        </div>                     
                        </li>
                        
                        ');
            }
            while ($row = mysqli_fetch_array($result));
        }
        echo  '</ul>';
        //определение стрелок назад и вперед( на 1 и на последний по 1 их нет, так как здесь же осуществляется проверка на первую и последнюю страницы)
        //всё это тег ли по флоат лефт
        if ($page != 1) { $pstr_prev = '<li><a class="pstr-prev" href="index.php?page='.($page - 1).'">&lt;</a></li>'; } else $pstr_prev = " ";
        if ($page != $total) { $pstr_next = '<li><a class="pstr-next" href="index.php?page='.($page + 1).'">&gt;</a></li>'; } else  $pstr_next = " ";
        //формируем ссылки по страницам

        //за левый вывод ссылок
        if($page - 5 > 0) { $page5left = '<li><a href="index.php?page='.($page - 5).'">'.($page - 5).'</a></li>'; } else $page5left = " ";
        if($page - 4 > 0) { $page4left = '<li><a href="index.php?page='.($page - 4).'">'.($page - 4).'</a></li>'; } else $page4left = " ";
        if($page - 3 > 0) { $page3left = '<li><a href="index.php?page='.($page - 3).'">'.($page - 3).'</a></li>'; } else $page3left = " ";
        if($page - 2 > 0) { $page2left = '<li><a href="index.php?page='.($page - 2).'">'.($page - 2).'</a></li>'; } else $page2left = " ";
        if($page - 1 > 0) { $page1left = '<li><a href="index.php?page='.($page - 1).'">'.($page - 1).'</a></li>'; } else $page1left = " ";

        //за правый вывод ссылок
        if($page + 5 <= $total) { $page5right = '<li><a href="index.php?page='.($page + 5).'">'.($page + 5).'</a></li>'; } else $page5right = " ";
        if($page + 4 <= $total) { $page4right = '<li><a href="index.php?page='.($page + 4).'">'.($page + 4).'</a></li>'; } else $page4right = " ";
        if($page + 3 <= $total) { $page3right = '<li><a href="index.php?page='.($page + 3).'">'.($page + 3).'</a></li>'; } else $page3right = " ";
        if($page + 2 <= $total) { $page2right = '<li><a href="index.php?page='.($page + 2).'">'.($page + 2).'</a></li>'; } else $page2right = " ";
        if($page + 1 <= $total) { $page1right = '<li><a href="index.php?page='.($page + 1).'">'.($page + 1).'</a></li>'; } else $page1right = " ";


        // проверка и выовод многоточия и чтобы когда подходили к общему количеству многоточие исчезало
        if ($page + 5 < $total)
        {
            $strtotal = '<li><p class="nav-point">...</p></li><li><a href="index.php?page='.$total.'">'.$total.'</a></li>';
        }else
        {
            $strtotal = "";
        }
        if ($total > 1) { //если страниц больше 1, то выводим постраничную навигацию

            echo '
    <div class="pstrnav">
    <ul>
    ';
            echo  $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='index.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
            echo '
    </ul>
    </div>
    ';
        }

        ?>﻿

</div>

<?php	
    include("include/block-footer.php");   
?>

</div>

</body>
</html>