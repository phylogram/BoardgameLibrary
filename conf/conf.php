<?php


#error Level
/**
 * Global const: ERROR_BAD
 * See http://php.net/manual/en/errorfunc.constants.php
 *
 * if 512 ERROR_BAD will only show a warning
 * if 256 will exit
 */
const ERROR_BAD     =       512;
const ERROR_NOTICE  =       512;



#Maxiumum dimensions allowed
const MAX_DIM = 6;
const MAX_V = 16;

#Folders

/**
 * If we have to change namespace - folder relations 
 */
const NAMESPACE_FOLDER_RELATION = array(
'bootstrap'         =>  'bootstrap',
'chessParser_master' => 'chessParser_master',
'conf'              =>  'conf',
'controller'        =>  'controller',
    'client_action'         =>  'client_action',
        'routing'               => 'routing',
    'game_controller'       =>  'game_controller', #arrays here is the same name as in model\game\arrays
        'iterators'         =>  'iterators',
            'signatures'        => 'signatures',
        'figures'               => 'figures',
        'Math'            =>  'Math',
    'parser'    => 'parser',
    'SecureAndClean' => 'SecureAndClean',
'errors'     =>  'errors',
'html'              =>  'html',
'model'             =>  'model',
    'game'                 =>  'game',
        'arrays'                    => 'arrays',
    'fields'        =>  'fields',
    'chess'         =>  'chess',
    'parser'        =>  'parser',
'database'           =>  'database',
'view'              =>  'view',
);

#Talking to each other


const NEXT = 'next'; #ignore, move on to next issue

#Pieces Iteration
const STOP = 0; #stop all, do nothing
const GO = 1; #Do and go on
const STOP_THERE = 2; #stop all, but mark
const STOP_AND_GO = 3; #stop in phase, do nothing, and continue next phase
const STOP_THERE_AND_GO = 4; #stop in phase, mark and continue next phase
const SKIP = 5; #Pass and go
#Chess Board size
const CHESS_BOARD_X_Y = array(8,8);

