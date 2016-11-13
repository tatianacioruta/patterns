<main class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="m-tb-10">
                <h2 class="for_title pull-left"><?= isset($page_title) ? $page_title : "Hognet" ?></h2>
                <!-- Modal -->
                <a class="fancybox fancybox.ajax btn btn-warning col-md-offset-11" data-id="<?=$_SESSION['user_data']['id_user']?>" id="btn_add"
                   href="<?= _URL_PATH .'categories/ajax_add_form' ?>" title="Add an category">Add</a>

            </div>
            <table
                class="dataTable table table-striped table-borderless table-bordered table-hover dt-responsive"
                width="100%"
                id="dt_category">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date added</th>
                    <th>Date modified</th>
                    <th>Nr posts</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date added</th>
                    <th>Date modified</th>
                    <th>Nr posts</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Variables for dt_ajax.js -->
    <script type="text/javascript">
        var dt_url = "<?=_URL_PATH . 'categories/dt_admin'?>";
        var page_form = "<?=_URL_PATH . 'categories/ajax_edit_form'?>";
        var page_delete = "<?= _URL_PATH . 'categories/ajax_delete'?>";
        var page_edit = "<?= _URL_PATH . 'categories/ajax_edit_form/'?>";

        $(document).ready(function () {
            var postTable = $('#dt_category').DataTable({
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
                                return 'Details for category';
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
                        "responsivePriority": 5
                    },
                    {
                        "mData": "title",
                        "bSortable": false,
                        "responsivePriority": 1
                    },
                    {
                        "mData": "date_add",
                        "className": "w70",
                        "responsivePriority": 6
                    },
                    {
                        "mData": "date_modified",
                        "className": "w70",
                        "responsivePriority": 4
                    },
                     {
                        "mData": "nr_posts",
                        "className": "w10",
                        "responsivePriority": 3
                    },
                    {
                        "mData": "actions",
                        "bSortable": false,
                        "className": "w100",
                        "responsivePriority": 2
                    }
                ],
                "order": [[2, "desc"]],
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


            $('body').on("submit", "#category_form", function (e) {
                e.preventDefault();
                if ($("#category_form").validationEngine('validate')) {
                        var $form = $('#category_form');
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
                                console.log(response);
                                showAlert(response.message, response.status);
                                if (response.status === 'success') {
                                    $('body #dt_category').DataTable().draw();
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
            $('.table').on("click", ".category-delete", function (e) {
                e.preventDefault();
                var id = $(this).data('category');
                showConfirm("Are you sure you want to delete this category?", "Confirm your action", function (result) {
                    if (result)
                        $.post(page_delete,
                            {id: id},
                            function (response) {
                                if (response.status == "success") {
                                    $('body #dt_category').DataTable().draw();
                                }
                                showAlert(response.message, response.status);
                            }, "json")
                });
            });

        });
    </script>
</main>
