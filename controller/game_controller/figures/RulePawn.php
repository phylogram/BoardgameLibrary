<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 11:37
 */

namespace controller\game_controller\figures;

/**
 * Class RulePawn
 * only for iteration. Kill $ co .. is the conductor
 * @package model\game\chess\figures
 */
class RulePawn extends \model\game\figures\ChessRule
{

    public function validate(\model\game\figures\Move $move)
    {

        #Unidirectional
        switch ($move->figure->getColor()) {
            case 0:
                if ($move->getDirections()[0] != 1) {
                    return false;
                }
                break;
            case 1:
                if ($move->getDirections()[0] != 0) {
                    return false;
                    break;
                }
        }
        return true;

    }
}