<script type="text/javascript">
    $(document).ready(function() {
        $('#blocktrackbar').trackbar({
            onMove : function() { //onMove - передвижение ползунка
                document.getElementById("start-price").value = this.leftValue; //старт прайс и энд прайс - это айди параметров. Для этих блоков айди присваиваем правое и левое значение ползунка
                document.getElementById("end-price").value = this.rightValue;
            },
            width : 160,
            leftLimit : 1000,
            leftValue : 1000,
            rightLimit : 50000,
            rightValue : 30000,
            roundUp : 1000 //на сколько идет изменеие при перемешении ползунка
        });
    });
</script>

<div id="block-parameter">

    <p class="header-title">Search by parameters</p>
    <p class="title-filter">Cost</p>

    <form method="GET" action="search_filter.php">


        <div id="block-input-price">
            <ul>
                <li><p>From</p></li>
                <li><input type="text" id="start-price" name="start_price" value="1000"></li>
                <li><p>To</p></li>
                <li><input type="text" id="end-price" name="end_price" value="50000"></li>
                <li><p>$$$</p></li>
            </ul>
        </div>


        <div id="blocktrackbar"></div>


        <p class="title-filter">Producers</p>
        <ul class="checkbox-brand">

            <?php


            $result = mysqli_query($link, "SELECT * FROM category WHERE type='player'");

            If (mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                do {

                    echo '
                    <li><input type="checkbox" name="brand[]" value="'.$row['id'].'" id="checkbrand'.$row['id'].'"><label for="checkbrand'.$row['id'].'">'.$row['brand'].'</label></li>
                    ';

                }
                    while ($row = mysqli_fetch_array($result)) ;
                }

            ?>




        </ul>


        <center><input type="submit" name="submit" id="button-parameter-search" value="Search"></center>

    </form>




</div>