<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 31.08.2017
 * Time: 13:43
 */

namespace database;


class grandmaster_move_query
{

    protected $getGameByMovingAndRecliningPieceQuery = <<<QUERY
SELECT games_index, event, play_date AS 'date', round, white, black, result, mq.moving_number AS 'move nr'
  FROM games 
       INNER JOIN
      (SELECT mp.intern_game_number, mp.move_number AS moving_number, MAX(rp.move_number) AS reclining_number
         FROM moves AS mp
	          JOIN
	         (SELECT intern_game_number, move_number, piece, target_row, target_column
	            FROM moves) AS rp
	          ON mp.intern_game_number = rp.intern_game_number
	    WHERE BINARY mp.piece = (?)
	      AND mp.target_row = (?)
	      AND mp.target_column = (?)
	
	      AND BINARY rp.piece = (?)
	      AND rp.target_row = (?)
	      AND rp.target_column = (?)
	      
	      AND rp.move_number < mp.move_number
 
	 GROUP BY mp.intern_game_number, mp.move_number) AS mq

    ON games_index = mq.intern_game_number
QUERY;
    protected $getGameByMovingAndRecliningPiecePreparedQuery;
    protected $getMovesOfGameUntilMoveNumberQuery;
    protected $database;

    public function __construct(\mysqli $database)
    {
        $this->database = $database;
        $this->database->select_db('grandmaster_chess');
        $this->getGameByMovingAndRecliningPiecePreparedQuery = $this->database->prepare($this->getGameByMovingAndRecliningPieceQuery);

    }

    public function queryGameByMovingAndRecliningPieceQuery(array $array): \mysqli_result
    {
        $moving_piece = $array['moving']['piece'];
        $reclining_piece = $array['reclining']['piece'];

        $moving_target_row = $array['moving']['target'][0];
        $reclining_position_row = $array['reclining']['target'][0];

        $moving_target_column = $array['moving']['target'][1];
        $reclining_position_column = $array['reclining']['target'][1];

        $this->getGameByMovingAndRecliningPiecePreparedQuery->bind_param('siisii',
            $moving_piece,      $moving_target_row,         $moving_target_column,
            $reclining_piece,   $reclining_position_row,    $reclining_position_row
        );

        $this->getGameByMovingAndRecliningPiecePreparedQuery->execute();
        return $this->getGameByMovingAndRecliningPiecePreparedQuery->get_result();
    }


}