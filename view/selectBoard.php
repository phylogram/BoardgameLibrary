<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 30.08.2017
 * Time: 13:18
 */

echo <<<OUTPUT
<div class="pure-u-8-24" id="doc_IteratorClasses" style="margin-left: 3%; margin-top: 4%; border: 1px black solid;">

<script type="text/javascript" src="board_select.js"></script>

OUTPUT;

$width = 400;
$single_width = intdiv(380, 8);
$fig_gen = new \view\FigureGenerator($single_width);

echo "<table style='width: {$width}px; height: {$width}px; table-layout: fixed; display: inline-block'>";
$i = 0;
$bg1 = '#999';
$bg2 = '#fff';
foreach (range(7, 0) as $dim0) {
    echo '<tr>';
    foreach (range(0, 7) as $dim1) {
        $id = \model\parser\RowColumn::translate2D($dim1, $dim0);
        $background_color = $i % 2 == 0 ? $bg1 : $bg2;
        $i++;
        echo "<td class='$background_color' id='$id' style='text-align:center; vertical-align:middle;height: {$single_width}px; width: {$single_width}px; background-color: $background_color; table-layout: fixed'>";
        echo $id;

        echo '</td>';
    }
    echo '</tr>';
    if (7 % 2 === 1) {
        $i++;
    }
}

echo <<<INFO
    </table>
    <div id="pieceboard" style="width: 300px; height: 15px; float:  right; vertical-align: top; display: inline"></div>
    </article>
</div>

<div id="chooseANDresult" class="pure-u-8-24" style="margin-left: 3%; margin-top: 4%; float: left"><div class="pure-u-1-5"></div>
    </article>
    <div class="ui-widget">
  <label for="tags1">Moving Piece: </label>
  <input id="tags1">
</div>
<div class="ui-widget">
  <label for="tags2">Reclining Piece: </label>
  <input id="tags2">
</div></div>

</div>

INFO;
