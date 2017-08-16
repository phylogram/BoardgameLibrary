<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 13.08.2017
 * Time: 20:18
 */

namespace controller\game_controller\iterators;

class findSignatures
{
    protected $success = 0;
    protected $number_of_tests;
    protected $signatures;
    protected $harmonics = array(
            array(2, 2, 8),
            array(2, 4, 8),
            array(2, 8, 8),
            array(4, 4, 8),
            array(4, 8, 8),
            array(8, 8, 8),
        );
    protected $phases;
    const lower = -1;
    const upper = 1;
    protected $values;

    protected $break_after_success;


    public function __construct($break_after_success = true)
    {
        $this->break_after_success = $break_after_success;
        $this->phases = range(0, 7);
        $this->values = range(self::lower, self::upper);
    }


    public function three_D_8()
    {

        foreach ($this->harmonics as $wave) {
            foreach ($this->phases as $phase_one) {
                foreach ($this->phases as $phase_two) {
                    foreach ($this->phases as $phase_three) {
                        foreach ($this->values as $lower_one) {
                            foreach ($this->values as $lower_two) {
                                foreach ($this->values as $lower_three) {
                                    foreach ($this->values as $upper_one) {
                                        foreach ($this->values as $upper_two) {
                                            foreach ($this->values as $upper_three) {
                                                yield $this->getDerefFlattendArrayOfGenerator(
                                                    new \controller\game_controller\iterators\TriangleFunctionGenerator([$lower_one, $upper_one, $wave[0], $phase_one], [$lower_two, $upper_two, $wave[1], $phase_two], [$lower_three, $upper_three, $wave[2], $phase_three])
                                            );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    public function getDerefFlattendArrayOfGenerator(\controller\game_controller\iterators\TriangleFunctionGenerator $tfg)
    {
        $cycle = range(0, $tfg->getWaveLength() -1);
        $array_of_generator = array();
        foreach ($cycle as $phase) {
            $array_of_generator[] = current($tfg->generateWave());
        }
        return [$tfg->getSignatures(), $array_of_generator];
    }
}
