<?php

/**
 * Abstract Factory Pattern
 * Class HtmlText
 */
class HtmlText extends Text
{
    /**
     * HtmlText constructor
     * @param string $content
     */
    public function __construct($content)
    {
        return '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title></title>
                    </head>
                    <body>'.
                        $content
                    .'</body>
                    </html>';
    }
}