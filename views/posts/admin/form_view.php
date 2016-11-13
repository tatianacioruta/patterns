<? (!empty($data)) ? extract($data):""; ?>
<div class="fancybox-title-custom">
    <p><?= $modal_title ?></p>
</div>
<div class="fancybox-wrapper w400">
    <form id="post_form" class="validation_form" method="post" role="form" name="blog_form"
          action="<?= _URL_PATH . 'posts/' . $form_action ?>">
        <div class="form-group">
            <div class="col-sm-8 padding_none">
                <label for="title_post" class="col-sm-12 text-left">Title:</label><br/>
                <input id="title_post" data-prompt-position="bottomLeft:20"
                       class="form-control validate[required,minSize[10],maxSize[110]] text-input"
                       name="title_post"
                       value="<?= (isset($one)) ? $one['title_post'] : '' ?>"/>
            </div>
            <div class="col-sm-4 padding_right_none">
                <label for="category" class="col-sm-12 text-left">Categories</label>
                <select name="category" id="blog_category" class="col-sm-12">
                    <?= (isset($options)) ? $options : '<option></option>' ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-8">
                <label for="date_added" class="col-sm-12 text-left">Date add:</label>

                <div class="input-group date">
                    <input type="text" id="date_added" data-prompt-position="bottomLeft:20"
                           class="form-control validate[required]" name="date_added"
                           value="<?= (isset($one)) ? Helper::get_date($one['date_add'], 'M d, Y') : date('M d, Y') ?>"><span
                        class="input-group-addon">
                            <i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
            <div class="col-sm-2 padding_none">
                <label for="published" class="col-sm-12 text-left">Published:</label>
                <input id="published" type="checkbox" name="published"
                       class="checkbox checkbox-inline margin_none w-25 h-25" <?= (isset($one) && ($one['published'] == 1)) ? "checked" : '' ?>
                       value="<?= (isset($one['published'])) ? $one['published'] : '0'; ?>"/>
            </div>
        </div>
        <div class="clearfix space"></div>

        <div class="form-group">
            <label class="col-sm-12" for="content">Content:</label><br/>
            <textarea id="content" class="form-control validate[required,minSize[10],maxSize[110]]" rows="3" cols="16"
                      name="content"><?= (isset($one)) ? $one['content'] : '' ?></textarea>
        </div>

        <input class="btn btn-primary btn-warning" type="submit" name="submit_blog" id="submit_blog"/>
    </form>
</div>


<script>
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