$(document).ready(function () {
    $('body').on('click', '#upgrade', function () {
        $('#upgrade').validationEngine({
            promptPosition: "topLeft:0", onValidationComplete: function (form, status) {
            }
        });
    });

    $(".fancybox, .modal_form, .template_form").fancybox({
        helpers: {
            title: null,
            overlay: {
                locked: true,
                closeClick: false
            }
        },
        beforeLoad: function () {
            var $elem = this.element;
            if ($elem.data('width')) {
                this.width = $elem.data('width');
                this.autoWidth = false;
            }
            if ($elem.data('minWidth')) {
                this.minWidth = $elem.data('minWidth');
                this.autoWidth = false;
            }

        },
        afterClose: function () {
            /*if (jQuery().simpleMaps && typeof $.fn.simpleMaps.close !== 'undefined') {
                $.fn.simpleMaps.close();
            }*/

        },
        beforeShow: function () {
            wrapDraggable();
        },
        height: '100%',
        margin: 0,
        scrolling: 'hidden',
        autoSize: true,
        //autoResize: false,
        //fitToView: false,
        closeClick: false
    });

    $('.nav-bg').on('show.bs.collapse', function () {
        var actives = $(this).find('.collapse.in'),
            hasData;
        if (actives && actives.length) {
            hasData = actives.data('collapse');
            if (hasData && hasData.transitioning) return;
            actives.collapse('hide');
            hasData || actives.data('collapse', null)
        }
    });

    var maxLength = 1000;
    $(document).on('keyup', '.message', function () {
        var length = $(this).val().length;
        var length = maxLength - length;
        $('.textarea-caracters').html(length + ' characters remaining');
    });

    $('.affix').affix({
        offset: {
            top: 370,
            bottom: ($('.footer').outerHeight(true) + 0)
        }
    });

    $('.accordion-toggle').on('shown', function () {
        $(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
    });


    $(".kill-filter").hover(function () {
        $('.filter-search').css('opacity', '0.5');
    }, function () {
        $('.filter-search').css('opacity', '1');
    });

    $(document).on('click', '.log-out', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        showConfirm('Are you sure?', 'LOG OUT', function (result) {
            if (result) {
                window.location.href = url;
            }
        })
    });

    $(".validation_form").validationEngine({
        promptPosition: "topLeft:0",
        scroll: false,
        binded: true
    });
});

function showAlert(message, status, title, callback) {
    status = status || 'success';
    title = title || (status == 'success' ? 'Success' : 'Error');
    var d = bootbox.dialog({
        message: message,
        title: title,
        buttons: {
            close: {
                label: "ok",
                className: "btn-standart btn-green text-uppercase",
                callback: callback
            }
        }
    });
    var statusClass = status == 'success' ? 'success' : 'error';
    d.find('.modal-header').addClass(statusClass + '-alert');
}

function showConfirm(message, title, callback) {
    var d = bootbox.dialog({
        message: message,
        title: title || "Confirm your action",
        buttons: {
            submit: {
                label: "yes",
                className: "btn-standart text-uppercase",
                callback: function () {
                    callback && callback(true);
                }
            },
            close: {
                label: "no",
                className: "btn-standart btn-green text-uppercase",
                callback: function () {
                    callback && callback(false);
                }
            }
        }
    });
    d.find('.modal-header').addClass('success-alert');
}

function showLoader(target) {
    target.addClass('loading').append('<div class="loader"></div>');
}

function hideLoader(target) {
    target.removeClass('loading').find($('.loader')).remove();
}
/**
 * Blog comments
 *
 * @param num
 */
function blog_comments_info(num) {
    if (typeof num !== 'undefined') {
        $('.new_blog_comments').html(num)
    } else {
        var url = window.location.origin + '/blog_comments/ajax_check_comments';
        $.ajax({
            url: url,
            dataType: 'JSON',
            method: 'POST',
            success: function (response) {
                if (response) {
                    $('.new_blog_comments').html(response[0]);
                } else {
                    $('.new_blog_comments').html(0);
                }
            }
        });
    }
}
/**
 * Coupon comments
 *
 * @param num
 */
function coupon_comments_info(num) {
    if (typeof num !== 'undefined') {
        $('.new_coupon_comments').html(num)
    } else {
        var url = window.location.origin + '/coupon_comments/ajax_check_comments';
        $.ajax({
            url: url,
            dataType: 'JSON',
            method: 'POST',
            success: function (response) {
                if (response) {
                    $('.new_coupon_comments').html(response[0]);
                } else {
                    $('.new_coupon_comments').html(0);
                }
            }
        });
    }
}
/**
 * Coupon comments
 *
 * @param num
 */
function coupon_info(num) {
    if (typeof num !== 'undefined') {
        $('.new_coupons').html(num)
    } else {
        var url = window.location.origin + '/coupon/ajax_check_coupons';
        $.ajax({
            url: url,
            dataType: 'JSON',
            method: 'POST',
            success: function (response) {
                if (response) {
                    $('.new_coupons').html(response[0]);
                } else {
                    $('.new_coupons').html(0);
                }
            }
        });
    }
}
/**
 * Loads cities after state is known
 *
 * @param state - id of state to select cities from
 * @param url - url to get data from
 * @param $city_obj - object to append to
 * @param id_city - selected city if needed
 */
