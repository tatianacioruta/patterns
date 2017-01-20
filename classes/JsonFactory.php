<?php

/**
 * Abstract Factory Pattern
 * Class JsonFactory
 */
class JsonFactory extends TextFactory
{
    public function createText($content)
    {
        return new JsonText($content);
    }
}