<?php

/**
 * Created by PhpStorm.
 * User: Tati
 * Date: 18.01.2017
 * Time: 21:14
 */
class JsonFactory extends TextFactory
{
    public function createText($content)
    {
        return new JsonText($content);
    }
}