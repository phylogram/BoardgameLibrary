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
     * Takes string by reference, trims it and cleans it of possible code elements
     * @param string $string
     */
    public static function convert(string &$string)
    {
        $string = trim($string);
        $string = strip_tags($string);
        #SQL Injection will be covered by the database library


    }
}