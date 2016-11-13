<?php

class Categories extends Controller
{

    /**
     * Default action in admin panel for Categories
     */
    public function admin()
    {
        $data = array(
            'page_title' => 'Posts Category',
            'page_active' => 'categories'
        );


        $this->view->load_admin('categories/admin/admin_view', $data);

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
                $order_col = 'id_category';
                break;
            case 3:
                $order_col = 'date_add';
                break;
            case 4:
                $order_col = 'date_modified';
                break;
             case 5:
                $order_col = 'nr_posts';
                break;
            default:
                $order_col = 'date_add';
        }

        //for ordering
        $order_params['order_field'] = $order_col;
        $order_params['order_dir'] = $order[0]['dir'];
        $category_model = new Categories_model();

        // select from db
        $categories = $category_model->get_all(array(), array(), $order_params, $limit, $offset);
        $count_results = $category_model->count_results(array());
        $count_records = $category_model->count_results(array());

        //prepare for dt
        $output = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $count_records,
            "iTotalDisplayRecords" => $count_results,
            "aaData" => array()
        );
        $url = _URL_PATH . 'categories/ajax_edit_form';

        //adding the aaData
        foreach ($categories as $key => $row) {

            $output['aaData'][] = array(
                'id' => $row['id_category'],
                'title' => $row['title'],
                'date_add' => Helper::get_date($row['date_add'], 'M d, Y'),
                'date_modified' =>  Helper::get_date($row['date_modified'], 'M d, Y g:i A'),
                'nr_posts' => $row['nr_posts'],
                'actions' => '<div class="btn-group" role="toolbar">
                                    <a class="fancybox fancybox.ajax btn btn-sm btn-primary" category-id="' . $row["id_category"] . '" href="' . $url . "/" . $row["id_category"] . '" title="Edit a category">
                                        <i class="glyphicon glyphicon-pencil" aria-hidden="true" title="Edit a category"></i>
                                    </a>
                                <button type="button" class="btn btn-sm btn-danger category-delete" data-category="' . $row["id_category"] . '" title="Remove a category">
                                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                </button>
                              </div>'
            );
        }

        echo json_encode($output);
    }

    /**
     * Show add form for category
     */
    public function ajax_add_form(){
        $data = array(
            'modal_title' => 'Add',
            'form_action' => 'ajax_save'
        );

        $this->view->load_content('categories/admin/form_view', $data);
    }

    /**
     * Show edit form for category
     */
    public function ajax_edit_form(){
        $url = Helper::current_url();
        $id = intval($url[2]);
        $categories_model = new Categories_model();
        $id_rez = $categories_model->check_id($id);
        /* if (empty($id_rez))
            Helper::redirect(_URL_PATH);*/

        $one_record = $categories_model->get_one($id);

        $data = array(
            'modal_title' => 'Edit',
            'one'         => $one_record,
            'form_action' => 'ajax_update/' . $id
        );

        $this->view->load_content('categories/admin/form_view', $data);
    }

    /**
     * Save one category
     */
    public function ajax_save(){
        $data['title'] = $_POST['title'];
        $data['date_add'] = date('Y-m-d G:i:s');//date
        $categories_model = new Categories_model();

        $id_category = $categories_model->add_one($data);
        if(!empty($id_category)){
            echo json_encode(array('status'=>'success','message'=>'Category added!'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Something goes wrong!'));
        }
    }

    /**
     * Update action for categories
     */
    public function ajax_update()
    {
        $url = Helper::current_url();
        $id = intval($url[2]);

        $data['title'] = $_POST['title'];

        $categories_model = new Categories_model();

        if($categories_model->change_one($id,$data)){
            echo json_encode(array('status'=>'success','message'=>'Category updated!'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Something goes wrong!'));
        }



    }

    /**
     * Delete one category
     */
    public function ajax_delete()
    {

        $id = intval($_POST['id']);
        $categories_model = new Categories_model();

        $row = $categories_model->delete_by_id($id);
        if(!empty($row)){
            echo json_encode(array('status'=>'success','message'=>'Category delete!'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Something goes wrong!'));
        }
    }
}