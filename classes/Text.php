<?php

/**
 * Created by PhpStorm.
 * User: Tati
 * Date: 18.01.2017
 * Time: 21:19
 */
abstract class Text
{
    private $text;

    /**
     * @param string $text
     */
    public function __construct($text = "")
    {
        $this->text = $text;
    }
}