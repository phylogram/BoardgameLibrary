<?php
namespace model\game\fields;

class GameField
{
    protected $position = array(); #Position in array (chessboard)
    protected $occupied_by = array(); #reference to object = piece
    protected $pieces_that_reach_me = array(); #reference to pieces, that move to field
    protected $is_occupied;

    /**
     * $position is an array of the same lenght as nDim. Construct is used in PutFieldsOnArray;
     * @param array $position 
     */
    public function __construct(array $position)
    {
        $this->position = $position;
    }


    # # # # # # # # # # #
    # Getters & Setters #
    # # # # # # # # # # #
    public function setPosition(array $position)
    {
        #To Do: add dimension check
        $this->position = $position;
    }
    /**
     * Summary of getPosition
     * @return array
     */
    public function getPosition(): array
    {
        return $this->position;
    }
    ########################################################
    /**
     * 
     * @param \model\chess\figures\AnyFigure $piece
     * @return boolean Success
     */
    public function setOccupiedBy(\model\chess\figures\AnyFigure $piece)
    {
        $this->
    }
    public function getOccupiedBy()
    {
        return $this->occupied_by;
    }

    /**
     * @return mixed
     */
    public function isOccupied(): bool
    {
        return $this->is_occupied;
    }
    public function deleteOccupiedBy($figure)
    {

    }
    ##########################################################

    public function getPiecesThatReachMe(): array
    {
        return $this>pieces_that_reach_me;
    }
    public function pushPiecesThatReachMe(\model\chess\figures\AnyFigure $piece, $phase)
    {
        #To Do: check piece for instance of
        $string_position = implode('-',$piece->getPosition());
        $this->pieces_that_reach_me[$string_position] = array($phase => $piece); #Possible error
    }
    public function removePiecesThatReachMe(\model\chess\figures\AnyFigure $piece)
    {
        $string_position = \model\parser\VectorStringTranslation::vectorToString($piece->getPosition());
        unset($this->pieces_that_reach_me[$string_position]);
    }
    ###############################################################

    public function updatePiecesThatReachMe()
    {

    }
}