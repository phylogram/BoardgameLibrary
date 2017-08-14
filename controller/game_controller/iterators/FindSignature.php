<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 13.08.2017
 * Time: 20:18
 */

namespace controller\game_controller\iterators;


class findSignature
{
    /**
     * Brute force test for signatures of triangle functions and resulting values. Do not use in production
     * @param int $lower
     * @param int $upper
     * @param int $wave_max
     * @param int $phase_max
     * @param array $test_1
     * @param array $test_2
     * @param bool $break_after_success if true, will stop after success.
     */
    public static function test2D(int $lower, int $upper, int $wave_max, int $phase_max, array $test_1, array $test_2, $break_after_success = true)
    {
        $possible_lower_values = range($lower, $upper);
        $possible_upper_values = $possible_lower_values;
        $possible_wave_values = range(2, $wave_max, 2);
        $possible_phase_values = range(0, $phase_max);

        $success_1 = false;
        $success_2 = false;

        $len = count($test_1);
        $steps = range(0, $len);

        foreach ($possible_lower_values as $lower_one) {
            echo "<p>Test at outer loop $lower_one of $lower</p>";
            foreach ($possible_lower_values as $lower_two) {
                foreach ($possible_upper_values as $upper_one) {
                    foreach ($possible_upper_values as $upper_two) {
                        foreach ($possible_wave_values as $wave_one) {
                            foreach ($possible_wave_values as $wave_two) {
                                foreach ($possible_phase_values as $phase_one) {
                                    foreach ($possible_wave_values as $phase_two) {
                                        $result = array();
                                        $test_triangle = new \controller\game_controller\iterators\TriangleFunctionGenerator([$lower_one, $upper_one, $wave_one, $phase_one], [$lower_two, $upper_two, $wave_two, $phase_two]);

                                        #create an array to test with
                                        foreach ($steps as $step) {
                                            $result[] = $test_triangle->generateWave();
                                        }
                                        #clean phases
                                        $result = array_values($result);

                                        if (!$success_1) {
                                            if ($test_1 == $result) {
                                                echo "<p><strong>Success for test one: $test_1</strong></p>";
                                                var_dump($test_triangle->getSignatures());
                                                $success_1 = true;
                                                if ($break_after_success) {
                                                    if ($success_1 && $success_2) {
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        if (!$success_2) {
                                            if ($test_2 == $result) {
                                                echo "<p><strong>Success for test two: $test_2</strong></p>";
                                                var_dump($test_triangle->getSignatures());
                                                $success_2 = true;
                                                if ($break_after_success) {
                                                    if ($success_1 && $success_2) {
                                                        break;
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
        }
    }
}