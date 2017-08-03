<?php
namespace model\chess\figures;

abstract class AbstractFigure
{
    protected $position;
    protected $color;
    protected $name;
    protected $can_move_multiple;
    protected $inner_iterator;

    public function __construct(array $position, str $name, str $color)
    {
        $this->position = $position;
        $this->color = $color;
        $this->name = $name;
    }
    public function getkilled()
    {
        $protected->position = false;
    }

    /**
     * sets position $old to $new
     * and does some basic "piece inherit" logic
     * 1. n_dim?
     * 2. is $vector posible for piece "anywhere"
     * @param array $vector
     * @return bool $success
     */
    abstract function move(array $vector): bool;

    /**
     * updates alle possible movements - at the beginning and after move
     */
    abstract function updateAll(): bool;
    /**
     * only updates one phase - after other figures moved
     * @param mixed $phase 
     */
    abstract function updatePhase($phase): bool;
    
    /**
     * Deletes all posible movements
     */
    abstract function undoAll(): bool;

    /**
     * Deletes all movements of phase after $other_position
     */
    abstract function undoPhaseAfter($phase, $other_position);

    /**
     * getIterator
     * returns reference to innerIterator at controller
     * @return callable
     */
    public function getIterator(): callable
    {
        return $this->inner_iterator;
    }

    /**
     * if CanMoveMultiple
     * @return bool
     */
    public function getCanMoveMultiple(): bool
    {
        return $this->can_move_multiple;
    }

    
}