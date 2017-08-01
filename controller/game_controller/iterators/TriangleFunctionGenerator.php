<?php
namespace controller\game_controller\iterators;
#To Do: Documentation
class TriangleFunctionGenerator
{
    protected $generator_objects = array();

    public function __construct(...$input)
    {
        #To Do: check for errors!
        foreach ($input as $arguments) {
            $new_generator = new \controller\game_controller\iterators\SquareFunctionGenerator(...$arguments);
            $this->generator_objects[] = $new_generator;
        }
    }
    public function generateWave()
    {
        $array = array();
        foreach ($this->generator_objects as $square) {
            $current = $square->generateWave();
            $array[] =  array_pop($current);
        }
        return array_sum($array);
    }
}