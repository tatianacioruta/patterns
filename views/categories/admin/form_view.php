<? (!empty($data)) ? extract($data):""; ?>
<div class="fancybox-title-custom">
    <p><?= $modal_title ?></p>
</div>
<div class="fancybox-wrapper w400">
    <form id="category_form" class="validation_form" method="post" role="form" action="<?= _URL_PATH . 'categories/' . $form_action ?>">
        <div class="form-group">
            <div class="col-sm-12 padding_none">
                <label for="title" class="col-sm-12 text-left">Category title:</label><br/>
                <input id="title" data-prompt-position="bottomLeft:20"
                       class="form-control validate[required,minSize[3],maxSize[110]] text-input"
                       name="title"
                       value="<?= (isset($one)) ? $one['title'] : '' ?>"/>
            </div>
        </div>


        <input class="btn btn-primary btn-warning" type="submit" id="submit_blog"/>
    </form>
</div>