<?php
namespace controller\game_controller\iterators;

class SquareFunctionGenerator
{
    # # # # # # # # # # # # # # # # # # # # # #
    #   _   _   _   _   _   _   _   _   _   _ #
    # _| |_| |_| |_| |_| |_| |_| |_| |_| |_|  #
    #                                         #
    # # # # # # # # # # # # # # # # # # # # # #



    protected $upper_limit;     #The upper value
    protected $lower_limit;     #The lower value
    protected $wavelength;  # f.e. 4:
    #     _ _     _ _
    # _ _|   |_ _|   |_ _
    protected $half_wavelength;
    protected $phase; #where are we in the cycle: can't be bigger wavelength


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
    public function __construct($upper_limit, $lower_limit, int $wavelength, int $phase = 0)
    {
        $this->upper_limit = $upper_limit;
        $this->lower_limit = $lower_limit;

        $this->checkWaveLength($wavelength);
        $this->wavelength = $wavelength;

        $this->checkPhase($phase);
        $this->half_wavelength = intdiv($this->wavelength, 2);
        $this->phase = $phase;
    }

    # # # # # # # # # # #
    # Public Generators #
    # # # # # # # # # # #

    /**
     * generates on cycle, afterwards only NULL
     * @return \integer|null
     */
    public function generateCycle()
    {
        if ($this->phase >= $this->wavelength) {
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
     * @param $phase int or 'current'
     */
    public function getStateAtPhase($phase = 'current'): array
    {
        
        if ($phase == 'current') {
            $phase = $this->phase;
        }
        
        switch (($phase % $this->wavelength) < $this->half_wavelength) {
            case true:
                
                return array($phase => $this->lower_limit);
                break;
            case false:
                
                return array($phase => $this->upper_limit);
                break;
        }
    }

    # # # # # # # # # # # # # # # #
    # protected actual iterator   #
    # # # # # # # # # # # # # # # #

    protected function cycle(): array
    {
        $return_value = $this->getStateAtPhase();
        $this->phase ++;
        return $return_value;
    }

    # # # # # # # # # # # #
    # Getters ad setters  #
    # # # # # # # # # # # #
    public function getPhase(): int
    {
        return $this->phase;
    }
    public function setPhase(int $phase)
    {
        $this->checkPhase($phase);
        $this->phase = $phase;
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