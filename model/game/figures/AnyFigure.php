<?php
namespace model\game\figures;

class AnyFigure
{
    protected $position;
    protected $color;
    protected $name;
    protected $iterator_signature;
    protected $iterator;
    protected $chess_board;
    protected $rules;
    protected $add_extra_fields = array();
    protected $fields_i_can_reach;
    protected $phases;

    public function __construct(string $name, int $color, \controller\game_controller\figures\Rule $rule, \controller\game_controller\figures\addExtraField $add_extra_field, \controller\game_controller\iterators\SignatureFigure $iterator_signature)
    {

        $this->color = $color;
        $this->name = $name;
        $this->iterator_signature = $iterator_signature;
        $this->iterator = new \controller\game_controller\iterators\FigureFunctionGenerator($this->iterator_signature, 0);
        $this->rules = $rule; #To Do: add multiple rules that can be combined?! rules object would have to take array of rules?
        $this->add_extra_fields[] = $add_extra_field; #To Do: is a generator!!! To Do: add multiple adds that can be combined?!
        $this->phases = range(0, $iterator_signature->getWavelength() - 1);
        $this->phases[-1] = -1; #here we go for the extra fields
        foreach ( $this->phases as $phase) {
            $this->fields_i_can_reach[$phase] = array();
        }
    }

    public function deleteForPhase($phase)
    {
        foreach ($this->fields_i_can_reach[$phase] as $field) {
            $field->deletePieceThatReachMe($this);
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
        #$this->iterator->reset(); For some reason this does not work if field and start field are the same!
        $this->iterator = new \controller\game_controller\iterators\FigureFunctionGenerator($this->iterator_signature, 0); #so i really reset it!

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
                    $validation = $this->rules->action($this, $field);
                    if ($validation === GO) {
                        $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                        $this->fields_i_can_reach[$selector->getCurrentPhase()][] = $field;
                        continue;
                    } elseif ($validation === STOP_AND_GO) {
                        $this->iterator->next();
                        continue;
                    } elseif ($validation === STOP_THERE_AND_GO) {
                        $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                        $this->fields_i_can_reach[$selector->getCurrentPhase()][] = $field;
                        $this->iterator->next();
                        continue;
                    }
                }
            }
        }
        #Extra fields! Like Castling To Do: Do
        /*
        foreach ($this->add_extra_fields as $field) {
            $field->pushPiecesThatReachMe($this, -1);
            $this->fields_i_can_reach[-1][] = $field;
        }
        */
    }


    public function updatePhaseFrom(int $phase) #Will this work
    {
        $this->deleteForPhase($phase);
        #$this->iterator->reset(); For some reason this does not work if field and start field are the same!
        $this->iterator = new \controller\game_controller\iterators\FigureFunctionGenerator($this->iterator_signature, 0); #so i really reset it!

        if ($phase === -1) {
            /*
            foreach ($this->add_extra_fields as $field) {
                $field->pushPiecesThatReachMe($this, -1);
                $this->fields_i_can_reach[-1][] = $field;
            }
            */
        } else {

            while (true) {

                $selector = $this->iterator->getMoveAtPhaseFrom($phase,$this->position);
                $field = $this->chess_board->selectFromChessBoard($selector->values);
                if (!$field) {
                    break;
                }
                if ($this->rules->validate($this)) {
                    $validation = $this->rules->action($this, $field);
                    if ($validation === GO) {
                        $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                        $this->fields_i_can_reach[$selector->getCurrentPhase()][] = $field;
                        continue;
                    } elseif ($validation === STOP_AND_GO) {
                        break;
                    } elseif ($validation === STOP_THERE_AND_GO) {
                        $field->pushPiecesThatReachMe($this, $selector->getCurrentPhase());
                        $this->fields_i_can_reach[$selector->getCurrentPhase()][] = $field;
                        break;
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
    function move(\model\game\figures\Move $move, $override = false)
    {
        #tell move hello!
        $move->setFigure($this);

        if ($move->getStartPosition() != $this->position) {

            return false;
        } elseif($override == 'false') {

            $reachable = $move->getTargetField()->testIfReachMe($this);

            if (!$reachable) {

                return 'This movement is not possible';
            }
        }


        #delete old references
        $this->deleteAllFields();

        #set position to new

        $this->position = $move->getTargetPosition();
        #leave start position
        $move->getStartField()->deleteOccupiedBy($this);
        #reach start position
        $move->getTargetField()->setOccupiedBy($this);
        $move->getTargetField()->updatePiecesThatReachMe();
        #tell old references to update
        $move->getStartField()->updatePiecesThatReachMe();
        #update possible movements
        $this->updateAll();

        return true;

    }

    /**
     * getIterator
     * returns reference to innerIterator at controller
     * @return callable
     */
    public function getIterator(): \controller\game_controller\iterators\SquareFunctionGenerator
    {
        return $this->iterator;
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
    public function setChessBoard(\model\game\arrays\ChessBoard $chess_board)
    {
        $this->chess_board = $chess_board;
    }
    public function setPosition(array $position)
    {
        $this->position = $position;
    }
    public function getPosition( )
    {
        return $this->position;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getFieldsICanReach() {
        return $this->fields_i_can_reach;
    }

    /**
     * @return array
     */
    public function getPhases(): array
    {
        return $this->phases;
    }
}