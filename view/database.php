<?php
require_once '..\mogeuge.php';
$database = new mysqli(...$reader);
$grand_master_chess_query = new \database\grandmaster_move_query($database);
$_SESSION['grandmaster_chess_db'] = $grand_master_chess_query;
if ($database->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $database->connect_error;
}
if (!isset($_SESSION['database_query'] )) {
    $_SESSION['database_query'] = array();
}
if (isset($_POST['data'])) {

    if (isset($_POST['data']['required_pieces'])) {
        $return_text = '';
        /*
        foreach ($_POST['data']['required_pieces'] as $name => $piece) {
            $return_text .= $name . ' ' . $piece . ' ';
        }
        echo $return_text;*/
        $single_width = intdiv(300, 8);
        $fig_gen = new \view\FigureGenerator($single_width);
        $data = $_POST['data']['required_pieces'];
        $color = explode(' ', $data['name'])[1];
        $type = explode(' ', $data['name'])[0];
        $color = $color === 'white' ? 0 : 1;
        $name = $data['name'] . '_' . $data['type'];

        echo $fig_gen->get($name, $type, $color);

    } elseif (isset($_POST['data']['required_moves'])) {
        $_SESSION['database_query'][] = $_POST['data']['required_moves'];
        if (count($_SESSION['database_query']) > 2) {
            $_SESSION['database_query'] = array();
            $_SESSION['database_query'][] = $_POST['data']['required_moves'];
        } elseif (count($_SESSION['database_query']) == 2) {
            $database_query = \model\parser\TurnAJAXIntoArray::go($_SESSION['database_query']);
            $database_query = $grand_master_chess_query->queryGameByMovingAndRecliningPieceQuery($database_query);
            \view\ResultSetGrandMasterChessGames::parse($database_query);
        }
    } elseif (isset($_POST['data']['required_game'])) {
        #header to play with new game ...
    }

    } else {
    require_once '..\view\selectBoard.php';
}
