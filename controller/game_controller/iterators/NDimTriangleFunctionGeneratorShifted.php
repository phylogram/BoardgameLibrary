<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 22.08.2017
 * Time: 13:32
 */

namespace controller\game_controller\iterators;

/**
 * This class constructs multiple identical triangle waves that are shifted foreach dimension
 * Class NDimTriangleFunctionGeneratorShifted
 * @package controller\game_controller\iterators
 */
class NDimTriangleFunctionGeneratorShifted extends NDimSquareFunctionGenerator
{

    protected $shift_step;
    protected $phases = array();

    protected $number_of_dimensions;
    protected $range_of_dimensions;


    public function __construct(\controller\game_controller\iterators\SignatureNDimShift $signatures, $dimension = 0)
    {
        parent::__construct($signatures, $dimension);

        $this->shift_step = $signatures->getShiftStep();
        $this->phases = $signatures->getShiftStep();

        $this->number_of_dimensions = $signatures->getNumberOfDimensions();
        $this->range_of_dimensions = $signatures->getRangeOfDimensions();

        foreach ($this->range_of_dimensions as $dim) {
            $this->generator_objects[$dim] = new \controller\game_controller\iterators\TriangleFunctionGenerator($signatures); #This will undo the parent constructor To Do: change
        }

        $this->current_phase = new \controller\game_controller\iterators\phase($this->phase);
    }


    public function getStateAtPhase($input_phase = 'current'): \controller\game_controller\iterators\phase
    {

        if ($input_phase === 'current') {
            $input_phase = $this->phase;
        }

        $this->current_phase->setCurrentPhase($input_phase);
        foreach ($this->generator_objects as $dim => $object) {
            $current_phase = $input_phase + $dim * $this->shift_step;
            $state = $object->getStateAtPhase($current_phase);

            $this->current_phase->set(
                  $dim,
                  current($state->values)
            );
        }
        return $this->current_phase;
    }




    public function getShiftStep(): int
    {
        return $this->shift_step;
    }
    public function getPhases(): array
    {
        return $this->phases;
    }
    public function isSymmetric(): bool
    {
        return $this->is_symmetric;
    }
    public function getNumberOfDimensions(): int
    {
        return $this->number_of_dimensions;
    }
    public function getRangeOfDimensions()
    {
        return $this->range_of_dimensions;
    }


}