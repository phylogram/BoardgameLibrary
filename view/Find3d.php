<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 15.08.2017
 * Time: 12:38
 */
require_once ('..\bootstrap\init.php');
# 1	2	-1	0	0	1


#king!!!
$db = new mysqli('localhost', 'root', '', 'test_database');

$wavelength = 8;

$test_array = array(-1, 0, 1, 1, 1, 0, -1, -1);

$value_range = range(-2,  2, 1);
$phase_range = range(0, 9);
$counter = 1;
foreach ($phase_range as $p1) {
    foreach ($phase_range as $p2) {

        foreach ($value_range as $fv1) {
            foreach ($value_range as $fv2) {

                foreach ($value_range as $sv1) {
                    foreach ($value_range as $sv2) {

                        $test_generator = new \controller\game_controller\iterators\TriangleFunctionGenerator(
                            new \controller\game_controller\iterators\SignatureNDim(array(

                                new \controller\game_controller\iterators\Signature1Dim($fv1, $sv1, $wavelength, $p1, 0),
                                new \controller\game_controller\iterators\Signature1Dim($fv2, $sv2, $wavelength, $p2, 1)
                                ), 0)
                        );


                        #generate
                        $generated_array = array();

                        foreach (range(0, $wavelength - 1) as $item) {
                            $generated_array[] = current($test_generator->generateWave()->values);
                        }
                        #echo implode(' ', $generated_array), '<br>';
                        if ($generated_array == $test_array) {
                            $sql = <<<SQL
INSERT INTO king_waves (index_value, wave, p1, p2, fv1, fv2, sv1, sv2) VALUES ($counter, 1, $p1, $p2, $fv1, $fv2, $sv1, $sv2);
SQL;
                            echo $sql;
                            $succ = $db->query($sql);
                            if (!$succ) {
                                echo $db->error, '<br>';
                            }
                        }

                        $counter ++;

                    }
                }
            }
        }
    }

}
$db->close();
echo 'fertig2';