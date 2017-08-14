<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 13.08.2017
 * Time: 11:11
 */

namespace controller\game_controller\iterators;


interface WaveFunctionGenerator
{
    /**
     * generates one Cycle of values, afterward false
     * @return array(phase=>value) or if multidimensional array(phase=>array(dimension=>value))|bool
     */
    public function generateCycle();

    /**
     * generates values as long as asked for
     * @return array(phase=>value) or if multidimensional array(phase=>array(dimension=>value))
     */
    public function generateWave(): array;

    /**
     * calculates value at given phase
     * @param int $input_phase XOR none, which results in current
     * @return array(phase=>value) or if multidimensional array(phase=>array(dimension=>value))
     */
    public function getStateAtPhase($input_phase): array;
}