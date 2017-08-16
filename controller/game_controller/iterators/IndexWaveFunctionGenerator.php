<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 16.08.2017
 * Time: 07:11
 */

namespace controller\game_controller\iterators;


interface IndexWaveFunctionGenerator  extends VectorWaveFunctionGenerator

{
    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
    #                        Positional API                           #
    #   generates/gets absolute values (only positive integers)       #
    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

    public function generateCycleFrom(array $position);

    public function generateWaveFrom(array $position): array;

    public function getStateAtPhaseFrom($input_phase, $position): array;

}