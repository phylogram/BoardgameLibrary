<?php
namespace model\game\fields;

use model\game\figures\AnyFigure;

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
        $this->is_occupied = false;
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
     * @param array $occupied_by
     */
    public function setOccupiedBy(\model\game\figures\AnyFigure $occupied_by)
    {
        $this->is_occupied = true;
        $this->occupied_by[] = $occupied_by;

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
    public function deleteOccupiedBy($moving_figure)
    {
        $success = false;
        foreach ($this->occupied_by as $key => $reclining_figure) {
            if ($moving_figure === $reclining_figure) {
                unset($this->occupied_by[$key]);
                $success = true;
                break;
            }
        }
        if (count($this->occupied_by) == 0) {
            $this->is_occupied = false;
        }
        return $success;
    }
    ##########################################################

    public function pushPiecesThatReachMe(\model\game\figures\AnyFigure $piece, $phase)
    {
        #To Do: check piece for instance of

        $this->pieces_that_reach_me[] = array($phase => $piece);
    }

    public function deletePieceThatReachMe(\model\game\figures\AnyFigure $piece)
    {
        foreach ($this->pieces_that_reach_me as $key => $reaching_piece) {
            if ($piece === current($reaching_piece)) {
                unset($this->pieces_that_reach_me[$key]);
                $success = true;
                break;
            }
        }
    }

    public function testIfReachMe(\model\game\figures\AnyFigure $asking_piece)
    {
        $can_reach_me = false;
        if (count($this->pieces_that_reach_me) === 0) {
            return $can_reach_me;
        }
        foreach ($this->pieces_that_reach_me as $piece) {
            $can_reach_me = current($piece) === $asking_piece ? true : false;
        }
        return $can_reach_me;
    }

    ###############################################################

    public function updatePiecesThatReachMe()
    {
        foreach ($this->pieces_that_reach_me as $piece) {

            current($piece)->updatePhaseFrom(key($piece));
        }
    }
    public function getPiecesThatReachMe()
    {
        return $this->pieces_that_reach_me;
    }
}