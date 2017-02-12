<div id="block-category" xmlns="http://www.w3.org/1999/html">

    <p class="header-title">Product category</p>

    <ul>

        <li><a id="index1"><img src="../images/player.png" id="players" /><span>Players</span></a>
            <ul class="category-section">
                 <li><a href="view_cat.php?cat=&type=player&page="><strong>All models</strong></a></li>

                <?php
                $result =  mysqli_query($link, "SELECT * FROM  category WHERE type='player'");
                if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    echo '           
                    <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'&page=0">'.$row["brand"].'</a></li>
                    ';}
                    while ($row = mysqli_fetch_array($result));
                }
                ?>
            </ul>
        </li>

        <li><a id="index2"><img src="../images/video.png" id="video" />Video</a>
            <ul class="category-section">
                <li><a href="view_cat.php?cat=&type=video&page="><strong>All models</strong></a></li>

                <?php
                $result =  mysqli_query($link, "SELECT * FROM  category WHERE type='video'");
                if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        echo '           
                    <li><a href="view_cat.php?cat='. strtolower($row["brand"]).'&type='.$row["type"].'&page=0">'.$row["brand"] . '</a></li>
                    ';}
                    while ($row = mysqli_fetch_array($result));
                }
                ?>

            </ul>
        </li>

        <li><a id="index"><img src="../images/printer.png" id="printers" />Printers</a>
            <ul class="category-section">
                <li><a href="view_cat.php?cat=&type=printer&page="><strong>All models</strong></a></li>
                <?php
                $result =  mysqli_query($link, "SELECT * FROM  category WHERE type='printer'");
                if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        echo '           
                    <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'&page=0">'.$row["brand"].'</a></li>
                    ';}
                    while ($row = mysqli_fetch_array($result));
                }
                ?>
            </ul>
        </li>

    </ul>
    
    
</div>