<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 29.08.2017
 * Time: 12:47
 */

namespace controller\parser;


use Couchbase\Exception;
use model\parser\RowColumn;

class ParsePGNIntoDatabase
{
    protected $database;
    protected $file_pointer;
    protected $status = 0; #true: tags, false: moves

    protected $line = 0;
    protected $game = 0;
    protected $id;
    protected $current_string = '';

    protected $prepared_statement_game;
    protected $prepared_statement_metadata;
    protected $prepared_statement_move;

    protected $external_parser;

    public function __construct(string $path, \mysqli $database)
    {
        $this->database = $database;
        $this->database->autocommit(false);
        $this->file_pointer = fopen($path, 'r');

        $this->prepared_statement_game = $this->database->prepare(
            'INSERT INTO grandmaster_chess.games (event, site, play_date, round, white, black, eco, result) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $this->prepared_statement_metadata = $this->database->prepare(
            'INSERT INTO grandmaster_chess.metadata (intern_game_number, tag, content) VALUES (?, ?, ?)'
        );
        $this->prepared_statement_move = $this->database->prepare(
            'INSERT INTO grandmaster_chess.moves (intern_game_number, move_number, piece, start_row, start_column, target_row, target_column, commentary, fen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );


        $this->external_parser = new \PgnParser();
        echo 'construct: ', date('H:i:s'), '<br>';
        flush();
    }

    public function execute()
    {

        while (($current_line = fgets($this->file_pointer)) !== false) {

            $current_line = trim($current_line);
            if ($current_line === '') {
                continue;
            }
            $first_character_type = $current_line[0] === '[';
            $parse = false;
            if ($this->status === 0 && $first_character_type) {
                $parse = false;
                $this->status = 1;
            } elseif ($this->status === 1 && $first_character_type) {
                $parse = false;
                $this->status = 1;
            } elseif ($this->status === 1 && !$first_character_type) {
                $parse = false;
                $this->status = 2;
            }   elseif ($this->status === 2 && $first_character_type) {
                $parse = true;
                $this->status = 1;
            } elseif ($this->status === 2 && !$first_character_type) {
                $parse = false;
            }
            else {
                echo "?? ", $this->status, ' ', $first_character_type, ' ', $current_line[0] , '</br>';
            }


            #$this->status = $first_character_type && $this->status ? true : false; #if a [-line follows a [-line we are in one game, else a new game starts
            #echo $first_character_type ?: 'x', ' ', $this->status ?: 'y', ' ',$this->game ?: 'z','<br>';

            if ($parse) {
                $failure = $this->parse();
                if (!$failure) {
                    echo 'error1 ', $this->database->errno, '<br>';
                    echo 'at: ', date('H:i:s'), '<br>';
                    flush();
                    return $failure;
                }

                $this->current_string = '';
                $this->game ++;
                if ($this->game % 100 == 0) {

                    if ($this->game % 500 == 0) {
                        echo 'Parsed Game ', $this->game, ' successfully<br>';
                        echo 'execute: ', date('H:i:s'), '<br>';
                        flush();
                        sleep(0.1);
                    }

                }
            }

            $this->current_string .= $current_line;
            $this->line ++;

        }
    }

    protected function parse()
    {

        $this->external_parser = new \PgnParser();

        try {
            $this->external_parser->setPgnContent($this->current_string);
            $parsed_array = $this->external_parser->getFirstGame();
        } catch (Exception $e) {
            var_dump($e);
        }

        if (isset($parsed_array)) {
            $this->database->begin_transaction();
            $game = $this->parseGame($parsed_array);
            $meta_data = $this->parseMetaData($parsed_array['metadata']);

            $moves = $this->parseMoves($parsed_array['moves']);


            if (!$game || !$meta_data || !$moves) {
                $message = "error2 at game {$this->game} and line {$this->line} <br>";
                echo $message;
                $this->database->rollback();
                return false;
            }
            $this->database->commit();
        }
        return true;

    }

    protected function parseGame(array $parsed_array): bool
    {
        #(event, site, play_date, round, white, black, eco, result)

        $event = array_key_exists('event', $parsed_array) ? $parsed_array['event'] : '';
        $site = array_key_exists('site', $parsed_array) ? $parsed_array['site'] : '';


        $play_date = array_key_exists('date', $parsed_array)
            ? implode('-', explode('.', $parsed_array['date']))
            : '';

        $round = array_key_exists('round', $parsed_array) ? $parsed_array['round'] : '';
        $white = array_key_exists('white', $parsed_array) ? $parsed_array['white'] : '';
        $black = array_key_exists('black', $parsed_array) ? $parsed_array['black'] : '';
        $eco = array_key_exists('eco', $parsed_array) ? $parsed_array['eco'] : '';
        $result = array_key_exists('result', $parsed_array) ? $parsed_array['result'] : '';

        $this->prepared_statement_game->bind_param('ssssssss',
            $event, $site, $play_date, $round, $white, $black, $eco, $result);

        $outcome = $this->prepared_statement_game->execute();
        if (!$outcome) {
            echo 'error3 ', $this->prepared_statement_game->errno, '<br>';
            echo implode(', ', array($event, $site, $play_date, $round, $white, $black, $eco, $result)), '<br>';
            flush();
            return false;
        }

        $this->id = $this->prepared_statement_game->insert_id;

        return true;
    }

    protected function parseMetaData(array $parsed_array): bool
    {
        foreach ($parsed_array as $tag => $content) {
            $this->prepared_statement_metadata->bind_param('iss',$this->id, $tag, $content);
            $outcome = $this->prepared_statement_metadata->execute();
            if (!$outcome) {
                return false;
            }
        }
        return true;
    }
    protected function parseMoves(array $parsed_moves): bool
    {
        #(intern_game_number, move_number, piece, start_row, start_column, target_row, target_column, commentary, fen)
        foreach ($parsed_moves as $move_number => $move) {
            if (!isset($move['from'])) {
                return false;
            }
            list($start_row, $start_column) = \model\parser\RowColumn::chessToArray2D($move['from']);
            list($target_row, $target_column) = \model\parser\RowColumn::chessToArray2D($move['to']);
            $fen = $move['fen'];
            $comment = array_key_exists('comment', $move) ? $move['comment']: '';

            $piece = \model\parser\RowColumn::getPieceFromFENAndTarget($fen, $move['m'], $target_row, $target_column);

            $this->prepared_statement_move->bind_param('iisiiiiss',
                $this->id, $move_number, $piece, $start_row, $start_column, $target_row, $target_column, $comment, $fen
            );

            $outcome = $this->prepared_statement_move->execute();
            if (!$outcome) {
                echo 'error4 ', $this->prepared_statement_move->errno, '<br>';
                echo implode(', ', array($this->id, $move_number, $piece, $start_row, $start_column, $target_row, $target_column, $comment, $fen)), '<br>';
                flush();
                return false;
            }
        }
        return true;
    }

    /**
     * @return int
     */
    public function getGame(): int
    {
        return $this->game;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }


}