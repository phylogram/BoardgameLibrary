<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 25.08.2017
 * Time: 21:49
 */

namespace view;


class IteratorClasses
{
    public static function get()
    {
        $output_html = <<<OUTPUT
        
            <article class="pure-u-20-24" id="doc_IteratorClasses" style="margin-left: 2%; margin-top: 1px;">

        <header>
            <h1 itemprop="headline">The Basic Iterator Classes</h1>

            <i>pseudo generators to access the "neighboring" fields</i>
        </header>
        <section>
            <h2>The basic iterator - The SquareFunctionGenerator</h2>
            <figure>
                <img src="pictures/SquareWave.svg" height="350em"/>
                <figcaption>done with pyplot</figcaption>
            </figure>
            <p>The SquareFunctionGenerator class generates a ... square wave. This is useful for example to generate the inner moves for a bishop:</p>
            <figure>
                <img src="pictures/zugmöglichkeiten%20läufer.svg" height="300em"/>
                <figcaption style="alignment: right">
                    <strong>R:</strong> -1, +1, -1, +1<br>
                    <strong>C:</strong> +1, -1, +1, -1
                </figcaption>
            </figure>

        </section>
        <section class="code-overview" id="construct">
            <h2>SquareFunctionGenerator::__construct()</h2>
            <p>
                produces an pseudo-iterator, with peak<sup>max</sup> = <code>\$upper_limit</code>, peak<sup>min</sup> = <code>\$lower_limit</code> and λ = <code>\$wavelength</code>
            </p>
            <p>Since we are iterating indexes all values are integers and therefore λ must be even (and positive).</p>
            <h2>API</h2>
            <p>A waveform is described by some basic values, like upper and lower extrema, wavelength and phase at the beginning. This will be defined via the <code>Signature1Dim</code> object</p>
            <code class="code-example">
                \$signature_1_m1 = new \controller\game_controller\iterators\Signature1Dim(1, -1, 2, 0, 0);
            </code>
            <p> Then we can initialize a Square Function Object with it:</p>
            <code class="code_example">
                \$square_1_minus = new \controller\game_controller\iterators\SquareFunctionGenerator(\$signature_1_m1);
            </code>
            <p><code>SquareFunctionGenerator::generateCycle()</code> returns every time it is called an object of <code>\$phase</code> and at the end of the cycle only <code>NULL</code>.This is useful, if you want to cycle only one "itertation" – that is all possible values around a figure.</p>
            <div class="code_output">
OUTPUT;        


               
                $signature_1_m1 = new \controller\game_controller\iterators\Signature1Dim(1, -1, 2, 0, 0);
                $square_1 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_1_m1);
                foreach(range(0, 3) as $line) {
                    $iterated_array = $square_1->generateCycle();
                    $output_html = \view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                    echo $output_html;
            }
                ?>
            </div>
            
            <p>while <code>SquareFunctionGenerator::generateWave()</code> is able to being called at arbitrary times:</p>
            <code class="code_output">
                <?php
                $square_1->setPhase(0);

                foreach(range(0, 7) as $line) {

                    $iterated_array = $square_1->generateWave();
                    $output_html = \view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                    echo $output_html;
                }
                ?>
            </code>
            <p>It is possible to calculate the value for an arbitrary phase even when current is not at that phase with: <code>SquareFunctionGenerator::getStateAtPhase($phase = 'current')</code></p>
            <p>Changing the wavelength with <code>$square_1->setWaveLength(4);</code> will result in the following: </p>
            <code class="code_example">
                <?php
                $square_1->setPhase(0);
                $square_1->setWaveLength(4);
                foreach(range(0, 7) as $line) {
                    $iterated_array = $square_1->generateWave();
                    $output_html = \view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                    echo $output_html;
                }
                ?>
            </code>
            <p>It is possible to get and set all the properties of the class.</p>
            <p>Changing the amplitude of the function between calls (++/--) will result in</p>
            <code class="code_example">
                <?php
                $square_1->setPhase(0);
                foreach(range(0, 7) as $line) {

                    $iterated_array = $square_1->generateWave();
                    # get Values
                    $current_upper = $square_1->getUpperLimit();
                    $current_lower = $square_1->getLowerLimit();

                    # change values
                    $square_1->setUpperLimit($current_upper+1);
                    $square_1->setLowerLimit($current_lower-1);
                    $output_html = \view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line, 0.3);
                    echo $output_html;
                }
                ?>
            </code>
            <p>and changing the wavelength between 4 and 2 (has to be even – any wavelength multiplies with 2) every odd iteration (with ... you guess it: another SquareFunction) will result in</p>
            <code class="code_example">
                <?php
                $signature_422200 = new \controller\game_controller\iterators\Signature1Dim(4, 2, 2, 0, 0);
                $square_2 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_422200);

                $square_1->setLowerLimit(-1);
                $square_1->setUpperLimit(1);
                $square_1->setPhase(0);
                $square_1->setWaveLength(2);

                foreach(range(0, 7) as $line) {

                    $iterated_array = $square_1->generateWave();

                    # change values if second
                    if ($line%2!==0) {
                        $control_array = $square_2->generateWave();
                        $new_wavelength = current($control_array->values);
                        $new_wavelength = current($control_array->values);

                        $square_1->setWaveLength($new_wavelength);
                    }

                    $output_html = \view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                    echo $output_html;
                }
                ?>
            </code>
