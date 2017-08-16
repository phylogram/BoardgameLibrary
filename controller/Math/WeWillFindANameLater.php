<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 15.08.2017
 * Time: 10:46
 */

namespace controller\Math;


class WeWillFindANameLater
{
    public static function findIntegerDivisors($integer)
    {
        $integer_divisors = array($integer);
        foreach (range(2, $integer -1 ) as $divisor) {
            if ($integer % $divisor == 0) {
                $integer_divisors[] = $divisor;
            }
        }
        return $integer_divisors;
    }
}