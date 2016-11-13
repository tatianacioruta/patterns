<section id="content_area" xmlns:fb="http://www.w3.org/1999/html">
    <div class="clearfix wrapper main_content_area">
        <div class="clearfix main_content floatleft">

            <div class="clearfix slider">
                <ul class="pgwSlider">
                    <li><img src="<?= _URL_PATH ?>images/thumbs/megamind_07.jpg" alt="Paris, France"
                             data-description="Eiffel Tower and Champ de Mars"
                             data-large-src="<?= _URL_PATH ?>images/slides/megamind_07.jpg"/></li>
                    <li><img src="<?= _URL_PATH ?>images/thumbs/wall-e.jpg" alt="Montr?al, QC, Canada"
                             data-large-src="<?= _URL_PATH ?>images/slides/wall-e.jpg"
                             data-description="Eiffel Tower and Champ de Mars"/></li>
                    <li>
                        <img src="<?= _URL_PATH ?>images/thumbs/up-official-trailer-fake.jpg" alt="Shanghai, China"
                             data-large-src="<?= _URL_PATH ?>images/slides/up-official-trailer-fake.jpg"
                             data-description="Shanghai ,chaina">
                    </li>


                </ul>
            </div>

            <div class="clearfix content">
                <div class="content_title"><h2><?= (isset($title))?$title:"Posts";?></h2></div>
                <?
                foreach ($latest as $row) { ?>
                    <div class="clearfix single_content">
                        <div class="clearfix post_date floatleft">
                            <div class="date">
                                <h3><?= Helper::get_date($row['date_add'], "d") ?></h3>

                                <p><?= Helper::get_date($row['date_add'], "M") ?></p>
                            </div>
                        </div>
                        <div class="clearfix post_detail">
                            <h2><a href=""><?= $row['title_post'] ?> </a></h2>

                            <div class="clearfix post-meta">
                                <p><span><i class="fa fa-user"></i> <?= $row['name'] ?></span> <span><i
                                            class="fa fa-clock-o"></i> <?= Helper::get_date($row['date_add'], "M d, Y g:i A") ?></span> <span><i
                                            class="fa fa-comment"></i> <?= $row['nr_comments'] ?> comments</span> <span><i
                                            class="fa fa-folder"></i> <?= $row['title'] ?></span></p>
                            </div>
                            <div class="clearfix post_excerpt">
                                <img src="<?=_URL_PATH?>images/thumb.png" alt=""/>

                                <p><?= $row['content'] ?> </p>
                            </div>
                            <div
                                class="fb-like"
                                data-share="true"
                                data-width="450"
                                data-show-faces="true">
                            </div>
                            <a href="<?= _URL_PATH . 'posts/show/' . $row['id_post'] ?>">View Post</a>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
        <div class="clearfix sidebar_container floatright">

            <?
            if (empty($_SESSION["user_connected"])) {
                ?>
                <div class="clearfix newsletter">
                    <form method="post" action="<?= _URL_PATH . 'authorization/log_in' ?>">
                        <h2>Log in for writing posts</h2>
                        <input type="text" name="login" placeholder="Name" id="mce-TEXT"/>
                        <input type="password" name="password" placeholder="Password" id="mce-EMAIL"/>
                        <input type="submit" value="Log in" id="mc-embedded-subscribe"/>
                        <fb:login-button scope="public_profile,email" onlogin="testAPI();" style="width:120px">
                        </fb:login-button>
                    </form>
                </div>
            <? } else {
                ?>
                <div class="clearfix newsletter">
                    <form method="post"id="post_form" action="<?= _URL_PATH . 'posts/ajax_save' ?>">
                        <h2>Add new post</h2>
                        <label for="category" class="col-sm-12 text-left">Title</label>
                        <input type="text" class="validate[required]" name="title_post" placeholder="Write post title" id="mce-TEXT"/>
                        <label for="category" class="col-sm-12 text-left">Categories</label>
                        <select id="mce-TEXT" name="category" class="col-sm-12 ">
                            <?= (isset($options)) ? $options : '<option></option>' ?>
                        </select>
                        <input type="text" hidden="hidden" name="user"
                               value="<?= $_SESSION['user_data']['id_user'] ?>"/>
                        <input id="published" hidden="hidden" type="checkbox" name="published" checked="checked" value="1"/>
                       <!-- <div class="col-sm-8">
                            <label for="date_added" class="col-sm-12 text-left">Date add:</label>

                            <div class="input-group date">
                                <input type="text" id="date_added" data-prompt-position="bottomLeft:20"
                                       class="form-control validate[required]" name="date_added"
                                       value="<?/*= date('M d, Y g:i:s A')*/?>"><span
                                    class="input-group-addon">
                            <i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>-->
                        <label class="col-sm-12" for="content">Content:</label><br/>
                         <textarea id="mce-TEXT" class="form-control validate[required]" rows="3" cols="16" placeholder="Write your post" name="content" style="margin: 0px; width: 249px; height: 99px;"></textarea>
                        <input class="btn btn-primary btn-warning" type="submit" VALUE="POST"/>

                    </form>
                </div>
            <? } ?>
            <div class="clearfix sidebar">
                <div class="clearfix single_sidebar">
                    <div class="popular_post">
                        <div class="sidebar_title"><h2>Most Popular</h2></div>
                        <ul>
                            <? foreach ($most_popular as $row) { ?>
                                <li><a href="<?= _URL_PATH . 'posts/show/' . $row['id_post'] ?>"><?= $row['title_post'] ?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
                <div class="clearfix single_sidebar category_items">
                    <h2>Categories</h2>
                    <ul>
                        <? foreach ($categories as $row) { ?>
                            <li class="cat-item"><a href="<?= _URL_PATH . 'posts/category/' . $row['id_category'] ?>"><?= $row['title'] ?></a>(<?= $row['nr_posts'] ?>)</li>
                        <? } ?>
                    </ul>
                </div>
                <div class="clearfix single_sidebar">
                    <h2>Calendar</h2>
                    <ul>
                        <li style="width: 270px; height: 400px;">
                            <div id="datepicker" data-date="<?= date('m/d/Y') ?>"></div>
                            <div id="my_hidden_input">
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('body').on("submit", "#post_form", function (e) {
        e.preventDefault();
        if ($("#post_form").validationEngine('validate')) {
            var $form = $('#post_form');
            var data = $form.serialize();
            var action = $form.attr('action');
            console.log(data);
            $.ajax({
                url: action,
                data: data,
                method: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    showLoader($('body'));
                },
                complete: function () {
                    hideLoader($('body'));
                },
                success: function (response) {
                    console.log(response);
                    showAlert(response.message, response.status);
                    if (response.status === 'success') {
                       window.location.reload();
                    }
                },
                error: function (response) {
                    showAlert("Operation failed!", 'fail');
                }
            });

        }
    });
    $('.input-group.date').datepicker({
        format: "M dd, yyyy",
        orientation: "auto left",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true
    });

    $(":checkbox").change(function (e) {
        $(this).val($(":checked").length > 0 ? 1 : 0);
    });

</script>
<script>
    $('#datepicker').datepicker({
        calendarWeeks: true
    });


    function dateCheck(from, to, check) {

        var fDate, lDate, cDate;
        fDate = Date.parse(from);
        lDate = Date.parse(to);
        cDate = Date.parse(check);

        if ((cDate <= lDate && cDate >= fDate)) {
            return true;
        }
        return false;
    }


    $('#datepicker').on("changeDate", function () {
        var date = $('#datepicker').datepicker('getFormattedDate').split('/');
        var date_check = $('#datepicker').datepicker('getFormattedDate');
        var year = $('#datepicker').datepicker('getFormattedDate').split('/');
        year = year[2];
        var zodiac_arr = {
            Aries: '03/21/' + year + '-04/19/' + year,
            Taurus: '04/20/' + year + '-05/20/' + year,
            Gemini: '05/21/' + year + '-06/20/' + year,
            Cancer: '06/21/' + year + '-07/22/' + year,
            Leo: '07/23/' + year + '-08/22/' + year,
            Virgo: '08/23/' + year + '-09/22/' + year,
            Libra: '09/23/' + year + '-10/22/' + year,
            Scorpio: '10/23/' + year + '-11/21/' + year,
            Sagettarius: '11/22/' + year + '-12/21/' + year,
            Capricorn: '12/22/' + year + '-01/19/' + year,
            Aquarius: '01/20/' + year + '-02/18/' + year,
            Pisces: '02/19/' + year + '-03/20/' + year
        };
        var key_zodiac = (((eval(date[2]) + 2697) % 60 ) % 12) !== 0 ? ((eval(date[2]) + 2697) % 60 ) % 12 : 12;
        var key_element_color = (((eval(date[2]) + 2697) % 60 ) % 10 ) !== 0 ? ((eval(date[2]) + 2697) % 60 ) % 10 : 10;

        var rez = "";
        switch (key_zodiac) {
            case 1:
                rez = 'Year:Rat <br>';
                break;
            case 2:
                rez = 'Year:Ox <br>';
                break;
            case 3:
                rez = 'Year:Tiger <br>';
                break;
            case 4:
                rez = 'Year:Rabbit <br>';
                break;
            case 5:
                rez = 'Year:Dragon <br>';
                break;
            case 6:
                rez = 'Year:Snake <br>';
                break;
            case 7:
                rez = 'Year:Horse <br>';
                break;
            case 8:
                rez = 'Year:Goat <br>';
                break;
            case 9:
                rez = 'Year:Monkey <br>';
                break;
            case 10:
                rez = 'Year:Rooster <br>';
                break;
            case 11:
                rez = 'Year:Dog <br>';
                break;
            case 12:
                rez = 'Year:Pig <br>';
                break;
        }

        switch (key_element_color) {
            case 1:
                rez += 'Element:wood<br>Color:green';
                break;
            case 2:
                rez += 'Element:wood<br>Color:green';
                break;
            case 3:
                rez += 'Element:fire<br>Color:red';
                break;
            case 4:
                rez += 'Element:fire<br>Color:red';
                break;
            case 5:
                rez += 'Element:earth<br>Color:yellow';
                break;
            case 6:
                rez += 'Element:earth<br>Color:yellow';
                break;
            case 7:
                rez += 'Element:metal<br>Color:white';
                break;
            case 8:
                rez += 'Element:metal<br>Color:white';
                break;
            case 9:
                rez += 'Element:water<br>Color:blue';
                break;
            case 10:
                rez += 'Element:water<br>Color:blue';
                break;
        }
        $.each(zodiac_arr, function (key, value) {
            value = value.split('-');
            console.log(date_check);
            if (dateCheck(value[0].toString(), value[1].toString(), date_check.toString())) {
                rez += '<br>Zodia->>>' + key;
            } else {
                //console.log(key);
            }
        });
        $('#my_hidden_input').html(rez);
    });
</script>
<script>

    window.fbAsyncInit = function () {
        FB.init({
            appId: '109106636173875',
            cookie: true,  // enable cookies to allow the server to access
                           // the session
            xfbml: true,  // parse social plugins on this page
            version: 'v2.5' // use graph api version 2.5
        });
        /*FB.getLoginStatus(function(response) {
         statusChangeCallback(response);
         });*/

    };


    // Load the SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.

    function testAPI() {
        FB.api('/me?fields=id,name,email', function (response) {
            console.log(response);
            var url = '<?= _URL_PATH . 'authorization/log_in';?>';
            $.ajax({
                url: url,
                data: {
                    social: true,
                    provider: 'facebook',
                    name: response.name,
                    email: response.email,
                    social_id: response.id
                },
                method: 'POST',
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 'success')
                        window.location = '<?= _URL_PATH?>';
                },
                error: function (res) {
                    console.log(res);
                    /*window.location = '
                    <?= _URL_PATH.'java'?>';*/
                }
            });
        });

    }
</script>
