<?php
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
echo $pass; //вывод на экран
?>