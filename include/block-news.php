<div id="block-news">
    <img class="arrow" id="news-back" src="../images/pointer-up.png">
    <div id="news-sticker">
        <ul>

<?php
$result =  mysqli_query($link, "SELECT * FROM  news ORDER BY id DESC");
if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    //вывод даты
    //вывод информации
    do {

        echo '
            <li>
            <span>'.$row["date"].'</span>  
            <a href=" ">'.$row["title"].'</a> 
            <p>'.$row["text"].'</p>
            </li>
            
            ';

    } while ($row = mysqli_fetch_array($result));
}
?>

        </ul>

    </div>
    <img class="arrow" id="news-forward" src="../images/pointer-down.png">


</div>