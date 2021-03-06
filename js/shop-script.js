$(document).ready(function () {

    $("#news-sticker").jCarouselLite({
        vertical: true,
        hoverPause: true,
        btnPrev: "#news-back",
        btnNext: "#news-forward",
        visible: 2,
        auto: 3000,
        speed: 500
    });

    loadcart(); //чтобы показывалось количество товаров в корзине

    $("#style-grid").click(function () {

        $("#block-product-list").hide();
        $("#block-product-grid").show();

        $("#style-grid").attr("src", "../images/icon-grid-click.png");
        $("#style-list").attr("src", "../images/icon-list.png");

        $.cookie('select_style', 'grid');

    });

    $("#style-list").click(function () {

        $("#block-product-grid").hide();
        $("#block-product-list").show();

        $("#style-list").attr("src", "../images/icon-list-click.png")
        $("#style-grid").attr("src", "../images/icon-grid.png");

        $.cookie('select_style', 'list');

    });

    if ($.cookie('select_style') == 'grid') {
        $("#block-product-list").hide();
        $("#block-product-grid").show();

        $("#style-grid").attr("src", "../images/icon-grid-click.png");
        $("#style-list").attr("src", "../images/icon-list.png");
    } else {
        $("#block-product-grid").hide();
        $("#block-product-list").show();

        $("#style-list").attr("src", "../images/icon-list-click.png")
        $("#style-grid").attr("src", "../images/icon-grid.png");
    }


    $("#select-sort").click(function () {

        $("#sorting-list").slideToggle(200);

    });


    $('#block-category > ul > li > a').click(function () {

        if ($(this).attr('class') != 'active') {

            $('#block-category > ul > li > ul').slideUp(400);
            $(this).next().slideToggle(400);

            $('#block-category > ul > li > a').removeClass('active');
            $(this).addClass('active');
            $.cookie('select_cat', $(this).attr('id'));

        } else {

            $('#block-category > ul > li > a').removeClass('active');
            $('#block-category > ul > li > ul').slideUp(400);
            $.cookie('select_cat', '');
        }
    });

    if ($.cookie('select_cat') != '') {
        $('#block-category > ul > li > #' + $.cookie('select_cat')).addClass('active').next().show();
    }

    $('#genpass').click(function () {  //ajax для герирования пароля. Вписываем id ссылки и отслеживаем нажатие на эту ссылку(#genpass)
        $.ajax({
            type: "POST", //метод передачи
            url: "/functions/genpass.php", //обработчик генпасс, который мы сделали
            dataType: "html",
            cache: false, //чтобы браузер не кэшировал данные(не сохранял)
            success: function (data) { //data - сгенерированный пароль, который отправил нам обработчик
                $('#reg_pass').val(data); //id инпута, куда нужно поместить пароль
            }
        });

    });

    //код для указания кнопки обновить, чтобы она обновляла
    $('#reloadcaptcha').click(function () {
        $('#block-captcha > img').attr("src", "/reg/reg_captcha.php?r=" + Math.random()); //меняем атрибут img в блоке, и изменям каптчу и этот файл обновляется.(Матрандом нужен для предотвращения кэширования)
    });

    //блок для показывания и скрытия окна регистрации
    $('.top-auth').toggle( //toggle вместо click нужен для того чтобы при повторном нажатии окно исчезало
        function () { //функция появление формы
            $(".top-auth").attr("id", "active-button"); //присваиваем айди
            $("#block-top-auth").fadeIn(200); //если  просто show, то будет не милисекунд
        },
        function () { //функция исчезания формы
            $(".top-auth").attr("id", "");
            $("#block-top-auth").fadeOut(200);
        }
    );

//функция показывания и скрытия пароля
    $('#button-pass-show-hide').click(function () {
        var statuspass = $('#button-pass-show-hide').attr("class"); //будем работать с этой переменной. Определяем ее класс( по умолчанию скрытый )

        if (statuspass == "pass-show") //если глаз открытый
        {
            $('#button-pass-show-hide').attr("class", "pass-hide");

            var $input = $("#auth_pass"); //нижеперечисленная функция скрывает пароль, далеее наоборот
            var change = "text"; //текст - это когда текст показывает
            var rep = $("<input placeholder='Password' type='" + change + "' />")
                .attr("id", $input.attr("id"))
                .attr("name", $input.attr("name"))
                .attr('class', $input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;

        } else {
            $('#button-pass-show-hide').attr("class", "pass-show");

            var $input = $("#auth_pass");
            var change = "password";
            var rep = $("<input placeholder='Password' type='" + change + "' />")
                .attr("id", $input.attr("id"))
                .attr("name", $input.attr("name"))
                .attr('class', $input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;

        }

    });


    $("#button-auth").click(function() { //функция что была нажата кнопка входа

        var auth_login = $("#auth_login").val(); //помещаем в данные переменные значения пароля и логинеа. val() говорит о то что нужно вытащить значение переменной
        var auth_pass = $("#auth_pass").val();


        if (auth_login == "" || auth_login.length > 30 ) //проверка на пустое поле или слишком большое
        {
            $("#auth_login").css("borderColor","#FDB6B6");//перекрашивание в красный цвет по айд в css
            send_login = 'no';
        }else {

            $("#auth_login").css("borderColor","#DBDBDB");
            send_login = 'yes';
        }


        if (auth_pass == "" || auth_pass.length > 15 ) //такая же проверка поля с паролем
        {
            $("#auth_pass").css("borderColor","#FDB6B6");
            send_pass = 'no';
        }else {
            $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes';
        }



        if ($("#rememberme").prop('checked')) //проверка чекбокса
        {
            auth_rememberme = 'yes';

        }else { auth_rememberme = 'no'; }


        if ( send_login == 'yes' && send_pass == 'yes' ) //если все поля введены
        {
            $("#button-auth").hide(); //убираем картинку
            $(".auth-loading").show(); //вставляем анимацию загрузки

            $.ajax({ //обработчик информации
                type: "POST",
                url: "../include/auth.php", //какому обработчику отправляем данные
                data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme, //какие данные мы будем ему отправлять
                dataType: "html",
                cache: false,
                success: function(data) {

                    if (data == 'yes_auth')
                    {
                        location.reload(); //обновление страницы если yes auth из auth.php в инклуде
                    }else
                    {
                        $("#message-auth").slideDown(400);
                        $(".auth-loading").hide();
                        $("#button-auth").show();

                    }

                }
            });
        }
    });

    $('#remindpass').click(function(){

        $('#input-email-pass').fadeOut(200, function() { //убираем блок с формой авторизации
            $('#block-remind').fadeIn(300); //вставляем блок восстановления пароля
        });
    });

    $('#prev-auth').click(function(){  //ссылка назад, чтобы показывалась опять форма авторизациит

        $('#block-remind').fadeOut(200, function() {
            $('#input-email-pass').fadeIn(300);
        });
    });

    $('#button-remind').click(function(){

        var recall_email = $("#remind-email").val();

        if (recall_email == "" || recall_email.length > 20 )
        {
            $("#remind-email").css("borderColor","#FDB6B6");

        }else
        {
            $("#remind-email").css("borderColor","#DBDBDB");

            $("#button-remind").hide();
            $(".auth-loading").show();

            $.ajax({
                type: "POST",
                url: "../include/remind-pass.php", //адрес обработчика
                data: "email="+recall_email,
                dataType: "html",
                cache: false,
                success: function(data) {

                    if (data == 'yes')
                    {
                        $(".auth-loading").hide();
                        $("#button-remind").show();
                        $('#message-remind').attr("class","message-remind-success").html("Login and password has been sent to your E-mail").slideDown(400);

                        setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 3000); //через 3 секунды опять форма регистрации появится. Очищаем параграф от сообщения(что отправлен пароль на поту напоминание)

                    }else
                    {
                        $(".auth-loading").hide();//скрывается загрузчик, скрывается кнопка
                        $(".auth-loading").hide();
                        $("#button-remind").show();
                        $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400); //сообщение об ошибке. Тут  html - это то что отправит обработчик

                    }
                }
            });
        }
    });

    $('#auth-user-info').toggle(
        function() {
            $("#block-user").fadeIn(100);
        },
        function() {
            $("#block-user").fadeOut(100);
        }
    );

    $('#logout').click(function(){

        $.ajax({
            type: "POST",
            url: "../include/logout.php",
            dataType: "html",
            cache: false,
            success: function(data) {

                if (data == 'logout')
                {
                    location.reload();
                }

            }
        });
    });

    $('#input-search').bind('textchange', function () { //Отслеживаем плагин TextChange. Код будет исполняться при измнении этого поля

        var input_search = $("#input-search").val(); //вытягиваем значение из этого поля

        if (input_search.length >= 3 && input_search.length < 150 )
        {
            $.ajax({
                type: "POST",
                url: "../include/search.php", //обратить внимание что это не корневой обработчик
                data: "text="+input_search, //то что отпррвляем обработчику
                dataType: "html",
                cache: false,
                success: function(data) { //смотрим что ответил обработчик

                    if (data > '')
                    {
                        $("#result-search").show().html(data);
                    }else{

                        $("#result-search").hide(); //если не соответствует условиям, то скрываем выпадающий список
                    }

                }
            });

        }else
        {
            $("#result-search").hide();
        }

    });


//шаблон проверки почты на правильность
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
    // Контактные данные
    $('#confirm-button-next').click(function(e){

        var order_fio = $("#order_fio").val(); //указываем id поля и при помощи .val() принимаем значения
        var order_email = $("#order_email").val();
        var order_phone = $("#order_phone").val();
        var order_address = $("#order_address").val();

        if (!$(".order_delivery").is(":checked"))
        {
            $(".label_delivery").css("color","#E07B7B");
            send_order_delivery = '0';

        }else { $(".label_delivery").css("color","black"); send_order_delivery = '1'; //проверка выбран ли способ доставки


            // Проверка ФИО
            if (order_fio == "" || order_fio.length > 50 )
            {
                $("#order_fio").css("borderColor","#FDB6B6");
                send_order_fio = '0';

            }else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}


            //Проверка email
            if (isValidEmailAddress(order_email) == false)
            {
                $("#order_email").css("borderColor","#FDB6B6");
                send_order_email = '0';
            }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}

            // Проверка телефона

            if (order_phone == "" || order_phone.length > 50)
            {
                $("#order_phone").css("borderColor","#FDB6B6");
                send_order_phone = '0';
            }else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}

            // проверка адреса

            if (order_address == "" || order_address.length > 150)
            {
                $("#order_address").css("borderColor","#FDB6B6");
                send_order_address = '0';
            }else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}

        }
        // глобальная проверка
        if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
        {
            // Отправляем форму
            return true;
        }

        e.preventDefault(); //при помощи этого метода форма не отправляется

    });



    $('.add-cart-style-list,.add-cart-style-grid,.add-cart,.random-add-cart').click(function(){ //для добавления товара в корзну, при клике запускается функция

        var  tid = $(this).attr("tid");

        $.ajax({
            type: "POST",
            url: "../include/addtocart.php",
            data: "id="+tid,
            dataType: "html",
            cache: false,
            success: function(data) {
                loadcart(); //обращение фукнции обновления строчки
            }
        });

    });
//функция для обновления строчки при добавлении товара
    function loadcart(){
        $.ajax({
            type: "POST",
            url: "../include/loadcart.php",
            dataType: "html",
            cache: false,
            success: function(data) {

                if (data == "0")
                {

                    $("#block-basket > a").html("Cart is empty");

                }else
                {
                    $("#block-basket > a").html(data);
                }

            }
        });

    }

    function fun_group_price(intprice) {
        //группировка цен в корзине. При помощи php такого сделать не получиться, нужен JS
        var result_total = String(intprice);
        var lenstr = result_total.length;

        switch(lenstr) {
            case 4: {
                groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
                break;
            }
            case 5: {
                groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
                break;
            }
            case 6: {
                groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6);
                break;
            }
            case 7: {
                groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7);
                break;
            }
            default: {
                groupprice = result_total;
            }
        }
        return groupprice;
    }

});