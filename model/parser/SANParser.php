<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 09.08.2017
 * Time: 12:34
 */

namespace model\chess\parser;


class SANParser
{
    /**
     * @param string $string line of moves
     * this class can not handle ... black moves
     */
    public $move_number_pattern = "(?'move_number'\d+?)\.\s+?"; #one or more digits (as a group) followed by a period and one ore more white spaces
    public $figures_pattern = "(?'figure'[RNBQKP]{0,1})"; #figures are represented one of this upper case letters, but do not have to be stated

    public $pattern;

    public function __construct()
    {
        $this->pattern = "{$this->move_number_pattern}(?'move'{$this->figures_pattern}(?'source_column'[a-h]{0,1})(?'source_row'[1-8]{0,1})(?'kill'x{0,1})(?'target_column'[a-h]{1})(?'target_row'[1-8]{1})(?'check'\+{0,2})\s+?|(?'kingside_castling'O-O\s+?)|(?'queenside_castling'O-O-O\s+?)){1,2}";
    }


    public static function readMove(string $string)
    {
        $tokens = explode(' ',  $string); #tokens are delimited by whitespace

    }
}