<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 22.08.2017
 * Time: 15:24
 */

namespace controller\game_controller\iterators;


class SignatureFigure extends SignatureNDimShift
{
    protected  $is_sub_iterable;
    protected $sub_iteration_step_size;

    public function __construct(array $signatures, int $dim, int $number_of_dimensions, int $shift_step, bool $is_sub_iterable, int $sub_iteration_step_size)
    {
        parent::__construct($signatures, $dim, $number_of_dimensions, $shift_step);
        $this->is_sub_iterable = $is_sub_iterable;
        $this->sub_iteration_step_size = $sub_iteration_step_size;
    }
    public function isSubIterable()
    {
        return $this->is_sub_iterable;
    }
    public function getSubIterationStepSize()
    {
        return $this->sub_iteration_step_size;
    }
}