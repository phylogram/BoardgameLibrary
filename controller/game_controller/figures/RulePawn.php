<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 23.08.2017
 * Time: 11:37
 */

namespace \controller\game_controller\figures\;

/**
 * Class RulePawn
 * only for iteration. Kill $ co .. is the conductor
 * @package model\game\chess\figures
 */
class RulePawn extends \model\game\figures\Rule
{

    public function validate()
    {

        #Unidirectional
        switch ($this->move->figure->getColor()) {
            case 'white':
                if ($this->move->getDirections()[1] != 1) {
                    return false;
                }
                break;
            case 'black':
                if ($this->move->getDirections()[1] != 0) {
                    return false;
                    break;
                }
        }

    }
}