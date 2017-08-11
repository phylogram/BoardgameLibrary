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

    /**
     * returns the least common multiple of an array of integers
     * #https://en.wikipedia.org/wiki/Least_common_multiple#Reduction_by_the_greatest_common_divisor
     * abs($array_item_n * $array_item_n-1) / gmp_gcd($array_item_n * $array_item_n-1)
     * where gmp_gcd is the gmp implementation of the greatest common divisor
     * @param array $array
     * @return int
     */
    public static function leastCommonMultipleOfArray(array $array)
    {
        $current_least_common_multiply = 1;
        foreach ($array as $element) {
            $current_least_common_multiply = abs($current_least_common_multiply * $element) / gmp_gcd($current_least_common_multiply, $element); #https://en.wikipedia.org/wiki/Least_common_multiple#Reduction_by_the_greatest_common_divisor
        }
        return gmp_intval($current_least_common_multiply);
        }
        
}