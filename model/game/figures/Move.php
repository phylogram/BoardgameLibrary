<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 11:21
 */

namespace model\game\figures;


class Move
{
    protected $start_position = array();
    protected $target_position = array();

    protected $start_field;
    protected $target_field;

    protected $directions = array();
    protected $move_vector = array();

    public $figure;

    public function __construct(array $start_position, array $target_position)
    {
        #To Do: Check valid dimensions
        $this->start_position = $start_position;
        $this->target_position = $target_position;


    }

    public function getStartPosition()
    {
        return $this->start_position;
    }
    public function getTargetPosition()
    {
        return $this->target_position;
    }

    /**
     * @return mixed
     */
    public function getStartField()
    {
        return $this->start_field;
    }

    /**
     * @return mixed
     */
    public function getTargetField()
    {
        return $this->target_field;
    }

    /**
     * @return array
     */
    public function getDirections(): array
    {
        return $this->directions;
    }

    /**
     * @return array
     */
    public function getMoveVector(): array
    {
        return $this->move_vector;
    }

    /**
     * @return mixed
     */
    public function getFigure(): \model\game\figures\AnyFigure
    {
        return $this->figure;
    }

    /**
     * @param mixed $figure
     */
    public function setFigure(\model\game\figures\AnyFigure $figure)
    {
        $this->figure = $figure;



        $this->start_field = $this->figure->getChessBoard()->selectFromChessboard($this->start_position);
        $this->target_field = $this->figure->getChessBoard()->selectFromChessboard($this->target_position);

        foreach (array_combine($this->start_position, $this->target_position) as $start => $target) {
            $this->directions[] = $target > $start;
            $this->move_vector[] = $target - $start;
        }
    }

}