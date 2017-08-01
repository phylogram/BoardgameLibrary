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