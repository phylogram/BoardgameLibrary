<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 13:49
 */

namespace controller\game_controller\figures;


class addCastlingFields
{
    const column_move = array(1=> 2, -1 => -3);
    public function from(\model\game\figures\Move $move)
    {
        return NULL; # To Do: yield style
    }
}