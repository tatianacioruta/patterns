<?php

/**
 *The chain-of-command pattern
 */
interface ICommand
{
    function onCommand($name, $args);
}