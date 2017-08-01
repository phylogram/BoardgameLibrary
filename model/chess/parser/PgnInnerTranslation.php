<?php
namespace model\chess\parser;
class PgnInnerTranslation
{
    protected $lower_case_letter;
    protected const UPPER_CASE_LETTER = array(
            'P' =>  'Pawn',     #Bauer
            'N' =>  'Knight',   #Turm
            'B' =>  'Bishop',   #Läufer
            'R' =>  'Rook',     #Springer
            'Q' =>  'Queen'    #Dame
        );


    public function __construct()
    {
        $lower_case_letter = array_flip(range('a', 'h')); # column into numbers #If declare $lower_case_letter as static, does it have to be computet every time it is asked for?
    }


    public function getTranslation(str $betweenNumbers)
    {
        if (substr($betweenNumbers,0,1) == '%') { # "Private" commentary www.saremba.de/chessgml/standards/pgn/pgn-complete.htm#c6
            return NEXT;
        }
        list($information, $commentary) = $this->splitCommentary($betweenNumbers);
        #list($new_row, $new_column, $figure, $type, $action)
    }

    /**
     * split_commentary
     * splits commentary and move to list
     * http://www.saremba.de/chessgml/standards/pgn/pgn-complete.htm#c5
     * only for {} commentary - ; has to be dealt at line level
     *
     * @param str $string
     */
    protected function splitCommentary(str $string)
    {
        #To Do: is only valid for (non_commentary)(commentary)
        $non_commentary = '(.+)';
        $commentary = '\{(.+)\}';
        return preg_split('/' . $non_commentary . $commentary . '/' , $string);
    }

}