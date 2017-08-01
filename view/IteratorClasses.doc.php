<!<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous" />
<style>
    article {
        font-family: 'Noto Sans', sans-serif;
    }

    div article {
        margin: 4%;
    }

    h1 {
        font: 700;
        font-size: x-large;
    }

    h2 {
        font: 500;
        font-size: larger;
    }

    h3 {
        font: 300;
        font-size: medium;
    }

    .code_example {
        margin-left: 10%;
    }

    .code_output {
        -moz-column-count: 3 !important;
        column-count: 3 !important;
    }

    #last-edit {
        font-weight: 700;
        background-color: cornflowerblue;
    }

    .xdebug-error {
        font-size: 1.5em !important;
        width: 95% !important;
        margin: 2% auto 5% auto !important;
        border-color: rgb(6, 30, 34) !important;
        background-color: rgba(44, 76, 134, 0.83) !important;
    }

        .xdebug-error th, .xdebug-error td {
            padding: 1% !important;
        }

        .xdebug-error th {
            background: rgba(48, 185, 67, 0.64) !important;
        }

        .xdebug-error span {
            display: none !important;
        }

    .xdebug-error_description th {
        font-size: 1.2em !important;
        padding: 4% 1% 4% 10% !important;
        background: rgba(44, 76, 134, 0.83) no-repeat left top !important;
    }

    .xdebug-error_callStack th {
        background-color: rgba(44, 76, 134, 0.83) !important;
        color: #ddd !important;
    }
</style>

<div>
    <article class="library-description" id="doc_IteratorClasses">
        <?php require('../bootstrap/init.php');
        ?>
        <header>
            <h1 itemprop="headline">The Basic Iterator Classes</h1>
            <p>
                <time itemprop="datePublished" datetime="2017-07-31">erstellt am: 31.07.2017</time>
            </p>
            <i>pseudo generators to access the "neighboring" fields</i>
        </header>
        <section>
            <h2>The basic iterator - The SquareFunctionGenerator</h2>
            <figure>
                <img src="pictures/SquareWave.PNG" />
                <figcaption>https://en.wikipedia.org/wiki/Square_wave#/media/File:Waveforms.svg (edited)</figcaption>
            </figure>
            <p>The SquareFunctionGenerator class generates a ... square wave. This is usefull for example to generate the inner moves for a bishop:</p>
            <img src="pictures/BishopMatrix.PNG"/>
            <p><strong>Note: </strong> This documentation is about one-dimensional iterators, the examples are two-dimensional. This is covered in the special figure-iterators (#To Do: link), which can use as many iterators for each dimension they need. The chess examples here are just for illustration purposes.</p>

        </section>
        <section class="code-overview" id="construct">
            <h2>__construct</h2>
            <p>
                produces an pseudo-iterator, with
                <code>
                        peak
                        <sup>max</sup> = $upper_limit, peak
                        <sup>min</sup> = $lower_limit </code> and <code>
                        λ = $wavelength
                </code>
            </p>
            <p>Since we are iterating indexes all values are integers and therefore λ must be even (and positive).</p>
            <h2>API</h2>
            <p><code>SquareFunctionGenerator::generateCycle()</code> returns every time it is called an array of <code>$phase=>$value</code> and at the and of the cycle only <code>NULL</code></p>
            <p>
                <code class="code_example">
                    $square_1_minus_1_2 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, -1, 2);
                </code>
            </p>
            <p>
                <code class="code_example">
                    $output_array = array();
                </code>
            </p>
            <p>
            <code class="code_example">
                foreach(range(0, 7) as $i) {
            </code>
            </p>
            <p>
            <code class="code_example" style="padding-left: 4em;">
                $iterated_array = $square_1_minus_1_2->generateCycle();
                </code>
            </p>
            <p>
            <code class="code_example" style="padding-left:4em;">
                $output_array = array_merge($output_array, $iterated_array);
                </code>
            </p>
            <p>
            <code class="code_example" style="padding-left:4em;">
            }</code>
            </p>
            <p>
            <code class="code_example">
            var_dump($output_array);
                </code>
            </p>
            <p>
            <code  class="code_example">
                <?php
            $square_1_minus_1_2 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, -1, 2);
            $output_array = array();
            foreach(range(0, 7) as $i) {

                $iterated_array = $square_1_minus_1_2->generateCycle();
                if ($iterated_array) {
                    $output_array = array_merge($output_array, $iterated_array);
                }
            }
            var_dump($output_array);
            #To Do: Visual represantation
                ?>

            </code>
                </p>
            <p>While <code>SquareFunctionGenerator::generateWave()</code> is able to being called at arbritrary times:</p>
            <p>
                <code class="code_example">
                    <?php
                    $square_1_minus_1_2->setPhase(0);

                    $output_array = array();
                    foreach(range(0, 7) as $i) {

                        $iterated_array = $square_1_minus_1_2->generateWave();
                        if ($iterated_array) {
                            $output_array = array_merge($output_array, $iterated_array);
                        }
                    }
                    var_dump($output_array);
                    #To Do: Visual represantation
                    ?>
                </code>
            </p>
            <p>It is possile to calculate the value for an arbritrary phase even when current is not at that phase with: <code>SquareFunctionGenerator::getStateAtPhase($phase = 'current')</code></p>
            <p>Changing the wavelength to 4 will result in the following: </p>
            <code class="code_example">
                <?php
                $square_1_minus_1_4 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, -1, 4);
                $output_array = array();
                foreach(range(0, 7) as $i) {

                    $iterated_array = $square_1_minus_1_4->generateWave();

                    if ($iterated_array) {
                        $output_array = array_merge($output_array, $iterated_array);
                    }
                }
                var_dump($output_array);
                #To Do: Visual represantation
                ?>
            </code>
            <p>It is possible to get and set all the properties of the class.</p>
            <p>Changing the amplitude of the function between calls (++/--) will result in</p>
            <code class="code_example">
                <?php
                $square_1_minus_1_2->setPhase(0);
                $output_array = array();
                foreach(range(0, 7) as $i) {

                    $iterated_array = $square_1_minus_1_2->generateWave();
                    # get Values
                    $current_upper = $square_1_minus_1_2->getUpperLimit();
                    $current_lower = $square_1_minus_1_2->getLowerLimit();

                    # change values
                    $square_1_minus_1_2->setUpperLimit($current_upper+1);
                    $square_1_minus_1_2->setLowerLimit($current_lower-1);

                    if ($iterated_array) {
                        $output_array = array_merge($output_array, $iterated_array);
                    }
                }
                var_dump($output_array);
                #To Do: Visual represantation
                ?>
            </code>
            <p>and changing the wavelength between 4 and 2 (has to be even) every iteration (with ... you guess it: another SquareFunction) will result in</p>
            <code class="code_example">
                <?php
                $square_4_2_2 = new \controller\game_controller\iterators\SquareFunctionGenerator(4, 2, 2);

                $square_1_minus_1_2->setLowerLimit(-1);
                $square_1_minus_1_2->setUpperLimit(1);
                $square_1_minus_1_2->setPhase(0);
                $output_array = array();
                foreach(range(0, 7) as $i) {
                    $current_array = $square_4_2_2->generateWave();
                    $new_wavelength = array_pop($current_array);

                    $iterated_array = $square_1_minus_1_2->generateWave();

                    # change values
                        $square_1_minus_1_2->setWaveLength($new_wavelength);


                    if ($iterated_array) {
                        $output_array = array_merge($output_array, $iterated_array);
                    }
                }
                var_dump($output_array);
                #To Do: Visual represantation
                ?>
            </code>
