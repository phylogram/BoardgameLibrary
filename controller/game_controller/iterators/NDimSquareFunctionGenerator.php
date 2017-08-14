<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 13.08.2017
 * Time: 11:48
 */

namespace controller\game_controller\iterators;


class NDimSquareFunctionGenerator extends SquareFunctionGenerator
{
    protected $generator_objects = array();
    protected $signatures;
    protected $dimensions;

    /**
     * MultiDimensionalSquareFunctionGenerator constructor
     *     _ _     _ _
     * _ _|   |_ _|
     *    |_ _|   |_ _
     * @param array ...$input as many arrays in the form of [$upper_limit, $lower_limit, int $wavelength, int $phase]
     */
    public function __construct(...$input)
    {
        #To Do: check for errors!
        $this->phase = $input[0][3];
        $this->wavelength = \controller\Math\VectorMath::leastCommonMultipleOfArray(array_column($input, 2));
        $this->signatures = $input;
        $this->dimensions = count($input);
        $this->upper_limit = \controller\Math\VectorMath::columnSum($input, 0); #To Do: This is in some cases wrong, for example wavelength 2 and phase 0/1
        $this->lower_limit = \controller\Math\VectorMath::columnSum($input, 1); #To Do: See upper limit
        foreach ($input as $arguments) {
            $this->generator_objects[] = new parent(...$arguments);
        }
    }

    # # # # # # # # # # #
    # Public Generators #
    # # # # # # # # # # #


    /**
     * calculates value at given phase
     * @param $input_phase int $phase XOR none, which results in current
     * @return array(phase=>array(dimension=>value))
     */
    public function getStateAtPhase($input_phase = 'current'): array
    {

        if ($input_phase == 'current') {
            $input_phase = $this->phase;
        }

        #calculate phase for each generator
        $phases = array();

        #calculate phases for individual generators

        foreach ($this->signatures as $signature) {
            
            $phase_in_first_wavelength = $input_phase % $this->wavelength;
            $sub_generator_wavelength = $signature[2];
            $phase_shift = $signature[3];

            $resulting_phase = ($phase_in_first_wavelength + $phase_shift) % $sub_generator_wavelength;
            $phases[] = $resulting_phase;
        }

        #Afterward we get the values for each SquareFunctionGenerator
        $return_array = array();
        $dim_number = 0;
        foreach (array_combine($phases, $this->generator_objects) as $phase => $object) {
            $state = $object->getStateAtPhase($phase);
            $return_array[$this->phase][$dim_number] = current($state);
            $dim_number ++;
        }

        return $return_array;
    }

    # # # # # # # # # # # #
    # getters and Setters #
    # # # # # # # # # # # #

    public function getSignatures()
    {
        return $this->signatures;
    }
}