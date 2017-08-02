<?php
namespace controller\game_controller\iterators;
#To Do: Documentation
#To Do: Write an trait for this basic iterators
class TriangleFunctionGenerator
{
    protected $generator_objects = array();
    protected $signatures;
    protected $resulting_wavelength;
    protected $phase;

    public function __construct(...$input)
    {
        #To Do: check for errors!
        $this->resulting_wavelength = \controller\Math\VectorMath::leastCommonMultipleOfArray(array_column($input, 2));
        $this->phase = $input[0][3];
        $this->signatures = $input;
        foreach ($input as $arguments) {
            $new_generator = new \controller\game_controller\iterators\SquareFunctionGenerator(...$arguments);
            $this->generator_objects[] = $new_generator;

        }
    }

    public function generateCycle()
    {
        if ($this->phase >= $this->resulting_wavelength) {
            return NULL;
        }
        return $this->cycle();
    }

    public function generateWave(): array
    {
        if ($this->phase == $this->resulting_wavelength) {
            $this->phase = 0;
        }
        return $this->cycle();
    }
    protected function cycle()
    {

        $array = array();
        foreach ($this->generator_objects as $square) {
            $current = $square->generateWave();
            $array[] =  array_pop($current);
        }
        $return_value = array($this->phase => array_sum($array));
        $this->phase ++;
        return $return_value;
    }

    public function getStateAtPhase($input_phase)
    {
        #calucalte phase for each generator
        $phases = array();
        foreach ($this->signatures as $signature) {
            $phases[] = (($this->resulting_wavelength % $input_phase) + $signature[3]) % $signature[2];
        }
        $return_array = array();

        foreach (array_combine($phases, $this->generator_objects) as $phase => $object) {
            $state = $object->getStateAtPhase($phase);

            $return_array += $state;
        }

        return array_sum($return_array);
    }


    public function getResultingWavelength()
    {
        return $this->resulting_wavelength;
    }
}