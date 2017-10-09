<?php
namespace model\game\arrays;

class ChessBoard extends NDimArrays
{
    protected $figures = array();

    public function __construct(array $size = CHESS_BOARD_X_Y)
    {
        parent::__construct(...$size);
        \controller\game_controller\arrays\PutFieldsOnArray::execute($this);  #Binded to class ??

    }

    /**
     * add figure at a position to the array
     * @param \model\game\figures\AnyFigure $figure
     * @param $position
     */
    public function addFigure(\model\game\figures\AnyFigure $figure, $position) #write function for pieces array
    {
        if (parent::testValidPosition($position)) {  #look up if position is on board
            $this->figures[$figure->getName()] = $figure;     #append figure the figure array
            $field = $this->selectFromChessBoard($position); #get field
            $figure->setPosition($position);
            $figure->setChessBoard($this);
            $field->setOccupiedBy($figure); #set the field as occupied by
            $field->updatePiecesThatReachMe();
            $figure->updateAll(); #Update All possible movements (since it's first time)
        }

    }

    /**
     * @param $position
     * @return bool|mixed if valid position returns reference to field, else false
     */
    public function selectFromChessBoard($position)
    {
        if (!parent::testValidPosition($position, $send_massage = false))
        {
            return false; #We do not want an error here, because this is used in iteration where false just stops the loop
        }
        return parent::select($position, $method = 'nested_array');
    }
    public function getFigures()
    {
        return $this->figures;
    }

}