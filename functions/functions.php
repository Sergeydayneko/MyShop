<?php

function clear_string($link, $cl_str)
{

//оистка, чтобы не было вредоносных программ по урл
    $cl_str = strip_tags($cl_str);  //удаление html and php тегов
    $cl_str = mysqli_real_escape_string($link, $cl_str); //очистка спецсимволов, экранирует спецсимволы
    $cl_str = trim($cl_str); //удаление пробелов

    return $cl_str;
}

function fungenpass() {
$number = 7; //задаем длину пароля
$arr = array('a','b','c','d','e','f',  //омещаем в массмив какие буквы и какие цифры должны быть в нашем пароле
    'g','h','i','j','k','l',
    'm','n','o','p','r','s',
    't','u','v','x','y','z',
    '1','2','3','4','5','6',
    '7','8','9','0');


// генерирование пароля
$pass = "";
for($i = 0; $i < $number; $i++)
{
    // Вычисляем случайный индекс массива
    $index = rand(0, count($arr) - 1);
    $pass .= $arr[$index];
}

return $pass;
}


function send_mail($from,$to,$subject,$body) //то есть мы должны передать 4 параметра
{
    $charset = 'utf-8'; //кодировка
//    mb_language("ru"); //выбираем язык. Выдает ошибку
    $headers  = "MIME-Version: 1.0 \n" ;
    $headers .= "From: <".$from."> \n";
    $headers .= "Reply-To: <".$from."> \n";
    $headers .= "Content-Type: text/html; charset=$charset \n";

    $subject = '=?'.$charset.'?B?'.base64_encode($subject).'?='; //кодируем, чтобы почтовый сервер мог разобрать кодировкув
//    mail($to,$subject,$body,$headers); //выдает ошибку
}


//функция группировки цен
function group_numerals($int){

    switch (strlen($int)) { //пределяем длину цены и вырезаем часть, вставляем пробел и обратно вставляем нужную часть
        case '4':

            $price = substr($int,0,1).' '.substr($int,1,4);
            break;

        case '5':

            $price = substr($int,0,2).' '.substr($int,2,5);
            break;

        case '6':

            $price = substr($int,0,3).' '.substr($int,3,6);
            break;

        case '7':

            $price = substr($int,0,1).' '.substr($int,1,3).' '.substr($int,4,7); //для миллина
            break;

        default: //если нет совпадений(например цена миллиао миллиардов)

            $price = $int;

            break;
    }
    return $price;
}





?>