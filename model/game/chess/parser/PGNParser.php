<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 06.08.2017
 * Time: 15:00
 */

namespace model\chess\parser;

/**
 * Class PGNParser
 * @package controller\parser
 * this is a static one-way only parser
 * it just reads data in and doe not control it
 */
class PGNParser
{
    protected $current_type; # 0 = no content, 1 = tag, 2 = moves, 3 = inline comment (needs regex), -1 = error
    protected $last_type; # --##--
    protected $tags = array(
        'unknown' => '',

        'Event' => NULL, #(the name of the tournament or match event)
        'Site'  => NULL, #(the location of the event)
        'Date'  => NULL, #(the starting date of the event)
        'Round' => NULL, #(the playing round ordinal of the game)
        'White' => NULL, #(the player[s] of the white pieces)
        'Black' => NULL, #(the player[s] of the black pieces)
    );
    protected  $has_error = false;
    protected $moves = array();


    protected $tag_pattern = '/\[\s*?(.+?)\s+?"(.+?)"\s*?\]/';
    /**
     * @param $line of pgn-file.
     * returns directly to database
     */
    public function parse(&$line)
    {
            \controller\SecureAndClean\SecureAndClean::convert($line);
            $this->current_type = self::getType($line);
            if ($this->current_type == 1 && !$this->last_type == 0) {
                return $this->execute();
            }
            switch ($this->current_type) {
                case 1:
                    $this->readTag($line);
                    break;
                case 2:
                    $this->moves = SANParser::
                    break;
                case 3:
                    $this->regEx($line);
                    break;
                case -1:
                    $this->has_error = true;
                    $this->regEx($line);
            }
    }

    public static function getType($line)
    {
        if (empty($line)) {
            return 0;
        }
        $condition = $line[0];
        if ($condition == '[') {
            return 1;
        } elseif (is_numeric($condition)) {
            return 2;
        } elseif ($condition == '{') {
            return 3;
        } else {
            return -1;
        }
    }

    public function execute()
    {
        $return_value = array(
            'tags' => $this->tags,
            'moves' => $this->moves,
            'has_error' => $this->has_error
        );
        $this->has_error = false;
        return $return_value;
    }

    public function readTag(string $string)
    {
        $result = array();
        $success = preg_match($this->tag_pattern, $string, $result);
        $result_length = count($result);
        if (!$success || count($result)!=3) {
            return false; #To Do: Somme error message
        }
        if (array_key_exists($result[1], $this->tags)) {
            $this->tags[$result[1]] = $result[2];
        } else {
            $this->tags['unknown'] .= $result[1] . ': ' .  $result[2] . ' -- ';
        }
    }


        public function getTagPattern()
    {
        return $this->tag_pattern;
    }
        public function setTagPattern($pattern)
    {
        $this->tag_pattern = $pattern;
    }

    public function getTags()
    {
        return $this->tags;
    }



}