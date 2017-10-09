<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 12:10
 */

namespace controller\game_controller\conductor;


class ChessConductor
{
    protected $chess_board;

    public function __construct()
    {
        $this->chess_board = new \model\game\arrays\ChessBoard();
    }

}