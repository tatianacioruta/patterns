<?php

/**
 * Abstract Factory Pattern
 * Class JsonText
 */
class JsonText extends Text
{
    public function __construct($content)
    {
        return json_encode($content);
    }
}