</section>
        <section>
            <h2>Multidimensional indexing - The NDimSquareFunctionGenerator class</h2>
            <p>Most boardgames are not one-dimensional, so we need to combine multiple SquareFunctions. This is done with the <code>NDimSquareFunctionGenerator</code> class which extends the <code>SquareFunctionGenerator</code> class</p>
            <p>For that we we'll need multiple signatures. This is done with the</p>
            <h3>The generateCycle method</h3>
            <code class="code_example">
                $bishop_sig = new \controller\game_controller\iterators\SignatureNDim(array(
                <code class="code_example"> new controller\game_controller\iterators\Signature1Dim(1, -1, 2, 0, 0),</code>
                <code class="code_example">new controller\game_controller\iterators\Signature1Dim(1, -1, 2, 1, 1),</code>
                  ), 0
                );
                $two_dim_square = new \controller\game_controller\iterators\NDimSquareFunctionGenerator($bishop_sig);



            </code>
            <?php
            $bishop_sig = new \controller\game_controller\iterators\SignatureNDim(array(
                    new controller\game_controller\iterators\Signature1Dim(1, -1, 2, 0, 0),
                    new controller\game_controller\iterators\Signature1Dim(1, -1, 2, 1, 1),
                ), 0
            );
            $two_dim_square = new \controller\game_controller\iterators\NDimSquareFunctionGenerator($bishop_sig);
            #To Do: debug: false values
            foreach (range(0, 3) as $line) {
                $iterated_array = $two_dim_square->generateCycle();
                $output_html = view\DimensionPhaseValue::print2D($iterated_array, $line);
                echo $output_html;
            }
            ?>
            <h3>and the generateWave method</h3>
            <?php

            $two_dim_square->setPhase(0);
            foreach (range(0, 3) as $line) {
                $iterated_array = $two_dim_square->generateWave();
                $output_html = view\DimensionPhaseValue::print2D($iterated_array, $line);
                echo $output_html;
            }
            ?>
        </section>

        <section>
            <h2>Adding Square Functions to Create More Complex Movements</h2>
            <p>Let's take a look how the rook can move:</p>
            <figure>
                <img src="pictures/zugmöglichkeiten%20turm.svg" height="300em"/>
                <figcaption>
                    <strong>R:</strong> &nbsp;0, +1, &nbsp;0, -1<br>
                    <strong>C:</strong> +1, &nbsp;0, -1, &nbsp;0
                </figcaption>
            <p>which can be seen as Triangle-Function: </p>
            <figure>
                <img src="pictures/TriangleWave.svg" height="500em"/>
                <figcaption>done with pyplot</figcaption>
            </figure>
            <p>adding two shifted square functions will result in a triangle function</p>
                <code class="code_example">$signature_10400 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 4, 0, 0);</code>
                <code class="code_example">$signature_10411 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 4, 1, 1);</code>
                <code class="code_example">$square_1_0_2_phase_0 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_10400);</code>
                <code class="code_example">$square_1_0_2_phase_1 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_10411);</code>

                <code class="code_example">$current_value = $square_1_0_2_phase_0->generateWave() + $square_1_0_2_phase_1->generateWave();</code>
                <code class="code_example">...</code>

            <p>with <code>$upper_value = $upper_value<sub>0</sub> + $upper_value<sub>1</sub></code> as well as with <code>$lower_value</code></p>
                <code class="code_output">
                    <?php
                    $signature_10400 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 4, 0, 0);
                    $signature_10411 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 4, 1, 1);

                    $square_1_0_2_phase_0 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_10400);
                    $square_1_0_2_phase_1 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_10411);

                    foreach (range(0,7) as $line) {
                        $current_left = $square_1_0_2_phase_0->generateWave();
                        $current_right = $square_1_0_2_phase_1->generateWave();

                        $output_html = view\DimensionPhaseValue::summingUp1D($current_left, $current_right, $line);
                        echo $output_html;

                    }
                    ?>
                </code>

        </section>
        <section>
            <h2>The TriangleFunctionGenerator</h2>
            <p>The TriangleFunctionGenerator extends the NDimSquareFunction Generator and adds up the (sub-)dimensions to a new single dimension</p>
            <code class="code_example">$two_dim_signature = new \controller\game_controller\iterators\SignatureNDim([$signature_10400, $signature_10411], 0);</code>
            <code class="code_example">$triangle_0121 = new \controller\game_controller\iterators\TriangleFunctionGenerator($two_dim_signature);</code>

                <code class="code_output">
                    <?php
                    $two_dim_signature = new \controller\game_controller\iterators\SignatureNDim([$signature_10400, $signature_10411], 0);
                    $triangle_0121 = new \controller\game_controller\iterators\TriangleFunctionGenerator($two_dim_signature);

                    foreach (range(0,7) as $line) {
                        $iterated_array = $triangle_0121->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>

            <p>The new wavelength is calculated as the least common multiple by reduction by the greatest common divisor (<a href="https://en.wikipedia.org/wiki/Least_common_multiple#Reduction_by_the_greatest_common_divisor" target="_blank">wiki</a>) and can be accessed with <code>TriangleFunctionGenerator::getWavelength()</code></p>
                <code class="code_example">
                    <?php
                    echo $triangle_0121->getWaveLength();
                    ?>
                </code>
            <p>The value at a explicit state can be accessed by <code>TriangleFunctionGenerator::getStateAtPhase($phase)</code>, for example 3 and 2:</p>
                <code class="code_output">
                <?php

                echo '<p>', current($triangle_0121->getStateAtPhase(3)->values), ' and ', current($triangle_0121->getStateAtPhase(2)->values), '</p>';
                ?>
                </code>
            <p>and again it is possible to retrieve just one cycle with <code>TriangleFunctionGenerator::generateCycle()</code></p>

                <code class="code_output">
                    <?php
                    $triangle_0121->setPhase(0);
                    foreach(range(0,5) as $line) {
                        $iterated_array = $triangle_0121->generateCycle();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>

            <p>As mentioned above it is possible to use an arbitrary number of generators like this:</p>

                <code class="code_output">
                    <?php

                    $triangle_fun = new \controller\game_controller\iterators\TriangleFunctionGenerator(
                            new \controller\game_controller\iterators\SignatureNDim(array(
                                    new controller\game_controller\iterators\Signature1Dim(0,1,6,0, 0),
                                    new controller\game_controller\iterators\Signature1Dim( 0,1,6,1, 1),
                                    new controller\game_controller\iterators\Signature1Dim(0,1,6,2, 2),
                                    new controller\game_controller\iterators\Signature1Dim(0,1,6,3, 3),
                            ), 0)
                    );
                    echo '<p>Resulting wavelength: ', $triangle_fun->getWavelength(), '<p>';
                    foreach(range(0,11) as $line) {
                        $iterated_array = $triangle_fun->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>

        </section>

        <section>
            <h2>Using combined square functions for knight and king</h2>
            <p>we can use combined square functions for knight and king. This are the possible movements of the king:</p>
            <figure>
                <img src="pictures/zugmöglichkeiten%20könig.svg" height="300em"/>
                <figcaption>
                    <strong>R:</strong> -1, &nbsp;0, +1, +1, +1, &nbsp;0, -1, -1<br>
                    <strong>C:</strong>+1, +1, +1, &nbsp;0, -1, -1, -1, &nbsp;0
                </figcaption>
            </figure>

            <p>We can add two SquareFunctions with a phase difference of 1:</p>
                <code class="code_example">
                    $triangle_king = new \controller\game_controller\iterators\TriangleFunctionGenerator([0,1,8,6], [-1,0,8,7]);
                </code>

            <p>and with <code>TriangleFunctionGenerator::generateCycle();</code> we can move exactly one time around.</p>

                <code class="code_output">
                    <?php
                    $triangle_fun = new \controller\game_controller\iterators\TriangleFunctionGenerator(
                        new controller\game_controller\iterators\SignatureNDim(array(
                                new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
                                new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
                            ), 0)
                    );
                    echo '<p>Resulting wavelength: ', $triangle_fun->getWavelength(), '<p>';
                    foreach(range(0,7) as $line) {
                        $iterated_array = $triangle_fun->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }

                    ?>
                </code>

            <p>The knight has 4 possible values:</p>

            <figure>
                <figcaption>
                    <img src="pictures/zugmöglichkeiten%20pferd.svg" height="500em">
                <strong>R:</strong> +1, +2, +2, +1, -1, -2, -2, -1<br>
                <strong>C:</strong>-2, -2, -1, +1, +2, +2, +1, -1
                </figcaption>
            </figure>
            <code class="code_example">
                $triangle_knight = new \controller\game_controller\iterators\TriangleFunctionGenerator(
                <code class="code_example inside">
                    new \controller\game_controller\iterators\SignatureNDim(array(
                        <code class="code_example inside">new controller\game_controller\iterators\Signature1Dim(-1,1,8,7, 0),</code>
                        <code class="code_example inside">new controller\game_controller\iterators\Signature1Dim(-1,0,8,0, 1),</code>
                    <code class="code_example inside">new controller\game_controller\iterators\Signature1Dim( 0,1,8, 6, 2),</code>
                    ), 0)
                </code>
                );
            </code>

            <p>and with <code>TriangleFunctionGenerator::generateCycle();</code> we can move exactly one time around.</p>

                <code class="code_output">
                    <?php
                    $triangle_knight = new \controller\game_controller\iterators\TriangleFunctionGenerator(
                                new \controller\game_controller\iterators\SignatureNDim(array(
                                new controller\game_controller\iterators\Signature1Dim(-1,1,8,7, 0),
                                new controller\game_controller\iterators\Signature1Dim(-1,0,8,0, 1),
                                new controller\game_controller\iterators\Signature1Dim( 0,1,8,6, 2),
                                ), 0)
                    );

                    echo $triangle_fun->getWaveLength();
                    foreach(range(0,7) as $line) {
                        $iterated_array = $triangle_fun->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>

        </section>
        <section>
            <h2>The NDim TriangleFunctionGeneratorShifted class</h2>
            <p>If we want to use Triangle Functions in a multiple dimensions, we would have to use another NDim...Generator class. Since most pieces move symmetrically in space, we will only need to shift each function foreach dimension.</p>
            <code class="code_output">
            <?php
                $shift = 6;
                $triangle_fun = new \controller\game_controller\iterators\NDimTriangleFunctionGeneratorShifted(
                    new controller\game_controller\iterators\SignatureNDimShift(array(
                        new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
                        new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
                    ), 0, 2, $shift)
                );
                #var_dump($triangle_fun);
                echo "<p><strong>Shift: $shift</strong></p>";
                foreach(range(0,9) as $line) {
                    $iterated_array = $triangle_fun->generateCycle();
                    $output_html = view\DimensionPhaseValue::print2D($iterated_array, $line);
                    echo $output_html;
                }
            ?>

            </code>
        </section>
        <section>
            <h2>Figure Function Generator</h2>
        <p>The Queen, the bishop and the rook can move more than one field. Feeding the FigureFunctionGenerator with a Signature with a <code>$is_sub_iterable = true</code> and a <code>$step_size</code> will let us walk further in each phase. If false, we will move the same as before</p>
        <code class="code_output">
            <?php

            $triangle_fun = new \controller\game_controller\iterators\FigureFunctionGenerator(
                new controller\game_controller\iterators\SignatureFigure(array(
                    new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
                    new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
                ), 0, 2, $shift,  true, 1)
            );
            #var_dump($triangle_fun);

            foreach(range(0,9) as $line) {
                $iterated_array = $triangle_fun->generateCycle();
                $output_html = view\DimensionPhaseValue::print2D($iterated_array, $line);
                echo $output_html;
            }
            ?>
        </code>
        <p>Obviously we would fall of the board this way. But when the board tells us that the next field is <code>NULL</code> we just take the next phase (Let's assume we are on board with size  4*4):</p>
        <code class="code_output">
            <?php

            $triangle_fun = new \controller\game_controller\iterators\FigureFunctionGenerator(
                new controller\game_controller\iterators\SignatureFigure(array(
                    new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
                    new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
                ), 0, 2, $shift,  true, 1)
            );
            #var_dump($triangle_fun);

            $border = 3;
            foreach(range(0,17) as $line) {
                $iterated_array = $triangle_fun->generateCycle();
                if ($iterated_array->values[0] > $border || $iterated_array->values[1] > $border) {
                    $triangle_fun->next();
                    echo "<p><strong>NEXT</strong></p>";
                } else {
                    $output_html = view\DimensionPhaseValue::print2D($iterated_array, $line);
                    echo $output_html;
                }
            }
            ?>
        </code>
        <p>and the very same code (just with foreach only 10 times called) with <code>$is_sub_iterable = false</code> will return</p>
        <code class="code_output">
            <?php

            $triangle_fun2 = new \controller\game_controller\iterators\FigureFunctionGenerator(
                new controller\game_controller\iterators\SignatureFigure(array(
                    new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
                    new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
                ), 0, 2, $shift,  false, 1)
            );
            #var_dump($triangle_fun);


            foreach(range(0,9) as $line) {
                $iterated_array = $triangle_fun2->generateCycle();
                if ($iterated_array) {
                    if ($iterated_array->values[0] > $border || $iterated_array->values[1] > $border) {
                        $triangle_fun2->next();
                        echo "<p><strong>NEXT</strong></p>";
                    }

                }
                $output_html = view\DimensionPhaseValue::print2D($iterated_array, $line);
                echo $output_html;
            }
            ?>
        </code>
        <h2>Getting an index from an position</h2>
        <p>Now the only thing left to select an position from the GameBoard is to add the vector to the position Therefor the following methods. Using the same code from above with position [2,3] on a GameBoard (5*5) and subiteration will result in:</p>
        <code class="code_output">

            <?php
            $game_bord = new \model\game\arrays\ChessBoard([5, 5]);


            $triangle_fun->reset();

            $show_table = '';


            foreach(range(0,17) as $line) {
                $iterated_position = $triangle_fun->generateCycleFrom([2, 3]);

                if ($iterated_position) {
                    $field = $game_bord->selectFromChessBoard($iterated_position->values);
                    if ($field) {

                        $output_html = view\DimensionPhaseValue::print2D($iterated_position, $line);
                        echo $output_html;

                        echo '<p>The selected field\'s position property: x ', implode(' and y ', $field->getPosition() ), '</p>';
                        echo '<br/>';
                    } else {
                        $output_html = view\DimensionPhaseValue::print2D($iterated_position, $line);
                        echo $output_html;
                        echo '<p><strong>There is no field: NEXT</strong></p>';
                        $triangle_fun->next();
                        echo '<br/>';
                    }
                }
            }
            ?>
        </code>
        <p>To update single phases we use the <code></code>. Which is done below from phase 0, position 0|0 (as above) and 5 times, which will result in a diagonal:</p>
        <code class="code_output">

            <?php
            $triangle_fun->reset();


            foreach(range(0,4) as $line) {
                $iterated_position = $triangle_fun->getMoveAtPhaseFrom(0, [0, 0]);

                if ($iterated_position) {
                    $field = $game_bord->selectFromChessBoard($iterated_position->values);
                    if ($field) {

                        $output_html = view\DimensionPhaseValue::print2D($iterated_position, $line);
                        echo $output_html;

                        echo '<p>The selected field\'s position property: x ', implode(' and y ', $field->getPosition() ), '</p>';
                    } else {
                        $output_html = view\DimensionPhaseValue::print2D($iterated_position, $line);
                        echo $output_html;
                        echo '<p><strong>There is no field</strong></p>';
                        echo '<br/>';
                    }
                }
            }
            ?>
        </code>
        </section>
    </article>


</div>
</div>



    }

}