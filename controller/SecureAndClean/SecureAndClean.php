<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 06.08.2017
 * Time: 15:11
 */

namespace controller\SecureAndClean;


class SecureAndClean
{
    public static function convert(str &$string)
    {
        $string = trim($string);
        $string = strip_tags($string);
        #To Do – there is more securing to do f.e. sql injection

    }
}