<?php
namespace model\chess\fields;

class GameField
{
    protected $position = array(); #Position in array (chessboard)
    protected $occupied_by; #reference to object = piece
    protected $pieces_that_reach_me = array(); #reference to pieces, that move to field

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
     * @param \model\chess\figures\AbstractFigure $piece 
     * @return boolean Success
     */
    public function setOccupiedBy(\model\chess\figures\AbstractFigure &$piece): bool
    {
        if ($piece->getColor() == $this->occupied_by->getColor()) {
            return false; #To Do: Error Message
        }
        $this->occupied_by &= $piece; #Possible error
        return true;
    }
    public function getOccupiedBy()
    {
        return $this->occupied_by;
    }
    ##########################################################

    public function getPiecesThatReachMe(): array
    {
        return $this>pieces_that_reach_me;
    }
    public function pushPiecesThatReachMe(\model\chess\figures\AbstractFigure &$piece, $phase)
    {
        #To Do: check piece for instance of
        $string_position = implode('-',$piece->getPosition());
        $this->pieces_that_reach_me[$string_position] = array($phase => $piece); #Possible error
    }
    public function removePiecesThatReachMe(\model\chess\figures\AbstractFigure &$piece)
    {
        $string_position = \model\parser\VectorStringTranslation::vectorToString($piece->getPosition());
        unset($this->pieces_that_reach_me[$string_position]);
    }
    ###############################################################
}