function load_cities_simple(state, url, $city_obj, id_city) {
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id_state': state},
        dataType: 'JSON',
        async: true,
        error: function () {
            bootbox.alert('Operation failed!');
        },
        success: function (result) {
            $('option', $city_obj).remove();
            $city_obj.prepend("<option value='0'>City</option>");
            $.each(result, function (index, data) {
                if (typeof id_city !== "undefined" || id_city !== null)
                    if ((id_city) && (id_city == data.id_city))
                        if (data.city_and_id)
                            $city_obj.append($("<option></option>")
                                .attr("value", data.city_and_id)
                                .attr("selected", 'selected')
                                .text(data.city)
                            );
                        else
                            $city_obj.append($("<option></option>")
                                .attr("value", data.id_city)
                                .attr("selected", 'selected')
                                .text(data.city)
                            );
                if (data.city_and_id)
                    $city_obj.append($("<option></option>")
                        .attr("value", data.city_and_id)
                        .text(data.city)
                    );
                else
                    $city_obj.append($("<option></option>")
                        .attr("value", data.id_city)
                        .text(data.city)
                    );
            });
        }
    })
}

function load_cities(state, $city_obj, id_city, url) {
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id_state': state},
        dataType: 'JSON',
        async: true,
        error: function () {
            bootbox.alert('Operation failed!');
        },
        success: function (result) {
            $('option', $city_obj).remove();
            $.each(result, function (index, data) {
                if ((id_city) && (id_city == data.id_city))
                    $city_obj.append($("<option></option>")
                        .attr("value", data.id_city)
                        .attr("selected", 'selected')
                        .text(data.city)
                    );
                else
                    $city_obj.append($("<option></option>")
                        .attr("value", data.id_city)
                        .text(data.city)
                    );
            });
            $city_obj.select2();
        }
    });
}
/**
 *  Adding highlight class for columns and rows
 *
 * @param table - the table name
 */
function highlightDT(table) {
    table.on('mouseenter', 'td', function () {
        var colIdx = table.cell(this).index().column;
        var rowIdx = table.cell(this).index().row;

        $(table.columns().rows().nodes()).removeClass('highlight');
        $(table.columns().cells().nodes()).removeClass('highlight');

        $(table.column(colIdx).nodes()).addClass('highlight');
        $(table.rows(rowIdx).nodes()).addClass('highlight');
    });
}

/**
 * Ace editor initialization.
 * @param id - id of target element
 * @param value - value that will be inserted
 */
function set_ace(id, value) {
    var editor = ace.edit(id);
    var obj = $('#' + id);
    var parent = obj.parent();
    editor.setOptions({
        highlightActiveLine: true,
        showPrintMargin: true,
        useSoftTabs: true,
        tabSize: 4,
        mode: 'ace/mode/html',
        theme: 'ace/theme/eclipse',
        fontSize: "12pt"
    });
    obj.width(parent.innerWidth);
    obj.height(parent.innerHeight);
    obj.addClass('mnh-320');
    editor.resize();
    if (typeof value !== 'undefined') {
        editor.getSession().setValue(value);
    }
    return editor;
}

function showEditTools(self) {
    $('.drag-item, .selected-coupon').removeClass('hidden');
    self.removeClass('on');
    $('#preview-img').addClass('hidden');
    $('.preview-no-style').prop('checked', true);
    $('.draggable').css({'background': 'rgba(255,255,255,0.6)'});
    $('.draggable-anchor').css({'color': '#d33c0e'});
    $('.template-editable, .draggable-block').css({'background': 'rgba(0,0,0,0.1)', 'border': '1px solid #d33c0e'});
}

function hideEditTools() {
    $('.draggable').css({'background': 'transparent'});
    $('.draggable-anchor').css({'color': 'transparent'});
    $('.template-editable, .draggable-block').css({'background': 'transparent', 'border': '1px solid transparent'});
}

function saveImg(callback) {
    $("#divCanvas").html('');
    $('.draggble-block').removeClass('on');
    $('.drag-item').addClass('hidden');
    showLoader($('.fancybox-skin'));
    html2canvas($("#content")[0], {
        onrendered: function (canvas) {
            $.ajax({
                type: "POST",
                url: url_save,
                data: {
                    img: canvas.toDataURL()
                },
                complete: function () {
                    hideLoader($('.fancybox-skin'));
                },
                success: function (response) {
                    hideLoader($('.fancybox-skin'));
                    callback && callback(response);
                }
            })
        }
    });
}

function wrapDraggable(){
    var draggable_element = $('.fancybox-wrapper').find('.draggable-block');
    if(typeof draggable_element !== 'undefined' && !$.isEmptyObject(draggable_element)){
        $.each(draggable_element, function (i, e) {
            var width = $(this).width();
            var parent = $(this).parent();
            $(parent).append(
                $('<div></div>')
                    .addClass('draggable-block')
                    .width(width + 2)
                    .css({'position': 'relative'})
                    .append($(this).removeClass('draggable-block'))
                    .append($('<div></div>').html('<span><i class="fa fa-arrows"></i></span>')
                        .addClass('draggable-anchor')
                    )
            );
            $('.draggable-block').draggable({
                handle: '.draggable-anchor',
                containment: "#html_content",
                scroll: false
            });
        });
    }
}