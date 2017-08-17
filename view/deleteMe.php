<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 15.08.2017
 * Time: 12:38
 */
require_once ('..\bootstrap\init.php');

echo 'three' + 3;

$square = new \controller\game_controller\iterators\SquareFunctionGenerator(0, 1, 2, 0, 2, $another = 4);
$n_dim = new \controller\game_controller\iterators\NDimSquareFunctionGenerator([0, 1, 2, 0],[0, 1, 2, 0]);
$triangle = new \controller\game_controller\iterators\TriangleFunctionGenerator([0, 1, 2, 0],[0, 1, 2, 0]);
echo '<hr>';
var_dump($square->generateCycle());
$square->setPhase(1);
var_dump($square->generateCycleFrom([3]));
$square->setPhase(0);
echo '<hr>';
var_dump($square->generateWave()); #
$square->setPhase(0);
var_dump($square->generateWaveFrom([3]));
$square->setPhase(0);
echo '<hr>';
var_dump($square->getStateAtPhase(3));
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