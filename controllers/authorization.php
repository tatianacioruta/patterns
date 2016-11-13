<?php
session_start();

class Authorization extends Controller
{

    /**
     * Log in action
     */
    public function log_in(){
        if( !empty( $_POST["login"] ) && !empty( $_POST["password"] ) )
        {
            $user_model = new User_model();
            $user_exist = $user_model->get_one_by_cond(array('login'=>$_POST["login"],'password'=> $_POST["password"]), '*');
            if( !empty($user_exist ))
            {
                // set the user as connected and redirect him to a home page or something
	            $_SESSION['username']=$_POST["username"];
                $_SESSION["user_connected"] = true;
                $_SESSION["user_data"] = $user_exist;
                if($user_exist['user_group'] = 'admin'){
                    header("Location: http://tanysforum.co.nf/home/admin");
                }else{
                    header("Location: http://tanysforum.co.nf");
                }
            }else
            {
                // redirect him to an error page
                header("Location: http://tanysforum.co.nf/login-error.php");
            }
        }

        if(!empty( $_POST['social'])){
            $user_model = new User_model();
            $user_exist = $user_model->get_one_by_cond(array('social_id'=>$_POST['provider'].'::'.$_POST['social_id']), '*');
            if( !empty($user_exist )){
                // set the user as connected and redirect him to a home page or something
                $_SESSION["user_connected"] = true;
                $_SESSION["user_data"] = $user_exist;
                echo json_encode(array('status'=>'success'));
            }else{
                $data['name'] = $_POST['name'];
                $data['login'] = $_POST['email'];
                $data['social_id'] = $_POST['provider'].'::'.$_POST['social_id'];
                $data['password'] = $_POST['social_id'];
                $data['user_group'] = 'user';
                $user_model->add_one($data);
                $_SESSION["user_connected"] = true;
                $user_exist = $user_model->get_one_by_cond(array('login'=>$data['login'],'password'=> $data['password']), '*');
                $_SESSION["user_data"] = $user_exist;
                echo json_encode(array('status'=>'success'));
                }
            }
    }

    public function log_out(){
            session_unset();
        session_destroy();
        header("Location: http://tanysforum.co.nf");
        }

}