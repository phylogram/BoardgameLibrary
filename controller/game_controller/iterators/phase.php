<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 18.08.2017
 * Time: 07:53
 */

namespace controller\game_controller\iterators;


class phase
{
    protected $current_phase;
    protected $step;

    public $values = array();

    public function __construct($phase)
    {
        $this->current_phase = $phase;
    }


    /**
     * @return mixed
     */
    public function getCurrentPhase()
    {
        return $this->current_phase;
    }

    /**
     * @param $dimension
     * @param $value
     */
    public function set($dimension, $value)
    {
        $this->values[$dimension] = $value;
    }

    /**
     * @param $dimension
     * @return mixed
     */
    public function get($dimension)
    {
        if (isset($this->values[$dimension])) {
            return $this->values[$dimension];
        }
    }

    /**
     * @return mixed
     */
    public function getStep(): int
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     */
    public function setStep(int $step)
    {
        $this->step = $step;
    }

    /**
     * @param mixed $current_phase
     */
    public function setCurrentPhase($current_phase)
    {
        $this->current_phase = $current_phase;
    }

    public function addVector ($vector)
    {
        $dimensions = count($this->values);
        if (count($vector) !== $dimensions) {
            return false; #To Do: Some Warning
        }

        foreach (array_combine(range(0, $dimensions - 1), $vector) as $dimension => $value) {
            $this->values[$dimension] += $value;
        }
    }

    public function addScalar(int $scalar)
    {
        foreach ($this->values as &$value) {
            $value += $scalar;
        }
    }
    public function multiplyScalar(int $scalar)
    {
        foreach ($this->values as &$value) {
            $value *= $scalar;
        }
    }
    public function sumUpDimensions(int $newDimension)
    {
        $values = $this->values; #temporarily store the values
        $this->values = array(); #delete the old ones
        $this->values[$newDimension] = array_sum($values); # and them at the desired dimension
    }
}