<main class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="m-tb-10">
                <h2 class="for_title"><?= isset($page_title) ? $page_title : "Hognet" ?></h2>
                <!-- Modal -->
                </div>
            <table class="dataTable table table-striped table-borderless table-bordered table-hover dt-responsive" width="100%"
                id="dt_user">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Group</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Group</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Variables for dt_ajax.js -->
    <script type="text/javascript">
        var dt_url = "<?=_URL_PATH . 'user/dt_admin'?>";
        var page_delete = "<?= _URL_PATH . 'user/ajax_delete'?>";

        $(document).ready(function () {
            var postTable = $('#dt_user').DataTable({
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
                        "responsivePriority": 3
                    },
                    {
                        "mData": "user",
                        "bSortable": true,
                        "responsivePriority": 1
                    },
                    {
                        "mData": "group",
                        "bSortable": false,
                        "responsivePriority": 2
                    },

                    {
                        "mData": "actions",
                        "bSortable": false,
                        "className": "pl-5 pr-5 w20",
                        "responsivePriority": 4
                    }
                ],
                "order": [[1, "asc"]],
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

            /*DELETE*/
            $('.table').on("click", ".user-delete", function (e) {
                e.preventDefault();
                var id = $(this).data('user');
                showConfirm("Are you sure you want to delete this user?", "Confirm your action", function (result) {
                    if (result)
                        $.post(page_delete,
                            {id: id},
                            function (response) {
                                if (response.status == "success") {
                                    $('body #dt_user').DataTable().draw();
                                }
                                showAlert(response.message, response.status);
                            }, "json")
                });
            });

        });
    </script>
</main>
