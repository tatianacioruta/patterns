<?php

class Helper
{
    /**
     * Strip tags from string
     * @param $str string
     * @return string
     */
    static function filterString($str)
    {
        return strip_tags(trim($str));
    }

    /**
     * Redirect to given location
     * @param string $link
     */
    static function redirect($link = _URL_PATH)
    {
        header("Location: " . $link);
        exit();
    }

    /**
     * Return date in given format
     * @param $date
     * @param string $format
     * @return bool|null|string
     */
    static function get_date($date, $format = 'M d, Y g:i:s A')
    {
        return (empty($date)) ? NULL : date($format, strtotime($date));
    }

    /**
     * Return current url string
     * @return string
     */
    static function current_url()
    {
        $url = $_GET['url'];
        $url = rtrim($url, '/');
        return explode('/', $url);
    }
}