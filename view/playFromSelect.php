<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 31.08.2017
 * Time: 16:41
 */

if (!isset($_POST['data']['next'])) {

} else {
    $gameNuber = $_GET['gameNumber'] ?: NULL;
    $moveNumber = $_GET['moveNumber'] ?: NULL;
    $grandmaster_chess_db = $_SESSION['grandmaster_chess_db'] ?: NULL;

    #A new chessBoard from the beginning:

    $board = new \model\game\arrays\ChessBoard();




}