</section>
        <section>
            <h2>The TriangleFunctionGenerator</h2>
            <p>Let's take a look how the knight can move:</p>
            <img src="pictures/knightMatrix.PNG" />
            <p>which can be seen as Triangle-Function: </p>
            <figure>
                <img src="pictures/TriangleWave.PNG" />
                <figcaption>https://en.wikipedia.org/wiki/Square_wave#/media/File:Waveforms.svg (edited)</figcaption>
            </figure>
            <p>adding two shifted square functions will result in a triangle function</p>
            <p>
                <code class="code_example">
                    $square_1_0_2_phase_0 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, 0, 4, 0);
                </code>
            </p>
            <p>
                <code>
                    $square_1_0_2_phase_1 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, 0, 4, 1);
                </code>
            </p>
            <p>with <code>$upper_value = $upper_value<sub>0</sub> + $upper_value<sub>1</sub></code> as well as with <code>$lowe_value</code></p>
            <p>
                <code class="code_output">
                    <?php
                    $square_1_0_2_phase_0 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, 0, 4, 0);
                    $square_1_0_2_phase_1 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, 0, 4, 1);

                    foreach (range(0,7) as $main_phase) {
                        $current_left = $square_1_0_2_phase_0->generateWave();
                        $left = array_pop($current_left);

                        $current_right = $square_1_0_2_phase_1->generateWave();
                        $right = array_pop($current_right);
                        $right_phase = $main_phase + 1;

                        $summand = $left + $right;
                        echo "<p>main (left) phase $main_phase, left value: $left; right phase: $right_phase, right value: $right; summand = $summand </p>";
                    }
                    ?>
                </code>
            </p>
        </section>
        <section>
            <h2>The Triangle</h2>
                <code class="code_output">
                    <?php
                    $triangle_0121 = new \controller\game_controller\iterators\TriangleFunctionGenerator([1, 0, 4, 0], [1, 0, 4, 1]);
                    
                    foreach (range(0,7) as $phase) {
                        $current = $triangle_0121->generateWave();
                        echo "<p>phase: $phase, value: $current</p>";
                    }
                    ?>
                </code>
            </p>
        </section>
    </article>
    <time datetime="2017-07-31" id="last-edit">#LAST EDIT 31-07-2017</time>
</div>