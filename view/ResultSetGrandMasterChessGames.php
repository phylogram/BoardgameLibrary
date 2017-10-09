<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 31.08.2017
 * Time: 15:10
 */

namespace view;


class ResultSetGrandMasterChessGames
{
    public static function parse(\mysqli_result $result)
    {

        if ($result->num_rows === 0) {
            echo '<p> There is no result</p>';
        } else {
        echo '<table class="pure-table-bordered">';
        $row = $result->fetch_assoc();
        echo '<tr>';
        foreach ($row as $name => $field) {
            if ($name === 'games_index') {
                continue;
            }
            echo '<th>';
            echo $name;

            echo '</th>';
        }
        echo '<th></th>'; #That's where the play button is ...
        echo '</tr>';
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo '<tr style="text-align: center">';
            foreach ($row as $name => $field) {
                if ($name === 'games_index') {
                    $games_index = $field;
                    continue;
                } elseif ($name === 'move nr') {
                    $move_nr = $field;
                }
                echo '<td>';
                echo $field;
                echo '</td>';
            }
            $id = $games_index . '_' . $field;
            echo "<td><a id=\"$id\" class=\"ui-button ui-widget ui-corner-all\ choose_game\" href=\"http://boardgame.dev/Play?gameNumber=$games_index&moveNumber=$move_nr\">Play</a></td>";
            echo '</tr>';
        }
        echo '</table>';


    }
}
}