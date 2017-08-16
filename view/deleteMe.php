<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 15.08.2017
 * Time: 12:38
 */
require_once ('..\bootstrap\init.php');



$square = new \controller\game_controller\iterators\SquareFunctionGenerator(0, 1, 2, 0, 2);
$n_dim = new \controller\game_controller\iterators\NDimSquareFunctionGenerator([0, 1, 2, 0],[0, 1, 2, 0]);
$triangle = new \controller\game_controller\iterators\TriangleFunctionGenerator([0, 1, 2, 0],[0, 1, 2, 0]);
echo '<hr>';
var_dump($square->generateCycle());
var_dump($square->generateCycleFrom([2]));    #doen't work - set phase to zero and test!
echo '<hr>';
var_dump($square->generateWave()); # set phase to zero
var_dump($square->generateWaveFrom([3]));
echo '<hr>';
var_dump($square->getStateAtPhase());
var_dump($square->getStateAtPhaseFrom(3, [4]));
/**
echo '<hr>';
var_dump($n_dim->generateCycleFrom([5,99]));        #mark dimensions for each generator!
var_dump($n_dim->generateWave([6, 101]));
var_dump($n_dim->getStateAtPhase(3), [8, 202]);
echo '<hr>';
var_dump($triangle->generateCycle(), [-2]);
var_dump($triangle->generateWave(), [-11]);
var_dump($triangle->getStateAtPhase(3)[-25]);
echo '<hr>';
 * **/