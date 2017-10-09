<?php
namespace controller\client_action\routing;

const max_uri_depth = 4;

const site_structure = array(
'playchess' => NULL,
'documentation' => array(
'NDimArrays' =>  \view\NDimArray,
'IteratorClasses' => '../view/IteratorClasses.php',
    'BoardFieldPieces' => '../view/BoardFieldPiece.php',
),
);