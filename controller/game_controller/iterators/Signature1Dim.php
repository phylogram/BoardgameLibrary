<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 17.08.2017
 * Time: 16:37
 */

namespace controller\game_controller\iterators;


class Signature1Dim
{
    public $wavelength;
    public $half_wavelength;
    public $phase;
    public $dim;
    public $lower_limit;
    public $upper_limit;

    public function __construct($upper_limit, $lower_limit, $wavelength, $phase, $dim)
    {
        $this->upper_limit =  $upper_limit;
        $this->lower_limit = $lower_limit;
        $this->wavelength = $wavelength;
        $this->half_wavelength = intdiv($this->wavelength, 2);
        $this->phase = $phase;
        $this->dim = $dim;
    }


}