<?php
namespace controller\game_controller\iterators;

class SquareFunctionGenerator implements IndexWaveFunctionGenerator
{
    # # # # # # # # # # # # # # # # # # # # # #
    #   _   _   _   _   _   _   _   _   _   _ #
    # _| |_| |_| |_| |_| |_| |_| |_| |_| |_|  #
    #                                         #
    # # # # # # # # # # # # # # # # # # # # # #


    protected $dim; #The dimension

    protected $upper_limit;     #The upper value
    protected $lower_limit;     #The lower value
    protected $wavelength;  # f.e. 4:
    #     _ _     _ _
    # _ _|   |_ _|   |_ _
    protected $half_wavelength;
    protected $phase; #where are we in the cycle: can't be bigger wavelength
    protected $timer;


    /**
     * Summary of __construct
     *   _   _   _
     * _| |_| |_|
     * @param $upper_limit #The upper value
     * @param $lower_limit #The lower value
     * @param int $wavelength # for example 4 must be even!
     *
     *     _ _     _ _
     * _ _|   |_ _|
     * @param int $phase #where are we in the cycle: can't be bigger than wavelength, can't be smaller than 2
     * @return boolean #false if fails
     */
    public function __construct(\controller\game_controller\iterators\Signature1Dim $signature)
    {
        $this->dim = $signature->dim;
        $this->upper_limit = $signature->upper_limit;
        $this->lower_limit = $signature->lower_limit;

        $this->checkWaveLength($signature->wavelength);
        $this->wavelength = $signature->wavelength;
        $this->half_wavelength =$signature->half_wavelength;

        $this->checkPhase($signature->phase);
        $this->phase = $signature->phase;
        $this->timer = 0;
    }

    # # # # # # # # # # # # # # # #
    # Public Relative Generators  #
    # # # # # # # # # # # # # # # #

    /**
     * generates on cycle, afterwards only NULL
     * @return \integer|null
     */
    public function generateCycle()
    {
        if ($this->timer >= $this->wavelength) {
            return NULL;
        }
        return $this->cycle();
    }

    /**
     * generates endless wave
     * @return mixed
     */
    public function generateWave(): array
    {

        if ($this->phase == $this->wavelength) {
            $this->phase = 0;
        }
        return $this->cycle();
    }
    /**
     * gets value at state
     * @return array [$phase => $value]
     * @param $input_phase int or 'current'
     */
    public function getStateAtPhase($input_phase = 'current'): array
    {
        if ($input_phase === 'current') {
            
            $input_phase = $this->phase;
        }
        switch (($input_phase % $this->wavelength) < $this->half_wavelength) {
            case true:

                return array($input_phase => array(
                    $this->dim => $this->upper_limit)
                );
                break;

            case false:

                return array($input_phase => array(
                    $this->dim => $this->lower_limit)
                );
                break;
        }
    }
    # # # # # # # # # # # # # # # #
    # Public positional generator #
    # # # # # # # # # # # # # # # #

    public function generateCycleFrom(array $position)
    {
        $vector = $this->generateCycle();
        return \controller\Math\VectorMath::addVector($vector, $position);
    }

    public function generateWaveFrom(array $position): array
    {
        $vector = $this->generateWave();
        return \controller\Math\VectorMath::addVector($vector, $position);
    }

    public function getStateAtPhaseFrom($input_phase, $position): array
    {
        $vector = $this->getStateAtPhase($input_phase);
        return \controller\Math\VectorMath::addVector($vector, $position);
    }

    # # # # # # # # # # # # # # # #
    # protected actual iterator   #
    # # # # # # # # # # # # # # # #

    protected function cycle(): array
    {
        $return_value = $this->getStateAtPhase();
        $this->phase ++;
        $this->timer ++;
        return $return_value;
    }

    # # # # # # # # # # # #
    # Getters and setters #
    # # # # # # # # # # # #
    /**
     * @return int
     */
    public function getDim(): int
    {
        return $this->dim;
    }

    /**
     * @param int $dim
     */
    public function setDim(int $dim)
    {
        $this->dim = $dim;
    }
    ###################################
    public function getPhase(): int
    {
        return $this->phase;
    }
    public function setPhase(int $phase)
    {
        $this->checkPhase($phase);
        $this->phase = $phase;
        $this->timer = $this->phase;
    }
    ###################################
    public function getUpperLimit()
    {
        return $this->upper_limit;
    }
    # makes it possible to create additional waveforms with outer iterators
    public function setUpperLimit($upper_limit)
    {
        $this->upper_limit = $upper_limit;
    }
    #########################################
    public function getLowerLimit()
    {
        return $this->lower_limit;
    }
    # makes it possible to create additional waveforms with outer iterators
    public function setLowerLimit($lower_limit)
    {
        $this->lower_limit = $lower_limit;
    }
    #####################################
    public function getWaveLength()
    {
        return $this->wavelength;
    }
    public function setWaveLength($wavelength)
    {
        $this->wavelength = $wavelength;
        $this->half_wavelength = intdiv($wavelength, 2);
    }
    ########################################
    public function getTimer()
    {
        return $this->timer;
    }

    /** Use setPhase instead
     * @param $timer
     */
    protected function setTimer($timer)
    {
        $this->timer = $timer;
    }
    # # # # # # # # #
    # Check Values  #
    # # # # # # # # #
    protected function checkWaveLength($wavelength)
    {
        if ($wavelength == 0 || $wavelength < 2 || $wavelength%2 != 0) {
            #To Do: error
            return false;
        }
    }
    protected function checkPhase($phase)
    {
    if ($phase > $this->wavelength) {
        #To Do: error
        return false;
    }
    }
}