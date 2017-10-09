<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 26.08.2017
 * Time: 21:09
 */

namespace model\parser;


class RowColumn
{
    static function translate2D(int $row, int $column)
    {
        $row ++;
        $range = range('a', 'z');
        $column = $range[$column];
        return $column . $row;
    }
    static function chessToArray2D(string $field)
    {
        $return_array = array();
        preg_match('/([a-z]+)(\d+)/', $field, $return_array);

        array_shift($return_array);
        $return_array = array_reverse($return_array); #RowColumn to $ColumnsRow

        $return_array[0] --; #From 1, 2, ..., n to 0, 1, ..., n
        $return_array[1] = array_search($return_array[1], range('a', 'z')); #Letter to number

        return $return_array;
    }

    static function getPieceFromFENAndTarget(string $fen, $move, int $row, int $column): string
    {
        if ($move === 'O-O' || $move === 'O-O-O') {
            return $move;
        }

        $board = explode(' ', $fen)[0];
        $row = array_reverse(explode('/', $board))[$row];

        $columns = str_split($row);
        foreach ($columns as $field) {
            $column -= is_numeric($field) ? $field : 1;
            if ($column === -1) {
                return $field;
            }
        }
        return false;

    }

}