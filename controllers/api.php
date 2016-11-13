<?

class Api extends Controller
{
    /**
     * Api request
     */
    public function get_api_by_key()
    {
        if (!empty($_GET['key']) && !empty($_GET['user_id'])) {

            $api_model = new Api_model();
            $api = $api_model->get_one_by_cond(array('key_api' => $_GET['key']));

            if (!empty($api)) {
                $data['Api_Name'] = $api['name'];
                $user_model = new User_model();
                $data['user_info'] = $user_model->get_one_by_cond(array('id_user' => $_GET['user_id']), 'name, user_group');
            } else {
                $data['API_key'] = 'No such API';
            }
            print_r(json_encode($data));
        } else {
            echo 'Wrong API request';
        }
    }
}