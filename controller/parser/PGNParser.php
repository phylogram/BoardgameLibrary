<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 06.08.2017
 * Time: 15:00
 */

namespace controller\parser;

/**
 * Class PGNParser
 * @package controller\parser
 * this is a static one-way only parser
 */
class PGNParser
{

    protected $current_type; # 0 = no content, 1 = tag, 2 = moves, 3 = inline comment (needs regex), -1 = error
    protected $last_type; # --##--
    protected $tags = array(
        'unknown' => '',
    );
    protected  $has_error = false;
    protected $moves = array();
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
                    $this->readMoves($line);
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

    public function readTag(str $string)
    {
        $result = preg_match('/\[(.+?) ".*?(.+?)".*?\]/', $string);
        if (!$result || count($result)!=2) {
            return false; #To Do: Somme error message
        }
        if (array_key_exists($result[0], $this->tags)) {
            $this->tags[$result[0]] = $result[1];
        } else {
            $this->tags['unknown'] .= ' -- ' . result[1];
        }
    }


}