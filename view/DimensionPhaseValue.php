<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 13.08.2017
 * Time: 15:11
 */

namespace view;


class DimensionPhaseValue
{
    /**
     * prints text and bar for one-dimensional $line, $phase, $value-pairs
     * @param $input_array
     * @param $line
     * @param int $resize
     * @return string
     */
    public static function print1D($input_array, $line, $resize = 1)
    {
        if (is_array($input_array)) {
            $phase = key($input_array);
            $value = current($input_array);
            $bar = self::makeBar($value, $resize);
            $value = $value > 0 ? '+' . strval($value) : strval($value);
        } else {
            $phase = $value = 'NULL';
            $bar = '';
        }

        $output_html = <<<OUTPUT_HTML
    <p>
        line: $line | phase: $phase, value: $value $bar    
    </p>
OUTPUT_HTML;
        return $output_html;
    }

    public static function makeBar($value, $resize)
    {
        $start = 10;
        $increase_factor = 4;
        if ($value < 0) {
            $start -= abs($value) * $increase_factor * $resize;
        }
        $width = abs($value) * $increase_factor * $resize;

        $output_html = <<<OUTPUT_HTML
    <span style="display: inline;width:70%;height:1.2em;">
        <span style="background-color:rgba(6,5,20,0.92);color:rgba(243,252,218,0.92);width: {$width}em;margin-left:{$start}em;height:1.2em;text-align:center;display:inline-block">
            $value
        </span>
    </span>
OUTPUT_HTML;
        return $output_html;

    }

    public static function summingUp1D($right_array, $left_array, $line, $resize = 1)
    {
        if (is_array($right_array) && is_array($left_array)) {

            $right_phase = key($right_array);
            $right_value = current(current($right_array));

            $left_phase = key($left_array);
            $left_value = current(current($left_array));

            $sum = $right_value + $left_value;

            $bar = self::makeBar($sum, $resize);
            $sum = $sum > 0 ? '+' . strval($sum) : strval($sum);
        } else {
            $left_value = $right_value = $left_phase = $right_phase = 'NULL';
            $bar = '';
        }

        $output_html = <<<OUTPUT_HTML
    <p>
        line: $line | left phase: $left_phase, left value: $left_value; right phase: $right_phase, right value: $right_value $bar    
    </p>
OUTPUT_HTML;
        return $output_html;

    }

    public static function print2D($input_array, $line)
    {
        if (is_array($input_array)) {
            $phase = key($input_array);
            $values = implode('|', current($input_array));
        } else {
            $phase = $values = 'NULL';
        }
        $output_html = <<<OUTPUT_HTML
    <p>
        line: $line | phase: $phase, value: ($values)   
    </p>
OUTPUT_HTML;
        return $output_html;
    }

    public  static function printZeroOf2D($input_array, $line, $resize = 1)
    {
        if (is_array($input_array)) {
            $phase = key($input_array);
            $value = current($input_array[$phase]);
            $bar = self::makeBar($value, $resize);
            $value = $value > 0 ? '+' . strval($value) : strval($value);
        } else {
            $phase = $value = 'NULL';
            $bar = '';
        }

        $output_html = <<<OUTPUT_HTML
    <p>
        line: $line | phase: $phase, value: $value $bar    
    </p>
OUTPUT_HTML;
        return $output_html;
    }
}