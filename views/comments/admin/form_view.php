<? (!empty($data)) ? extract($data):""; ?>
<div class="fancybox-title-custom">
    <p><?= $modal_title ?></p>
</div>
<div class="fancybox-wrapper w400">
    <form id="comment_form" class="validation_form" method="post" role="form" name="blog_form"
          action="<?= _URL_PATH . 'comments/' . $form_action ?>">
        <div class="form-group">
            <div class="col-sm-12 padding_none">
                <label for="post" class="col-sm-12 text-left">Post:<?= (isset($one)) ? $one['title_post'] : '' ?></label><br/>
            </div>
            <div class="col-sm-12 padding_none">
                <label for="user" class="col-sm-12 text-left">User:<?= (isset($one)) ? $one['name'] : '' ?></label><br/>
            </div>
            <div class="col-sm-12 padding_none">
                <label for="comment" class="col-sm-12 text-left">Comment:</label><br/>
                <input id="comment" data-prompt-position="bottomLeft:20"
                       class="form-control validate[required,minSize[10],maxSize[110]] text-input"
                       name="comment"
                       value="<?= (isset($one)) ? $one['comment'] : '' ?>"/>
            </div>
        </div>


        <input class="btn btn-primary btn-warning" type="submit" id="submit_blog"/>
    </form>
</div>