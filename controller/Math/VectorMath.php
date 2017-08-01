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
}