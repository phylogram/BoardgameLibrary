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
     * @param array $signatures as many arrays in the form of [$upper_limit, $lower_limit, int $wavelength, int $phase[, $dim = 0, 1, ... ]]
     * @param array $dimension = 0
     */
    public function __construct(\controller\game_controller\iterators\SignatureNDim $signatures, $dimension = 0)
    {
        #To Do: check for errors! each array len = 4
        $this->dim = $dimension;
        $this->phase = $signatures->getPhase();
        $this->timer = 0;

        $this->signatures = $signatures->signatures;
        $this->wavelength = $signatures->getWavelength();
        $this->half_wavelength = $signatures->getHalfWavelength();

        $this->dimensions = $signatures->getSubDimensions();
        $this->upper_limit = $signatures->getUpperLimit();
        $this->lower_limit = $signatures->getLowerLimit();
        
        foreach ($this->signatures as $signature) {
                $this->generator_objects[$signature->dim] = new \controller\game_controller\iterators\SquareFunctionGenerator($signature);
        }

        $this->current_phase = new \controller\game_controller\iterators\phase($this->phase);
    }

    # # # # # # # # # # #
    # Public Generators #
    # # # # # # # # # # #


    /**
     * calculates value at given phase
     * @param $input_phase int $phase XOR none, which results in current
     * @return array|phase
     */
    public function getStateAtPhase($input_phase = 'current'): \controller\game_controller\iterators\phase
    {

        if ($input_phase === 'current') {
            $input_phase = $this->phase;
        }
        $this->current_phase->setCurrentPhase($this->phase);
        #calculate phases for individual generators
        $phases = array();

        foreach ($this->signatures as $signature) {
            
            $phase_in_first_wavelength = $input_phase % $this->wavelength;
            $sub_generator_wavelength = $signature->wavelength;
            $phase_shift = $signature->phase;

            $resulting_phase = ($phase_in_first_wavelength + $phase_shift) % $sub_generator_wavelength;
            $phases[$signature->dim] = $resulting_phase;
        }
        #Afterward we get the values for each SquareFunctionGenerator


        foreach (array_combine($phases, $this->generator_objects) as $phase => $object) {

            $state = $object->getStateAtPhase($phase);

            $this->current_phase->set(  $object->getDim(),
                                        current($state->values)
                );

        }

        return $this->current_phase;
    }

    # # # # # # # # # # # #
    # getters and Setters #
    # # # # # # # # # # # #

    public function getSignatures()
    {
        return $this->signatures;
    }
}