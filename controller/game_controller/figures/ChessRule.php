<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 24.08.2017
 * Time: 12:50
 */

namespace controller\game_controller\figures;


class ChessRule extends \controller\game_controller\figures\Rule
{
    public static function action($figure, $field)
    {
        switch ($field->isOccupied()) {
            case false:
                return GO;
                break;
            case true:
                switch ($figure->getColor() == current($field->getOccupiedBy())->getColor()) {
                    case true:
                        return STOP_AND_GO;
                        break;
                    case false:
                        return STOP_THERE_AND_GO;
                        break;
                }
        }
    }
}