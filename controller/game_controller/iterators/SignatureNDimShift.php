<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 22.08.2017
 * Time: 13:03
 */

namespace controller\game_controller\iterators;


class SignatureNDimShift extends SignatureNDim
{
    protected $shift_step;
    protected $phases = array();
    protected $is_symmetric;
    protected $number_of_dimensions;
    protected $range_of_dimensions;

    public function __construct(array $signatures,int $dim, int $number_of_dimensions, int $shift_step)
    {
        parent::__construct($signatures, $dim);
        $this->number_of_dimensions = $number_of_dimensions;
        $this->range_of_dimensions = range(0, $number_of_dimensions - 1);

        $this->shift_step = $shift_step;

        foreach ($this->range_of_dimensions as $dim) {
            if ($dim === 0) {
                $this->phases[$dim] = $this->phase;
            } else {
                $this->phases[$dim] = $this->phases[$dim - 1] + $this->shift_step;
            }
        }

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