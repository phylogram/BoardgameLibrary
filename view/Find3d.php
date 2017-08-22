<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 15.08.2017
 * Time: 12:38
 */
require_once ('..\bootstrap\init.php');
echo '<style>td, th {text-align: center; border-width: thin; border-style: dashed; border-color: darkgray;}</style>';
set_time_limit(600);
echo '<h1>We will brut force this shit NEW</h1>';

#To Do: write in Database and use in python for calculation
$target1 = array(1, 2, 2, 1, -1, -2, -2, -1);
$target2 = array(-2, -2, -1, 1, 2, 2, 1, -1);

$input_value_range = range(-1, 1);

$wavelength = 8;

$phase_range = range(0, $wavelength - 1);
$t = time();
$counter = 0;

#input value range
foreach ($input_value_range as $one1) {
    echo "<p>Outer loop $one1 of 3: $counter waves generated</p>";
    echo '<p style="padding-left:4em">Time elapsed in s: ', time() - $t, '</p>';
    foreach ($input_value_range as $one2) {
        foreach ($input_value_range as $two1) {
            foreach ($input_value_range as $two2) {
                foreach ($input_value_range as $three1) {
                    foreach ($input_value_range as $three2) {
                        #phase range!
                        foreach ($phase_range as $p1) {
                            foreach ($phase_range as $p2) {
                                foreach ($phase_range as $p3) {

                                    #update
                                    $counter ++;

                                    #The Generator Generation
                                    $test_generator = new \controller\game_controller\iterators\TriangleFunctionGenerator(
                                        new \controller\game_controller\iterators\SignatureNDim(array(
                                            new \controller\game_controller\iterators\Signature1Dim( $one1, $one2, $wavelength, $p1, 0), #The first sub_generator
                                            new \controller\game_controller\iterators\Signature1Dim($two1, $two2, $wavelength, $p2, 1), #The 2nd
                                            new \controller\game_controller\iterators\Signature1Dim($three1, $three2, $wavelength, $p3, 2) #The 3rd
                                        ), 0)
                                    );

                                    #Gather the $values

                                    $generated_array = array();

                                    foreach (range(0, 7) as $i) {
                                        $generated_array[] = current($test_generator->generateWave()->values);
                                    }

                                    #Compare arrays
                                    $target = 0;

                                    if ($generated_array === $target1) {
                                        $target = array
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
$t = time() - $t;
echo "<p><strong>Finished $i items in $t seconds</strong>";