<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 26.08.2017
 * Time: 20:18
 */

namespace view;


class ChessBoard
{
    protected $chess_board;
    protected $dim0;
    protected $dim1;

    public function __construct(\model\game\arrays\ChessBoard $chess_board, $color)
    {
        $this->chess_board = $chess_board;
        $this->dim0 = $chess_board->getPosVector()[0];
        $this->dim1 = $chess_board->getPosVector()[1];
        $this->range0 = $color === 0 ? range($this->dim0, 0) : range(0, $this->dim0);
        $this->range1 = $color === 0 ? range(0, $this->dim1) : range($this->dim1, 0);
    }

    public function parse()
    {

        echo <<<OUTPUT
<script type="text/javascript" src="../view/ChessBoard.js"></script>
<article class="pure-u-14-24" id="doc_IteratorClasses" style="margin-left: 3%; margin-top: 4%;">


OUTPUT;


        $width = 600;
        $single_width = intdiv(400, 8);
        $fig_gen = new \view\FigureGenerator($single_width);

        echo "<table style='width: {$width}px; height: {$width}px; border: 1px solid black; table-layout: fixed'>";
        $i = 0;

        foreach ($this->range0 as $dim0) {
            echo '<tr>';
            foreach ($this->range1 as $dim1) {
                $id = \model\parser\RowColumn::translate2D($dim0, $dim1);
                $field = $this->chess_board->selectFromChessBoard([$dim0, $dim1]);
                $bg1 = '#999';
                $bg2 = '#fff';
                $background_color = $i % 2 == 0 ? $bg1 : $bg2;
                $i++;
                echo "<td class='$background_color' id='$id' style='text-align:center; vertical-align:middle;height: {$single_width}px; width: {$single_width}px; background-color: $background_color; table-layout: fixed'>";

                if ($field->isOccupied()) {
                    $figure = current($field->getOccupiedBy());
                    $color = $figure->getColor();
                    $name = $figure->getName();
                    $type = array();
                    preg_match('/([a-z]+)([\d]+)/', $name, $type);
                    $type = $type[1];
                    echo $fig_gen->get($name, $type, $color);
                } else {
                    echo $id;
                }

                echo '</td>';
            }
            echo '</tr>';
            if ($this->dim0% 2 === 1) {
                $i++;
            }
        }
        echo <<<ALERT
</table>
</article>
<div class="pure-u-8-24 alert" id="alert">
Hallo
</div>
</div>

ALERT;




    }
}