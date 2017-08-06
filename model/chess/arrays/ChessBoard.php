<?php
namespace model\chess\arrays;

class ChessBoard extends \model\chess\arrays\NDimArrays
{
    protected $figures = array();

    public function __construct()
    {
        parent::__construct(...CHESS_BOARD_X_Y);
        \controller\game_controller\arrays\PutFieldsOnArray::excecute($this);  #Binded to class ??

    }

    public function addFigure(\model\chess\figures\AbstractFigure $figure, $position)
    {
        if (parent::testMaxV($position)) {  #look up if position is on board
            $this->figures[] = $figure;     #figure comes to the figure array
            $field = parent::select($position); #get field
            $success = $field->setOccupiedBy($figure); #set the field as occupied by

            $figure->updateAll(); #Update All possible movements (since it's first time)
        }

    }

    public function selectFromChessBoard($position)
    {
        if (!parent::testMaxV($position))
        {
            return false;
        }
        return parent::select($position, $method = 'nested_array');
    }
    public function moveFigure()
    {
        #To Do: 
    }
    public function killFigure()
    {
        #To Do:
    }
}