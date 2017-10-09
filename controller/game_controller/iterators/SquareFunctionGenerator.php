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

    protected $current_phase;

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

        $this->current_phase = new \controller\game_controller\iterators\phase($this->phase);
        
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
        return $this->generateWave();
    }

    /**
     * generates endless wave
     * @return mixed
     */
    public function generateWave(): \controller\game_controller\iterators\phase
    {

        if ($this->phase === $this->wavelength) {
            $this->phase = 0;
        }
        $this->current_phase =  $this->getStateAtPhase();
        $this->cycle();
        return $this->current_phase;
    }
    /**
     * gets value at state
     * @return array [$phase => $value]
     * @param $input_phase int or 'current'
     */
    public function getStateAtPhase($input_phase = 'current'): \controller\game_controller\iterators\phase
    {
        if ($input_phase === 'current') {
            
            $input_phase = $this->phase;
        }
        $this->current_phase->setCurrentPhase($this->phase);
        switch (($input_phase % $this->wavelength) < $this->half_wavelength) {
            case true:
                $this->current_phase->set($this->dim, $this->upper_limit);
                return $this->current_phase;
                break;

            case false:
                $this->current_phase->set($this->dim, $this->lower_limit);
                return $this->current_phase;
                break;
        }
    }
    # # # # # # # # # # # # # # # #
    # Public positional generator #
    # # # # # # # # # # # # # # # #

    public function generateCycleFrom(array $position)
    {
        $this->current_phase = $this->generateCycle();

        if ($this->current_phase) {
            return \controller\Math\VectorMath::addVector($this->current_phase, $position);
        }

        return $this->current_phase;
    }

    public function generateWaveFrom(array $position): \controller\game_controller\iterators\phase
    {
        $this->current_phase = $this->generateWave();
        if ($this->current_phase) {
            return \controller\Math\VectorMath::addVector($this->current_phase, $position);
        }
        return $this->current_phase;
    }

    public function getStateAtPhaseFrom($input_phase, $position): \controller\game_controller\iterators\phase
    {
        $this->current_phase = $this->getStateAtPhase($input_phase);
        if ($this->current_phase) {
            return \controller\Math\VectorMath::addVector($this->current_phase, $position);
        }
        return $this->current_phase;
    }
    public function getMoveAtPhase($input_phase): \controller\game_controller\iterators\phase
    {
        $this->current_phase = $this->getStateAtPhase($input_phase);
        $this->cycle();
        return $this->current_phase;
    }
    public function getMoveAtPhaseFrom($input_phase, $position): \controller\game_controller\iterators\phase
    {
        $this->current_phase = $this->getStateAtPhaseFrom($input_phase, $position);
        $this->cycle();
        return $this->current_phase;
    }

    # # # # # # # # # # # # # # # #
    # protected incrementor  #
    # # # # # # # # # # # # # # # #

    protected function cycle()
    {

        $this->phase ++;
        $this->timer ++;

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
    #############

    /**
     * @return phase
     */
    public function getCurrentPhase(): phase
    {
        return $this->current_phase;
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