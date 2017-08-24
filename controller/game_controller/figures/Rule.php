<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 11:32
 */

namespace model\game\figures;


class Rule
{
    protected $move;
    public function __construct(\model\game\figures\Move $move)
    {
        $this->move = $move;
    }

    public function validate()
    {
        return true;
    }
}