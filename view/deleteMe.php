<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 15.08.2017
 * Time: 12:38
 */
require_once ('..\bootstrap\init.php');

$test_array_a = array(2=>3, 7 => -1);
$test_array_b = array(0=>3, 1 => -1);

$sum_array = \controller\Math\VectorMath::addVector($test_array_a, $test_array_b);

var_dump($sum_array);

$square = new \controller\game_controller\iterators\SquareFunctionGenerator(0, 1, 2);
$n_dim = new \controller\game_controller\iterators\NDimSquareFunctionGenerator([0, 1, 2, 0],[0, 1, 2, 0]);
$triangle = new \controller\game_controller\iterators\TriangleFunctionGenerator([0, 1, 2, 0],[0, 1, 2, 0]);
echo '<hr>';
var_dump($square->generateCycle());
var_dump($square->generateWave());
var_dump($square->getStateAtPhase(3));
echo '<hr>';
var_dump($n_dim->generateCycle());
var_dump($n_dim->generateWave());
var_dump($n_dim->getStateAtPhase(3));
echo '<hr>';
var_dump($triangle->generateCycle());
var_dump($triangle->generateWave());
var_dump($triangle->getStateAtPhase(3));
echo '<hr>';