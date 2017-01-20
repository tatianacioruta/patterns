<?php

/**
 * Abstract Factory Pattern
 * Class HtmlFactory
 */
class HtmlFactory extends TextFactory
{
    public function createText($content)
    {
        return new HtmlText($content);
    }
}