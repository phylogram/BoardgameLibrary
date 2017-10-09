<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 26.08.2017
 * Time: 21:51
 */


if (isset($_POST['data'])) {
    if (isset($_POST['data']['possible_moves'])) {
        $return = array();
        $chessboard = $_SESSION['chessboard'];
        $figure = $chessboard->getFigures()[$_POST['data']['possible_moves']];
        foreach ($figure->getFieldsICanReach() as $phase) {
            foreach ($phase as $field) {
                $field = $field->getPosition();
                $field = \model\parser\RowColumn::translate2D(...$field);
                $return[] = $field;
            }
        }
        echo json_encode($return);
    } elseif (isset($_POST['data']['moving_piece'])) {

        $chessboard = $_SESSION['chessboard'];
        $piece = $chessboard->getFigures()[$_POST['data']['moving_piece']];
        $king = $chessboard->getFigures()['king00'];
        $client_start_field = $piece->getPosition();
        $client_start_field = \model\parser\RowColumn::translate2D(...$client_start_field);
        $target = $_POST['data']['target_field'];

        $target = \model\parser\RowColumn::chessToArray2D($target);

        $override = $_POST['data']['override'];
        $move = new \model\game\figures\Move($piece->getPosition(), $target);
        $success = $piece->move($move, $override);

        $new_row = $king->getPosition()[0] > 1 ? $king->getPosition()[0] - 1 : $king->getPosition()[0] +1;
        $new_column = $king->getPosition()[1] > 1 ? $king->getPosition()[1] - 1 : $king->getPosition()[1] + 1;

        $move = new \model\game\figures\Move($king->getPosition(), [$new_row, $new_column]);

        $king->move($move, true);

        $string_position = \model\parser\RowColumn::translate2D($new_row, $new_column);

        echo json_encode(array(
            'success' => $success,
            'computer_moving_piece' => 'king00',
            'computer_target_field' => $string_position,
            'client_start_field' => $client_start_field,
            'client_target_field' => $_POST['data']['target_field'],
            'client_moving_piece' => $_POST['data']['moving_piece']
            ));
        $_SESSION['chessboard'] = $chessboard;
    }


} else {
    session_destroy();
    session_start();
    $chessboard = new \model\game\arrays\ChessBoard();
    $color = 1;
    $name = 'queen10';
    $rule = new \controller\game_controller\figures\ChessRule();
    $addExtraField = new controller\game_controller\figures\addExtraField();
    $queen_signature = new controller\game_controller\iterators\SignatureFigure(array(
        new controller\game_controller\iterators\Signature1Dim(0,1,4,6, 0),
        new controller\game_controller\iterators\Signature1Dim(-1,0,4,7, 1),
    ), 0, 2, 4,  true, 1);
    $king_signature = new controller\game_controller\iterators\SignatureFigure(array(
        new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
        new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
    ), 0, 2, 6,  false, 1);
    $queen = new \model\game\figures\AnyFigure(
        $name, $color, $rule, $addExtraField, $queen_signature
    );
    $king = new \model\game\figures\AnyFigure(
        'king00', 0, $rule, $addExtraField, $king_signature
    );

    $random_1d_sigs = array(
        new \controller\game_controller\iterators\Signature1Dim(rand(-1, 1), rand(-1, 1), rand(1,2)*4, rand(0, 7), 0),
        new \controller\game_controller\iterators\Signature1Dim(rand(-1, 1), rand(-1, 1), rand(1,2)*4, rand(0, 7), 1 )
    );

    if(rand(0, 1)) {
        $random_1d_sigs[] = $random_third = new \controller\game_controller\iterators\Signature1Dim(rand(-1, 1), rand(-1, 1), rand(1,2)*4, rand(0, 7), 3 );
    }

    $random_signature = new \controller\game_controller\iterators\SignatureFigure($random_1d_sigs,
         0, 2, rand(1, 7), rand(0, 1), rand(1, 2));
    $random_piece = new \model\game\figures\AnyFigure('pawn666', 0, $rule, $addExtraField, $random_signature);

    $chessboard->addFigure($king, [1, 1]);

    $chessboard->addFigure($queen, [5, 5]);

    $chessboard->addFigure($random_piece, [3, 3]);





    #$queen->move(
    #    new \model\game\figures\Move([5, 4], [3, 5])
    #);

    $viewer = new \view\ChessBoard($chessboard, 0);

    $viewer->parse();
    $_SESSION['chessboard'] = $chessboard;


}
