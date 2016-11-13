<?php
class User extends Controller
{
    /**
     * Default action in admin panel for User
     */
    public function admin()
    {
        $data = array(
            'page_title' => 'Users',
            'page_active' => 'user'
        );


        $this->view->load_admin('users/admin/admin_view', $data);

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
                $order_col = 'id_user';
                break;
            case 2:
                $order_col = 'name';
                break;
            case 3:
                $order_col = 'user_group';
                break;
            default:
                $order_col = 'name';
        }

        //for ordering
        $order_params['order_field'] = $order_col;
        $order_params['order_dir'] = $order[0]['dir'];
        $user_model = new User_model();

        // select from db
        $users = $user_model->get_all(array(), array(), $order_params, $limit, $offset);
        $count_results = $user_model->count_results(array());
        $count_records = $user_model->count_results(array());

        //prepare for dt
        $output = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $count_records,
            "iTotalDisplayRecords" => $count_results,
            "aaData" => array()
        );
        //adding the aaData
        foreach ($users as $key => $row) {
            $output['aaData'][] = array(
                'id' => $row['id_user'],
                'user' => $row['name'],
                'group' => $row['user_group'],
                'actions' => '<div class="btn-group" role="toolbar">
                                <button type="button" class="btn btn-sm btn-danger user-delete" data-user="' . $row["id_user"] . '" title="Remove a user">
                                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                </button>
                              </div>'
            );
        }

        echo json_encode($output);
    }

    /**
     * Show add user form
     */
    public function ajax_add_form(){
        $data = array(
            'modal_title' => 'Add',
            'form_action' => 'ajax_save'
        );

        $this->view->load_content('users/admin/form_view', $data);
    }

    /**
     * Show edit user form
     */
    public function ajax_edit_form(){
        $url = Helper::current_url();
        $id = intval($url[2]);
        $user_model = new User_model();
        $id_rez = $user_model->check_id($id);
         if (empty($id_rez))
            Helper::redirect(_URL_PATH);

        $one_record = $user_model->get_one($id);

        $data = array(
            'modal_title' => 'Edit',
            'one'         => $one_record,
            'form_action' => 'ajax_update/' . $id
        );

        $this->view->load_content('users/admin/form_view', $data);
    }

    /**
     * Delete one user from db
     */
    public function ajax_delete()
    {

        $id = intval($_POST['id']);
        $user_model = new User_model();

        $row = $user_model->delete_by_id($id);
        if(!empty($row)){
            echo json_encode(array('status'=>'success','message'=>'User delete!'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Something goes wrong!'));
        }
    }
}