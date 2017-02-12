<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //define('myeshop', true);
    include("db_connect.php");
    include("../functions/functions.php");

    $id = clear_string($link, $_POST["id"]); //принимаем id для дальнейшей обработки в ajax

    //ниже проверяем добавлены ли товары в корзину. Если да, то увеличиваем количество, если нет, то добавляем.
    $result = mysqli_query($link, "SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_products = '$id'");
    If (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        $new_count = $row["cart_count"] + 1; //1 нажатие +1 товар
        $update = mysqli_query ($link, "UPDATE cart SET cart_count='$new_count' WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_products ='$id'");
    }
    else //тут доабвляем, если товаров до этого не было добавлено
    {
        $result = mysqli_query($link, "SELECT * FROM table_products WHERE products_id = '$id'");
        $row = mysqli_fetch_array($result);

        mysqli_query($link, "INSERT INTO cart(cart_id_products,cart_price,cart_datetime,cart_ip)
						VALUES( 	
                            '".$row['products_id']."',
                            '".$row['price']."',					
							NOW(),
                            '".$_SERVER['REMOTE_ADDR']."'                                                                        
						    )");
    }
}
?>