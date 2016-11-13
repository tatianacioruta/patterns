<main class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="m-tb-10">
                <h2 class="for_title pull-left"><?= isset($page_title) ? $page_title : "Hognet" ?></h2>
                <!-- Modal -->
                <a class="fancybox fancybox.ajax btn btn-warning col-md-offset-11" data-id="<?=$_SESSION['user_data']['id_user']?>" id="btn_add"
                   href="<?= _URL_PATH .'posts/ajax_add_form' ?>" title="Add an post">Add</a>

            </div>
            <table
                class="dataTable table table-striped table-borderless table-bordered table-hover dt-responsive"
                width="100%"
                id="dt_posts">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Title Post</th>
                    <th>Content</th>
                    <th>Date added</th>
                    <th>Date published</th>
                    <th>Date modified</th>
                    <th>Nr Comments</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Title Post</th>
                    <th>Content</th>
                    <th>Date added</th>
                    <th>Date published</th>
                    <th>Date modified</th>
                    <th>Nr Comments</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Variables for dt_ajax.js -->
    <script type="text/javascript">
        var dt_url = "<?=_URL_PATH . 'posts/dt_admin'?>";
        var page_form = "<?=_URL_PATH . 'posts/ajax_edit_form'?>";
        var page_delete = "<?= _URL_PATH . 'posts/ajax_delete'?>";
        var page_edit = "<?= _URL_PATH . 'posts/ajax_edit_form/'?>";

        $(document).ready(function () {
            var postTable = $('#dt_posts').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": function (data, callback, settings) {
                    $.ajax({
                        "dataType": 'JSON',
                        "type": "POST",
                        "url": dt_url,
                        "data": data,
                        "success": function (data, textStatus, jqXHR) {
                            callback(data, textStatus, jqXHR);
                        }
                    });
                },
                responsive: {
                    details: {
                        type: 'column',
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Details for post';
                            }
                        }),
                        renderer: function (api, rowIdx, columns) {
                            var data = api.cells(rowIdx, ':hidden').eq(0).map(function (cell) {
                                if (api.cell(cell).index().column != 0) {
                                    var header = $(api.column(cell.column).header());
                                    return '<tr>' +
                                        '<td>' + header.text() + ':' + '</td> ' +
                                        '<td>' + api.cell(cell).data() + '</td>' +
                                        '</tr>';
                                }
                            }).join('');

                            return data ? $('<table class="table"/>').append(data) : false;
                        }
                    }
                },
                "aoColumns": [
                    {
                        "mData": "id",
                        "className": "w10",
                        "responsivePriority": 11
                    },
                    {
                        "mData": "user",
                        "bSortable": false,
                        "responsivePriority": 5
                    },
                    {
                        "mData": "category",
                        "bSortable": false,
                        "responsivePriority": 6
                    },
                    {
                        "mData": "title_post",
                        "bSortable": false,
                        "responsivePriority": 1
                    },
                    {
                        "mData": "content",
                        "bSortable": false,
                        "responsivePriority": 3
                    },
                    {
                        "mData": "date_add",
                        "className": "w70",
                        "responsivePriority": 8
                    },
                    {
                        "mData": "date_published",
                        "className": "w70",
                        "responsivePriority": 9
                    },
                    {
                        "mData": "date_modified",
                        "className": "w70",
                        "responsivePriority": 10
                    },
                    {
                        "mData": "nr_comments",
                        "bSortable": false,
                        "className": "w10",
                        "responsivePriority": 4
                    },
                    {
                        "mData": "published",
                        "bSortable": false,
                        "className": "w20",
                        "responsivePriority": 7
                    },
                    {
                        "mData": "actions",
                        "bSortable": false,
                        "className": "w100",
                        "responsivePriority": 2
                    }
                ],
                "order": [[5, "desc"]],
                "initComplete": function () {
                    var $searchInput = $('div.dataTables_filter input');

                    $searchInput.unbind();

                    $searchInput.bind('keyup', function (e) {
                        if (e.keyCode == 13) {
                            postTable.search(this.value).draw();
                        }
                    });
                }
            });


            $('body').on("submit", "#post_form", function (e) {
                e.preventDefault();
                if ($("#post_form").validationEngine('validate')) {
                        var $form = $('#post_form');
                        var $id_user = $('#btn_add').data('id');
                        var data = $form.serialize();
                        data += '&user=' + $id_user;
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
                                    $('body #dt_posts').DataTable().draw();
                                    $.fancybox.close();
                                }else{
                                    $.fancybox.close();
                                }
                            },
                            error: function (response) {
                                showAlert("Operation failed!", 'fail');
                            }
                        });

                    }
                });


            /*DELETE*/
            $('.table').on("click", ".post-delete", function (e) {
                e.preventDefault();
                var id = $(this).data('post');
                showConfirm("Are you sure you want to delete this post?", "Confirm your action", function (result) {
                    if (result)
                        $.post(page_delete,
                            {id: id},
                            function (response) {
                                if (response.status == "success") {
                                    $('body #dt_posts').DataTable().draw();
                                }
                                showAlert(response.message, response.status);
                            }, "json")
                });
            });

        });
    </script>
</main>
