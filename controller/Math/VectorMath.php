<?php
namespace controller\Math;

class VectorMath {

    /**
     * Summary of addScalar
     * for use in array_walk() & array_walk_recursive()
     * @param int $item
     * @param mixed $key
     * @param int $scalar
     *
     *
     */
    public static function addScalar(int &$item, $key, int $scalar)
    {
            $item += $scalar;
    }
    public static function leastCommonMultipleOfArray(array $array)
    {
        $current_least_common_multiply = 1;
        foreach ($array as $element) {
            $current_least_common_multiply = abs($current_least_common_multiply * $element) / gmp_gcd($current_least_common_multiply, $element); #https://en.wikipedia.org/wiki/Least_common_multiple#Reduction_by_the_greatest_common_divisor
        }
        return intval($current_least_common_multiply);
        }
        
}