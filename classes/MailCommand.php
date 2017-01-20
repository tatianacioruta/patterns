<?php

/**
 * The chain-of-command pattern
 */
class MailCommand implements ICommand
{
    public function onCommand( $name, $args )
    {
        if ( $name != 'mail' ){
            return false;
        }else{
            if($args == 'admin'){
                echo( "function Send_Mail_to_Admin" );
            }elseif($args == 'social'){
                echo( "function Send_Mail_to_Marketing" );
            }
        }
        return true;
    }
}