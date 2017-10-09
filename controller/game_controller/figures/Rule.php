<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 11:32
 */

namespace controller\game_controller\figures;

class Rule
{
    const STOP = 0; #stop immediately
    const GO = 1; # mark and go on
    const SKIP = 2; #Skip but go on (jump)
    const STOP_THERE = 3; #mark but stop (can kill)


    public static function validate($figure)
    {
        return true;
    }
    public static function action($figure, $field)
    {
        return GO;
    }
}