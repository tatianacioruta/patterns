<?php

/**
 * Created by PhpStorm.
 * User: Tati
 * Date: 18.01.2017
 * Time: 21:16
 */
class HtmlFactory extends TextFactory
{
    public function createText($content)
    {
        return new HtmlText($content);
    }
}