<?php

class Posts extends Controller
{
    /**
     * Array with validation rules
     * @rules array
     */
    public $rules = array(
        array(
            'field' => 'title_post',
            'label' => 'Title',
            'rules' => array(
                'required' => 'This field is required',
            )
        ),
        array(
            'field' => 'content',
            'label' => 'Content',
            'rules' => array(
                'required' => 'This field is required'

            )
        )
    );

    /**
     * Show one post page
     */
    function show()
    {
        //check privileges
        $url = Helper::current_url();
        $id = intval($url[2]);
        if (empty($id)) {
            Helper::redirect();
        } else {
            $post = new Posts_model();
            $category = new Categories_model();
            $comments_model = new Comments_model();

            $data['categories'] = $category->get_all(array(), array(), array('order_field' => 'title', 'order_dir' => 'asc'));
            $data['most_popular'] = $post->get_all(array(), array(), array('order_field' => 'nr_comments', 'order_dir' => 'desc'));
            $data['post'] = $post->get_one($id);
            $data['more_comments'] = $comments_model->get_all(array('id_post' => $id), array('LEFT JOIN' => array('users' => 'id_user')), array('order_field' => 'date_added', 'order_dir' => 'desc'));
            $this->view->load('posts/show_view', $data);

        }
    }

    /**
     * Search post by category action
     */
    function category()
    {
        //check privileges
        $url = Helper::current_url();
        $id = intval($url[2]);
        if (empty($id)) {
            Helper::redirect();
        } else {
            $post = new Posts_model();
            $category_model = new Categories_model();

            $data['latest'] = $post->get_all(
                array('posts.id_category' => $id),
                array('LEFT JOIN' => array('users' => 'id_user', 'categories' => 'id_category')),
                array('order_field' => 'date_add', 'order_dir' => 'desc')
            );
            $data['categories'] = $category_model->get_all(array(),array(),array('order_field' => 'title', 'order_dir' => 'asc'));
            $data['most_popular'] = $post->get_all(array(),array(),array('order_field' => 'nr_comments', 'order_dir' => 'desc'),5);
            $select_options = '';
            $categories = $category_model->get_all();
            foreach ($categories as $key => $category) {
                $select_options .= '<option value ="' . $category["id_category"] . '" >' . $category["title"] . '</option>';
            }
            $cat = $category_model->get_one($id);
            $data['title'] = $cat['title'];
            $data['options'] = $select_options;

            $this->view->load('home/home_view', $data);

        }
    }
    /**
     * Default action in admin panel for Posts
     */
    public function admin()
    {
        $data = array(
            'page_title' => 'Forum Posts',
            'page_active' => 'posts'
        );


        $this->view->load_admin('posts/admin/admin_view', $data);

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
                $order_col = 'id_post';
                break;
            case 5:
                $order_col = 'date_add';
                break;
            case 6:
                $order_col = 'date_published';
                break;
            case 7:
                $order_col = 'date_modified';
                break;
            default:
                $order_col = 'date_add';
        }

        //for ordering
        $order_params['order_field'] = $order_col;
        $order_params['order_dir'] = $order[0]['dir'];
        $join = array('LEFT JOIN' => array('users' => 'id_user', 'categories' => 'id_category'));
        $posts_model = new Posts_model();

        // select from db
        $posts = $posts_model->get_all(array(), $join, $order_params, $limit, $offset);
        $count_results = $posts_model->count_results(array());
        $count_records = $posts_model->count_results(array());

