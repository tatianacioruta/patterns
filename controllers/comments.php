<?php

class Comments extends Controller
{

    /**
     * Default action in admin panel for Comments
     */
    public function admin()
    {
        $data = array(
            'page_title' => 'Posts Comments',
            'page_active' => 'comments'
        );


        $this->view->load_admin('comments/admin/admin_view', $data);

    }
    /**
     * Ajax get data for data table
     */
    public function dt_admin()
    {
        $offset = intval($_POST['start']);
        $limit = intval($_POST['length']);

        $order = $_POST['order'];

        switch ($order[0]['column']) {
            case 1:
                $order_col = 'id_comment';
                break;
            case 5:
                $order_col = 'date_added';
                break;
            case 6:
                $order_col = 'date_modified';
                break;
            default:
                $order_col = 'id_comment';
        }

        //for ordering
        $order_params['order_field'] = $order_col;
        $order_params['order_dir'] = $order[0]['dir'];
        $join = array('LEFT JOIN' => array('users' => 'id_user', 'posts' => 'id_post'));
        $comment_model = new Comments_model();

        // select from db
        $posts = $comment_model->get_all(array(), $join, $order_params, $limit, $offset);
        $count_results = $comment_model->count_results(array());
        $count_records = $comment_model->count_results(array());

        //prepare for dt
        $output = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $count_records,
            "iTotalDisplayRecords" => $count_results,
            "aaData" => array()
        );
        $url = _URL_PATH . 'comments/ajax_edit_form';
        //adding the aaData
        foreach ($posts as $key => $row) {

            $output['aaData'][] = array(
                'id' => $row['id_comment'],
                'user' => $row['name'],
                'title_post' => $row['title_post'],
                'comment' => $row['comment'],
                'date_added' => Helper::get_date($row['date_added'], 'M d, Y g:i A'),
                'date_modified' => Helper::get_date($row['date_modified'], 'M d, Y g:i A'),
                'actions' => '<div class="btn-group" role="toolbar">
                                    <a class="fancybox fancybox.ajax btn btn-sm btn-primary" comment-id="' . $row["id_comment"] . '" href="' . $url . "/" . $row["id_comment"] . '" title="Edit a comment">
                                        <i class="glyphicon glyphicon-pencil" aria-hidden="true" title="Edit a comment"></i>
                                    </a>
                                <button type="button" class="btn btn-sm btn-danger comment-delete" data-comment="' . $row["id_comment"] . '" title="Remove a comment">
                                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                </button>
                              </div>'
            );
        }

        echo json_encode($output);
    }

    /**
     * Shoe edit comment form
     */
    public function ajax_edit_form()
    {
        $url = Helper::current_url();
        $id = intval($url[2]);
        $comments_model = new Comments_model();
        $id_rez = $comments_model->check_id($id);
         if (empty($id_rez))
            Helper::redirect(_URL_PATH);

        $one_record = $comments_model->get_one($id);

        $data = array(
            'modal_title' => 'Edit',
            'one' => $one_record,
            'form_action' => 'ajax_update/' . $id
        );

        $this->view->load_content('comments/admin/form_view', $data);
    }

    /**
     * Save one comment in db
     */
    public function ajax_save()
    {
        $data['id_post'] = $_POST['id_post'];
        $data['id_user'] = $_POST['id_user'];
        $data['comment'] = $_POST['comment'];
        $data['date_added'] = date('Y-m-d G:i:s');//date

        $comments_model = new Comments_model();

        $id_comment = $comments_model->add_one($data);
        if (!empty($id_comment)) {
            echo json_encode(array('status' => 'success', 'message' => 'Comment added!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Something goes wrong!'));
        }
    }

    /**
     * Update one comment
     */
    public function ajax_update()
    {
        $url = Helper::current_url();
        $id = intval($url[2]);

        $data['comment'] = $_POST['comment'];
        $comments_model = new Comments_model();


        if ($comments_model->change_one($id, $data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Comment updated!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Something goes wrong!'));
        }


    }

    /**
     * Delete one comment
     */
    public function ajax_delete()
    {

        $id = intval($_POST['id']);
        $comments_model = new Comments_model();

        $row = $comments_model->delete_by_id($id);
        if (!empty($row)) {
            echo json_encode(array('status' => 'success', 'message' => 'Comment deleted!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Something goes wrong!'));
        }
    }
}