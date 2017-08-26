<?php
namespace model\chess\figures;

abstract class AbstractFigure
{
    protected $position;
    protected $color;
    protected $name;
    protected $iterator_signature;
    protected $iterator;
    protected $chess_board;
    protected $rules = array();
    protected $add_extra_fields = array();
    protected $fields_i_can_reach; #To Do
    protected $phases;

    public function __construct(array $position, str $name, int $color, \model\game\arrays\ChessBoard $chess_board, \controller\game_controller\figures\Rule $rule, \controller\game_controller\figures\addExtraField $add_extra_field, \controller\game_controller\iterators\SignatureFigure $iterator_signature, int $phases)
    {
        $this->position = $position;
        $this->color = $color;
        $this->name = $name;
        $this->chess_board = $chess_board;
        $this->iterator_signature = $iterator_signature;
        $this->iterator = new \controller\game_controller\iterators\FigureFunctionGenerator($iterator_signature, 0);
        $this->rules[] = $rule; #To Do: add multiple rules that can be combined?!
        $this->add_extra_fields[] = $add_extra_field; #To Do: is a generator!!! To Do: add multiple adds that can be combined?!
        $this->phases = range(0, $this->phases);
        $this->phases[-1] = -1; #here we go for the extra fields
        foreach ( $this->phases as $phase) {
            $this->fields_i_can_reach[$phases] = array();
        }
    }

    public function deleteForPhase($phase)
    {
        foreach ($this->fields_i_can_reach[$phase] as $field) {
            $field->removePiecesThatReachMe($this);
        }
        $this->fields_i_can_reach[$phase] = array();
    }

    public function deleteAllFields()
    {
        foreach ($this->phases as $phase) {
            $this->deleteForPhase($phase);
        }
    }
    public function updateAll()
    {
        $this->deleteAllFields();
        $this->iterator->reset();

        while (true) {

            $selector = $this->iterator->generateCycleFrom($this->position);
            if (!$selector) {
                #If the cycle ends, $selector is NULL
                break;
            }
            $field = $this->chess_board->selectFromChessBoard($selector->values);
            if (!$field) {
                #If there is no field, we have to move to next phase
                $this->iterator->next();
            } else {
                if ($this->rules->validate($this)) {
                    switch ($this->rules->action($this)) {
                        case 0:
                            break 2; #stop update phase
                        case 1:
                            $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                            $this->fields_i_can_reach[$selector->getCurrentPhase()] = $field;
                            break; # Go on
                        case 2:
                            continue 2; #skip but go on
                        case 3:
                            $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                            $this->fields_i_can_reach[$selector->getCurrentPhase()] = $field;
                            break 2; # mark but break (for example contrary color
                    }
                }
            }
        }
        #Extra fields! Like Castling
        foreach ($this->add_extra_fields as $field) {
            $field->pushPiecesThatReachMe($this, -1);
            $this->fields_i_can_reach[-1] = $field;
        }

    }


    public function updatePhaseFrom(int $phase, int $position = 0) #Will this work
    {
        $this->deleteForPhase($phase);
        $this->iterator->reset();

        if ($phase === -1) {
            foreach ($this->add_extra_fields as $field) {
                $field->pushPiecesThatReachMe($this, -1);
                $this->fields_i_can_reach[-1] = $field;
            }
        } else {
            $position = $position === 0 ? $this->position : $position;

            $has_reached_position = false;
            while (true) {
                $selector = $this->iterator->generateMoveAtPhaseFrom($this->position);
                if ($selector === $position) {
                    $has_reached_position = true;
                }
                if ($has_reached_position) {
                    $field = $this->chess_board->selectFromChessBoard($selector);
                    if (!$field) {
                        break;
                    }
                    if ($this->rules->validate($this)) {

                        switch ($this->rules->action($this)) {
                            case 0:
                                break 2; #stop update phase
                            case 1:
                                $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                                $this->fields_i_can_reach[$selector->getCurrentPhase()] = $field;
                                break; # Go on
                            case 2:
                                continue 2; #skip but go on
                            case 3:
                                $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                                $this->fields_i_can_reach[$selector->getCurrentPhase()] = $field;
                                break 2; # mark but break (for example contrary color
                        }
                    }
                }
            }
        }


    }



    public function getKilled()
    {
        #Clean up before death
        $this->deleteAllFields();
        $this->chess_board->selectFromChessBoard($this->position)->deleteOccupiedBy($this);
        $this->position = false; #position false: that's heaven
    }

    /**
     * sets position $old to $new
     * and does some basic "piece inherit" logic
     * 1. n_dim?
     * 2. is $vector possible for piece "anywhere"
     * @param array $vector
     * @return bool $success
     */
    function move(\model\game\figures\Move $move)
    {
        if ($move->getStartPosition() != $this->position) {
            var_dump("shit"); #To Do: error
            return false;
        }

        #delete old references
        $this->deleteAllFields();
        #tell old references to update
        $move->getStartField()->updatePiecesThatReachMe();
        #set position to new
        $this->position = $move->getTargetPosition();
        #leave start position
        $move->getStartField()->deleteOccupiedBy($this);
        #reach start position
        $move->getTargetField()->setOccupiedBy($this);
        #update possible movements
        $this->updateAll();

    }

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

    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getChessBoard()
    {
        return $this->chess_board;
    }

    
}