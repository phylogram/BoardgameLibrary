<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 31.08.2017
 * Time: 17:38
 */

namespace controller\game_controller\figures;


use model\game\arrays\ChessBoard;

class PieceFactory
{
    protected $move_around_base_sig = array();

    public function __construct()
    {
        $this->move_around_base_sig = array(
            new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
            new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1)
        );
    }

    public function startPositionClassic(ChessBoard $board)
    {

    }
}