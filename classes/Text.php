<?php

/**
 * Abstract Factory Pattern
 * Class Text
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