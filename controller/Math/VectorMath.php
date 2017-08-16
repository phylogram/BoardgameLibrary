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
     * the return array will keep the keys of $a!
     * @param array $a
     * @param array $b
     * @return bool
     */
    public static function addVector(array $a, array $b)
    {
        if (count($a) != count($b)) {
            return false; #To Do: error
        }
        $position_b = 0;
        $array_sum = array();
        $phase_a = key($a);
        foreach ($a[$phase_a] as $key_a => $item_a) {
            $array_sum[$phase_a][$key_a] = $item_a + $b[$position_b];
            $position_b ++;
        }
        return $array_sum;
    }




    /** for use in array_walk() & array_walk_recursive()
     * @param int $carry
     * @param int $item
     * @return int
     */
    public static function add2ndLevel($Two_Dim_nested_array)
    {
        $return_value = 0;
        foreach ($Two_Dim_nested_array as $level) {
            $return_value += array_sum($level);
        }
        return $return_value;
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
    public static function columnSum(array $array, int $column): int
    {
        return array_sum(array_column($array, $column));
    }
        
}