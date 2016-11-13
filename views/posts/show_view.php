<section id="content_area">
    <div class="clearfix wrapper main_content_area">
        <? (!empty($data)) ? extract($data) : ""; ?>
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
                <div class="content_title"><h2><?= $post['title_post'] ?></h2></div>
                <div class="clearfix single_content">
                    <div class="clearfix post_date floatleft">
                        <div class="date">
                            <h3><?= Helper::get_date($post['date_add'], "d") ?></h3>

                            <p><?= Helper::get_date($post['date_add'], "M") ?></p>
                        </div>
                    </div>
                    <div class="clearfix post_detail">
                        <div class="clearfix post-meta">
                            <p><span><i class="fa fa-user"></i> <?= $post['name'] ?></span> <span><i
                                        class="fa fa-clock-o"></i> <?= Helper::get_date($post['date_published'], "M d, Y g:i A") ?></span> <span><i
                                        class="fa fa-comment"></i> <?= $post['nr_comments'] ?> comments</span> <span><i
                                        class="fa fa-folder"></i> <?= $post['title'] ?></span></p>
                        </div>
                        <div class="clearfix post_excerpt">
                            <img src="<?= _URL_PATH ?>images/thumb.png" alt=""/>

                            <p><?= $post['content'] ?> </p>
                        </div>

                        <a href="<?= _URL_PATH ?>">Back Posts List</a>
                    </div>
                </div>
                    <div class="clearfix single_content">
                        <?
                        if ($_SESSION['user_connected']) {
                            ?>
                        <h3>Add a comment</h3>

                        <form class="add-comment" id="comment_form" action="<?= _URL_PATH?>comments/ajax_save">

                            <div class="user-xs">
                                <span><?= $_SESSION['user_data']['name'] ?></span>
                            </div>
                            <div class="message-xs clearfix">
                                <div class="img-user-xs">
                                    <img src="<?= _URL_PATH ?>images/no_user.jpg" alt="user_avatar">
                                </div>
                                <textarea maxlength="1000" style="margin: 0px; width: 655px; height: 105px;" class="message validate[required]" name="comment"
                                          placeholder="Write here your comment"></textarea>
                            </div>
                            <input type="text" hidden="hidden" name="id_user"
                                   value="<?= $_SESSION['user_data']['id_user'] ?>"/>
                            <input type="text" hidden="hidden" name="id_post" value="<?=$post['id_post']?>">

                            <div class="clearfix mt-10">
                                <span class="pull-left fs-12 textarea-caracters">1000 characters remaining</span>
                                <button type="submit" class="pull-right btn btn-standart">send</button>
                            </div>
                        </form>
                        <? } ?>
                        <p class="number-comments"><i class="fa fa-comments"></i>Comments (<?= $post['nr_comments']; ?>)
                        </p>
                        <ul class="list-user-comments">
                            <?
                            foreach ($more_comments as $one_comment) {
                                ?>
                                <li class="clearfix" style="border-bottom: 2px dashed black;">
                                    <div class="img-user">
                                        <img src="<?= _URL_PATH ?>images/no_user.jpg" alt="#">
                                    </div>
                                    <div class="comment-block">
                                        <div class="clearfix" style="color: #FFD500;">
                                            <span class="user-name"><?= $one_comment['name'] ?></span>
                                            <span
                                                class="time-add-comment"><?= Helper::get_date($one_comment['date_added'], 'M d, Y g:i:s A'); ?></span>
                                        </div>
                                        <p class="user-comment"><?= $one_comment['comment']; ?></p>
                                    </div>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
            </div>

        </div>
        <div class="clearfix sidebar_container floatright">
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
                        <li style="width: 270px; height: 320px;">
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
    $('body').on("submit", "#comment_form", function (e) {
        e.preventDefault();
        if ($("#comment_form").validationEngine('validate')) {
            var $form = $('#comment_form');
//var $id_user = $('#btn_add').data('id');
            var data = $form.serialize();
//data += '&user=' + $id_user;
            var action = $form.attr('action');
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
                    if (response.status === 'success') {
                        window.location.reload();
                    }
                },
                error: function (response) {
                    showAlert("Operation failed!", 'fail');
                }
            });

        }
    });</script>
<script>
    $('#datepicker').datepicker({
        calendarWeeks: true
    });
    $('#datepicker').on("changeDate", function () {
        var date = $('#datepicker').datepicker('getFormattedDate').split('/');
        var key_zodiac = ((eval(date[2]) + 2697) % 60 ) % 12;
        var key_element_color = (((eval(date[2]) + 2697) % 60 ) % 10 ) !== 0 ? ((eval(date[2]) + 2697) % 60 ) % 10 : 10

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
        $('#my_hidden_input').html(rez);
    });
</script>