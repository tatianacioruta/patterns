<?php
class Home extends Controller
{

    /**
     *Default action form Home controller
     */
    public function index(){
        $post = new Posts_model();
        $category = new Categories_model();

        $data['latest'] = $post->get_all(
            array(),
            array('LEFT JOIN' => array('users' => 'id_user', 'categories' => 'id_category')),
            array('order_field' => 'date_add', 'order_dir' => 'desc')
        );
        $data['categories'] = $category->get_all(array(),array(),array('order_field' => 'title', 'order_dir' => 'asc'));
        $data['most_popular'] = $post->get_all(array(),array(),array('order_field' => 'nr_comments', 'order_dir' => 'desc'),5);
        $select_options = '';
        $categories = $category->get_all();
        foreach ($categories as $key => $category) {
            $select_options .= '<option value ="' . $category["id_category"] . '" >' . $category["title"] . '</option>';
        }
        $data['options'] = $select_options;
        $data['title'] = 'Latest Posts';
        $this->view->load('home/home_view', $data);
    }
    /**
     * Default action in admin panel
     */
    public function admin(){
        $data = array('page_title' => "Admin home");
        $this->view->load_admin('home/admin/admin_view', $data);
        }

}