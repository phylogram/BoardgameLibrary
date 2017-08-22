<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 18.08.2017
 * Time: 07:53
 */

namespace controller\game_controller\iterators;


class phase
{
    protected $phase;

    public $values = array();

    public function __construct($phase)
    {
        $this->phase = $phase;
    }


    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    public function set($dimension, $value)
    {
        $this->values[$dimension] = $value;
    }
    public function get($dimension)
    {
        if (isset($this->values[$dimension])) {
            return $this->values[$dimension];
        }
    }
}