<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 22.08.2017
 * Time: 15:30
 */

namespace controller\game_controller\iterators;
#To Do: Clean Up

class FigureFunctionGenerator extends NDimTriangleFunctionGeneratorShifted
{
    protected $is_sub_Iterable;
    protected $sub_iteration_step_size;

    protected $step = 1;

    public function __construct(SignatureFigure $signatures, $dimension = 0)
    {
        parent::__construct($signatures, $dimension);
        $this->is_sub_Iterable = $signatures->isSubIterable();
        $this->sub_iteration_step_size = $signatures->getSubIterationStepSize();
    }

    public function next()
    {
        $this->phase ++;
        $this->timer ++;
        $this->step = 1;
    }

    protected function cycle()
    {
        if ($this->is_sub_Iterable) {
            $this->step ++;
        } else {
            $this->next();
        }
    }

    public function getStateAtPhase($input_phase = 'current'): \controller\game_controller\iterators\phase
    {
        $this->current_phase = parent::getStateAtPhase($input_phase);
        $this->current_phase->setStep($this->step);
        $this->current_phase->multiplyScalar($this->step * $this->sub_iteration_step_size);


        return $this->current_phase;
    }




    public function reset() { #To Do: Implement for parent classes - call it like the iterator interface
        $this->step = 1;
        $this->setPhase($this->signatures[0]->phase);
        $this->setTimer(0);
        $this->positional_current_phase = $this->current_phase;
    }
    public  function setStep(int $step)
    {
        $this->step = $step;
    }
    public function getStep() {
        return $this->step;
    }
}