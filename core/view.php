<?php
class View{
    /**
     * @param string $content_view
     * @param null $data
     */
    function load($content_view = '', $data = null)
    {

        require_once _ABS_PATH . 'views/templates/header_view.php';
        if(!empty($content_view)){
            require_once _ABS_PATH . 'views/' . $content_view . '.php';
        }
        require_once _ABS_PATH . 'views/templates/footer_view.php';
    }

    /**
     * @param string $content_view
     * @param null $data
     */
    function load_admin($content_view = '', $data = null)
    {

        require_once _ABS_PATH . 'views/templates/admin/header_view.php';
        if(!empty($content_view)){
            require_once _ABS_PATH . 'views/' . $content_view . '.php';
        }
        require_once _ABS_PATH . 'views/templates/admin/footer_view.php';
    }

    /**
     * @param string $content_view
     * @param null $data
     */
    function load_content($content_view = '', $data = null){
        require_once _ABS_PATH . 'views/' . $content_view . '.php';
    }
}