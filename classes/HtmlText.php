<?php

/**
 * Created by PhpStorm.
 * User: Tati
 * Date: 18.01.2017
 * Time: 21:22
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