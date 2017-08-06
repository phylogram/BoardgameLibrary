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
'conf'              =>  'conf',
'controller'        =>  'controller',
    'client_action'         =>  'client_action',
        'routing'               => 'routing',
    'game_controller'       =>  'game_controller', #arrays here is the same name as in model\chess\arrays
        'iterators'         =>  'iterators', 
        'Math'            =>  'Math',
    'parser'    => 'parser',
    'SecureAndClean' => 'SecureAndClean',
'errors'     =>  'errors',
'html'              =>  'html',
'model'             =>  'model',
    'chess'                 =>  'chess',
        'arrays'                    => 'arrays',
    'fields'        =>  'fields',
    'parser'        =>  'parser',
'testing'           =>  'testing',
'view'              =>  'view',
);

#Talking to each other

const NEXT = 'next'; #ignore, move on to next issue

#Chess Board size
const CHESS_BOARD_X_Y = array(8,8);