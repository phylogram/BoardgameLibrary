
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous" />
<style>
    img {
        height: 300px;
        margin: 15px;
    }

    .code_example {
        padding-left: 4em;
        display: block;
    }
    #To Do: Repair NDimSquare // Make phase-object // make NDim Triangle-Iterator // make Iterator-multiplyer //and yield value
    #To Do: repair the ndim array

</style>
<div class="pure-g">
<div class="pure-menu pure-menu-horizontal pure-u-22-24">
    <a href="http://boardgamelibrary.dev/" class="pure-menu-heading pure-menu-link">The N-Dim Board Game Library</a>

    <ul class="pure-menu-list">
        <li class="pure-menu-item"><a href="http://boardgamelibrary.dev/IteratorClasses.doc.php" class="pure-menu-link">Iterator Classes</a></li>
        <li class="pure-menu-item"><a href="http://boardgamelibrary.dev/NDimArrays.doc.php" class="pure-menu-link">NDimArrays</a></li>
    </ul>
</div>
</div>
<div id="layout" class="pure-g">
    <div class="pure-u-2-24" style="background-color: #111112;">

    </div>
    <article class="pure-u-20-24" id="doc_IteratorClasses" style="margin-left: 2%; margin-top: 1px;">
        <?php require('../bootstrap/init.php'); #To Do: Delete when imported by index.php
        ?>
        <header>
            <h1 itemprop="headline">The Basic Iterator Classes</h1>

            <i>pseudo generators to access the "neighboring" fields</i>
        </header>
        <section>
            <h2>The basic iterator - The SquareFunctionGenerator</h2>
            <figure>
                <img src="pictures/SquareWave.svg" />
                <figcaption>done with pyplot</figcaption>
            </figure>
            <p>The SquareFunctionGenerator class generates a ... square wave. This is useful for example to generate the inner moves for a bishop:</p>
            <figure>
                <img src="pictures/zugmöglichkeiten%20läufer.svg"/>
                <figcaption style="alignment: right">
                    <strong>R:</strong> -1, +1, -1, +1<br>
                    <strong>C:</strong> +1, -1, +1, -1
                </figcaption>
            </figure>

        </section>
        <section class="code-overview" id="construct">
            <h2>SquareFunctionGenerator::__construct()</h2>
            <p>
                produces an pseudo-iterator, with peak<sup>max</sup> = <code>$upper_limit</code>, peak<sup>min</sup> = <code>$lower_limit</code> and λ = <code>$wavelength</code>
            </p>
            <p>Since we are iterating indexes all values are integers and therefore λ must be even (and positive).</p>
            <h2>API</h2>
            <p>A waveform is described by some basic values, like upper and lower extrema, wavelength and phase at the beginning. This will be defined via the <code>Signature1Dim</code> object</p>
            <code class="code-example">
                $signature_1_m1 = new \controller\game_controller\iterators\Signature1Dim(1, -1, 2, 0, 0);
            </code>
            <p> Then we can initialize a Square Function Object with it:</p>
            <code class="code_example">
                $square_1_minus = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_1_m1);
            </code>
            <p><code>SquareFunctionGenerator::generateCycle()</code> returns every time it is called an array of <code>$phase=>$value</code> and at the and of the cycle only <code>NULL</code></p>
            <div class="code_output">
                <?php
                $signature_1_m1 = new \controller\game_controller\iterators\Signature1Dim(1, -1, 2, 0, 0);
                $square_1 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_1_m1);
                foreach(range(0, 3) as $line) {
                    $iterated_array = $square_1->generateCycle();
                    $output_html = \view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                    echo $output_html;
            }
                ?>
            </div>
            
            <p>While <code>SquareFunctionGenerator::generateWave()</code> is able to being called at arbitrary times:</p>
              
            <p>
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
            </p>
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
            <p>and changing the wavelength between 4 and 2 (has to be even) every odd iteration (with ... you guess it: another SquareFunction) will result in</p>
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
                        $new_wavelength = $control_array[$square_2->getPhase() - 1][$square_2->getDim()];

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
            <?php
            $signature_1020 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 2, 0, 0);
            $signature_0m121 = new \controller\game_controller\iterators\Signature1Dim(0, -1, 2, 1, 1);
            $two_dim_signature = new \controller\game_controller\iterators\SignatureNDim([$signature_1020, $signature_0m121], 0);
            $two_dim_square = new \controller\game_controller\iterators\NDimSquareFunctionGenerator($two_dim_signature);
            #To Do: debug: false values
            var_dump($two_dim_square);
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
                <img src="pictures/zugmöglichkeiten%20turm.svg"/>
                <figcaption style="alignment: right">
                    <strong>R:</strong> &nbsp;0, +1, &nbsp;0, -1<br>
                    <strong>C:</strong> +1, &nbsp;0, -1, &nbsp;0
                </figcaption>
            <p>which can be seen as Triangle-Function: </p>
            <figure>
                <img src="pictures/TriangleWave.svg" />
                <figcaption>done with pyplot</figcaption>
            </figure>
            <p>adding two shifted square functions will result in a triangle function</p>
                <code class="code_example">$signature_10400 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 4, 0, 0);</code>
                <code class="code_example">$signature_10411 = new \controller\game_controller\iterators\Signature1Dim(1, 0, 4, 1, 1);</code>
                <code class="code_example">$square_1_0_2_phase_0 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_10400);</code>
                <code class="code_example">$square_1_0_2_phase_1 = new \controller\game_controller\iterators\SquareFunctionGenerator($signature_10411);</code>

                <code class="code_example">$current_value = $square_1_0_2_phase_0->generateWave() + $square_1_0_2_phase_1->generateWave();</code>
                <code class="code_example">...</code>

            <p>with <code>$upper_value = $upper_value<sub>0</sub> + $upper_value<sub>1</sub></code> as well as with <code>$lowe_value</code></p>
            <p>
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
            </p>
        </section>
        <section>
            <h2>The TriangleFunctionGenerator</h2>
            <p>The TriangleFunctionGenerator extends the NDimSquareFunction Generator and adds up the (sub-)dimensions to a new single dimension</p>
            <code class="code_example">$two_dim_signature_2 = new \controller\game_controller\iterators\SignatureNDim([$signature_10400, $signature_10411], 0);</code>
            <code class="code_example">$triangle_0121 = new \controller\game_controller\iterators\TriangleFunctionGenerator($two_dim_signature_2);</code>

                <code class="code_output">
                    <?php
                    $two_dim_signature_2 = new \controller\game_controller\iterators\SignatureNDim([$signature_10400, $signature_10411], 0);
                    $triangle_0121 = new \controller\game_controller\iterators\TriangleFunctionGenerator($two_dim_signature_2);

                    foreach (range(0,7) as $line) {
                        $iterated_array = $triangle_0121->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>

            <p>The new wavelength is calculated as the least common multiple by reduction by the greatest common divisor (<a href="https://en.wikipedia.org/wiki/Least_common_multiple#Reduction_by_the_greatest_common_divisor" target="_blank">wiki</a>) and can be accessed with <code>TriangleFunctionGenerator::getWavelength()</code></p>
            <p>
                <code class="code_example">
                    <?php
                    echo $triangle_0121->getWaveLength();
                    ?>
                </code></p>
            <p>The value at a explicit state can be accessed by <code>TriangleFunctionGenerator::getStateAtPhase($phase)</code>, for example 3 and 2:</p>
            <p>
                <code class="code_output">
                <?php

                echo '<p>', $triangle_0121->getStateAtPhase(3)[3][$triangle_0121->getDim()], ' and ', $triangle_0121->getStateAtPhase(2)[2][$triangle_0121->getDim()], '</p>';
                ?>
                </code>            </p>
            <p>and again it is possible to retrieve just one cycle with <code>TriangleFunctionGenerator::generateCycle()</code></p>
            <p>
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
            </p>
            <p>As mentioned above it is possible to use an arbitrary number of generators like this:</p>
            <p>
                <code class="code_output">
                    <?php
                    $triangle_fun = new \controller\game_controller\iterators\TriangleFunctionGenerator([[0,1,6,0], [0,1,6,1], [0,1,6,2], [0,1,6,3]]);
                    echo '<p>Resulting wavelength: ', $triangle_fun->getWavelength(), '<p>';
                    foreach(range(0,11) as $line) {
                        $iterated_array = $triangle_fun->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>
            </p>

        </section>

        <section>
            <h2>Using combined square functions for knight and king</h2>
            <p>we can use combined square functions for knight and king. This are the possible movements of the king:</p>
            <img src="pictures/KingMatrix.PNG" />
            <p>We can add two SquareFunctions with a phase difference of 1:</p>
            <p>
                <code class="code_example">
                    $triangle_king = new \controller\game_controller\iterators\TriangleFunctionGenerator([0,1,8,6], [-1,0,8,7]);
                </code>
            </p>
            <p>and with <code>TriangleFunctionGenerator::generateCycle();</code> we can move exactly one time around.</p>
            <p>
                <code class="code_output">
                    <?php
                    $triangle_fun = new \controller\game_controller\iterators\TriangleFunctionGenerator([[0,1,8,6], [-1,0,8,7]]);
                    echo '<p>Resulting wavelength: ', $triangle_fun->getWavelength(), '<p>';
                    foreach(range(0,7) as $line) {
                        $iterated_array = $triangle_fun->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }

                    ?>
                </code>
            </p>
            <p>The knight has 4 possible values:</p>
            <img src="pictures/KnightMatrix.PNG" />
            <p>
            <code class="code_example">
                $triangle_knight = new \controller\game_controller\iterators\TriangleFunctionGenerator([-1,1,8,0], [-1,0,8,1], [0,1,8,2]);
                </code>
            </p>
            <p>and with <code>TriangleFunctionGenerator::generateCycle();</code> we can move exactly one time around.</p>
            <p>
                <code class="code_output">
                    <?php
                    $triangle_knight = new \controller\game_controller\iterators\TriangleFunctionGenerator([[-1,1,8,7], [-1,0,8,0], [0,1,8,6]]);
                    echo $triangle_fun->getWaveLength();
                    foreach(range(0,7) as $line) {
                        $iterated_array = $triangle_fun->generateWave();
                        $output_html = view\DimensionPhaseValue::printZeroOf2D($iterated_array, $line);
                        echo $output_html;
                    }
                    ?>
                </code>
            </p>
        </section>
    </article>
    <time datetime="2017-07-31" id="last-edit">#LAST EDIT 31-07-2017</time>
</div>
</div>
