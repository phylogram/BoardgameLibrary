<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 06.08.2017
 * Time: 15:11
 */

namespace controller\SecureAndClean;

#replace by library?

class SecureAndClean
{
    /**
     * Takes string by reference, trims it and cleans it of code
     * @param string $string
     */
    public static function convert(string &$string)
    {
        $string = trim($string);
        $string = strip_tags($string);
        #To Do – there is more securing to do f.e. sql injection


    }
}