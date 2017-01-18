<?php

/**
 * Created by PhpStorm.
 * User: Tati
 * Date: 18.01.2017
 * Time: 21:20
 */
class JsonText extends Text
{
    public function __construct($content)
    {
        return json_encode($content);
    }
}