<article class="pure-u-20-24" id="doc_IteratorClasses" style="margin-left: 2%; margin-top: 1px;">

 <?php
ini_set('html_errors', true);
set_time_limit(0);
ob_end_flush();
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
ob_implicit_flush(1);

echo 'start<br>';
echo 'start: ', date('H:i:s'), '<br>';

$p = 0;
$total = 3*3*3 *3*3*3 *12*12*21;
$desired_array = array(1, 2, 2, 1, -1, -2, -2, -1);


$phaserange = [0, 11];
$value_range = [-1, 1];

#foreach ($wave_range as $w1) {
 #   foreach ($wave_range as $w2) {
  #      foreach ($wave_range as $w3) {

            foreach (range(...$phaserange) as $p1) {
                foreach (range(...$phaserange) as $p2) {
                    echo "<p>$i - $p</p>";
                    echo '@: ', date('H:i:s'), '<br>';
                    foreach (range(...$phaserange) as $p3) {

                        foreach (range(...$value_range) as $l1) {
                            foreach (range(...$value_range) as $l2) {
                                foreach (range(...$value_range) as $l3) {

                                    foreach (range(...$value_range) as $u1) {
                                        foreach (range(...$value_range) as $u2) {
                                            foreach (range(...$value_range) as $u3) {
                                                $i ++;
                                                $p = $i/$total;
                                                $ts = new \controller\game_controller\iterators\SignatureFigure(array(
                                                    new \controller\game_controller\iterators\Signature1Dim($u1, $l1, 8, $p1, 0),
                                                    new \controller\game_controller\iterators\Signature1Dim($u2, $l2, 8, $p2, 1),
                                                    new \controller\game_controller\iterators\Signature1Dim($u3, $l3, 8, $p3, 3)
                                                ), 0, 2, 0, false, 0);


                                                $generator = new \controller\game_controller\iterators\FigureFunctionGenerator($ts);

                                                $test_array = array();

                                                foreach (range(0, 7) as $step) {
                                                    $phase = $generator->generateWave();
                                                    $value = $phase->values[0];
                                                    $test_array[] = $value;

                                                }
                                                if ($test_array === $desired_array) {
                                                    echo explode(' ', array($u1, $l1, $w1, $p1, '|', $u2, $l2, $w2, $p2,'|',  $u3, $l3, $w3, $p3));
                                                    echo '<strong>JAJAJAJ</strong>';
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
     #       }
    #   }
   # }
}
echo '<br>ende $i<br>';