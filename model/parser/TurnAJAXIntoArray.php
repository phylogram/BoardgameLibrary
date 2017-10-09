<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 31.08.2017
 * Time: 12:59
 */

namespace model\parser;


class TurnAJAXIntoArray
{
    public static function go(array $input_array): array
    {
        $return_array = array('reclining'=> NULL, 'moving'=> NULL);
        foreach ($input_array as $item) {
            $regex_result = array();
            preg_match('/([a-z]+)\s([a-z]+)_([a-z]+)/', $item['moving_piece'], $regex_result);
            list($throw_me_away, $color, $type, $status) = $regex_result;
            if (!$type[0] === 'k') {
                $type = $type[0];
            } elseif ($type[1] === 'n') {
                $type = 'n';
            } else {
                $type = 'k';
            }
            if ($color === 'white') {
                $type = strtoupper($type);
            }
            $target = \model\parser\RowColumn::chessToArray2D($item['target_field']);
            switch ($status) {
                case 'moving':
                    $return_array['moving'] = array('piece' => $type, 'target' => $target);
                case 'reclining':
                    $return_array['reclining'] = array('piece' => $type, 'target' => $target);
            }
        }
        return $return_array;

    }

}