        //prepare for dt
        $output = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $count_records,
            "iTotalDisplayRecords" => $count_results,
            "aaData" => array()
        );
        $url = _URL_PATH . 'posts/ajax_edit_form';
        //adding the aaData
        foreach ($posts as $key => $row) {

            $output['aaData'][] = array(
                'id' => $row['id_post'],
                'user' => $row['name'],
                'category' => $row['title'],
                'title_post' => $row['title_post'],
                'content' => $row['content'],
                'date_add' => Helper::get_date($row['date_add'], 'M d, Y g:i A'),
                'date_published' =>  Helper::get_date($row['date_published'], 'M d, Y g:i A'),
                'date_modified' =>  Helper::get_date($row['date_modified'], 'M d, Y g:i A'),
                'nr_comments' => $row['nr_comments'],
                'published' =>($row['published']==1)?'YES':'NO',
                'actions' => '<div class="btn-group" role="toolbar">
                                    <a class="fancybox fancybox.ajax btn btn-sm btn-primary" post-id="' . $row["id_post"] . '" href="' . $url . "/" . $row["id_post"] . '" title="Edit a post">
                                        <i class="glyphicon glyphicon-pencil" aria-hidden="true" title="Edit a post"></i>
                                    </a>
                                <button type="button" class="btn btn-sm btn-danger post-delete" data-post="' . $row["id_post"] . '" title="Remove a post">
                                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                </button>
                              </div>'
            );
        }

        echo json_encode($output);
    }

    /**
     * Show add one post form
     */
    public function ajax_add_form(){
        $categories_model = new Categories_model();
        $categories = $categories_model->get_all();
        $select_options = '';

        foreach ($categories as $key => $category) {
            $select_options .= '<option value ="' . $category["id_category"] . '" >' . $category["title"] . '</option>';
        }
        $data = array(
            'modal_title' => 'Add',
            'form_action' => 'ajax_save',
            'options'     => $select_options
        );

        $this->view->load_content('posts/admin/form_view', $data);
    }

    /**
     * Show edit one post form
     */
    public function ajax_edit_form(){
        $url = Helper::current_url();
        $id = intval($url[2]);
        $posts_model = new Posts_model();
        $id_rez = $posts_model->check_id($id);
        if (empty($id_rez))
           Helper::redirect(_URL_PATH);

        $one_record = $posts_model->get_one($id);
        $categories_model = new Categories_model();
        $categories = $categories_model->get_all();
        $select_options = '';

        foreach ($categories as $key => $category) {
            if ($category['id_category'] !== $one_record['id_category']) {
                $select_options .= '<option value ="' . $category["id_category"] . '" >' . $category["title"] . '</option>';
            } else {
                $select_options .= '<option value ="' . $category["id_category"] . '" selected>' . $category["title"] . '</option>';
            }
        }

        $data = array(
            'modal_title' => 'Edit',
            'one'         => $one_record,
            'options'     => $select_options,
            'form_action' => 'ajax_update/' . $id
        );

        $this->view->load_content('posts/admin/form_view', $data);
    }

    /**
     * Save one post
     */
    public function ajax_save(){
        $validator = new Validator();
        $validator->set_rules($this->rules);
        $validator->set_error_delimiters("<div class='error'>", "</div>");

        if (empty($_POST)) {
            die("Alert");
        } else {
            if (!$validator->run()) {

                $one['title_post'] = $validator->postdata('title_post');
                $one['content'] = $validator->postdata('content');

                $errors = $validator->get_array_errors();
                $err_string = '';
                foreach($errors as $key =>$value) {
                    $err_string .= $key . ' : ' . $value;
                }
                    $validator->reset_postdata();
                echo json_encode(array('status' => 'error', 'message' => $err_string));


            } else {

                $title = $validator->postdata('title_post');
                $content = $validator->postdata('content');

                $data = array(
                    'title_post' => Helper::filterString($title),
                    'content' => Helper::filterString($content),
                    'date_add' => (isset($_POST['date_added'])) ? Helper::get_date($_POST['date_added'], 'Y-m-d G:i:s') : date('Y-m-d  G:i:s'),
                );

                /* $data['title_post'] = $_POST['title_post'];*/
                $data['id_user'] = $_POST['user'];
                /* $data['content'] = $_POST['content'];*/
                $data['published'] = $_POST['published'];//bool
                //$data['date_add'] = (isset($_POST['date_added'])) ? Helper::get_date($_POST['date_added'], 'Y-m-d G:i:s') : date('Y-m-d  G:i:s');//date
                $data['id_category'] = $_POST['category'];
                if ($data['published']) {
                    $data['date_published'] = date('Y-m-d');
                }
                $posts_model = new Posts_model();

                $id_user = $posts_model->add_one($data);
                if (!empty($id_user)) {
                    echo json_encode(array('status' => 'success', 'message' => 'Post added!'));
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'Something goes wrong!'));
                }
            }
        }
    }

    /**
     * Update one post
     */
    public function ajax_update()
    {
        $url = Helper::current_url();
        $id = intval($url[2]);

        $data['title_post'] = $_POST['title_post'];
        $data['id_user'] = $_POST['user'];
        $data['content'] = $_POST['content'];
        $data['published'] = $_POST['published'];//bool
        $data['date_add'] = Helper::get_date($_POST['date_added'], 'Y-m-d G:i:s');//date
        $data['id_category'] = $_POST['category'];
        if($data['published']){
            $data['date_published'] = date('Y-m-d G:i:s');
        }
        $posts_model = new Posts_model();

        if($posts_model->change_one($id,$data)){
            echo json_encode(array('status'=>'success','message'=>'Post updated!'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Something goes wrong!'));
        }
    }

    /**
     * Delete one post
     */
    public function ajax_delete()
    {

        $id = intval($_POST['id']);
        $posts_model = new Posts_model();

        $row = $posts_model->delete_by_id($id);
        if(!empty($row)){
            echo json_encode(array('status'=>'success','message'=>'Post delete!'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Something goes wrong!'));
        }
    }
}