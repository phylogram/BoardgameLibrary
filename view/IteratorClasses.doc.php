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
            background: rgb(46, 43, 70) !important;
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
            <i>pseudo generators to access the "neighboring" fiels</i>
        </header>
        <section>
            <h2>The basic iterator</h2>
            <figure>
                <img src="pictures/SquareWave.PNG" />
                <figcaption>https://en.wikipedia.org/wiki/Square_wave#/media/File:Waveforms.svg (edited)</figcaption>
            </figure>
            <p>The SquareFunctiongenerator class generates a ... square wave. This is usefull for example to generate the inner moves for a bishop:</p>
            <img src="pictures/BishopMatrix.PNG"/>
            <p><strong>Note: </strong> This documentation is about one-dimensional iterators, the examples are two-dimensional. This is covered in the special figure-iterators (#To Do: link). The chess examples here are just for illustration purposes.</p>

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
            <p>
            <code class="code_example">
            $square_1_minus_1_2 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, -1, 2); </code></p><code class="code_example">            $output_array = array();</code></p><code class="code_example">
            foreach(range(0, 8) as $i) {</code></p><code class="code_example">
                $iterated_array = $square_1_minus_1_2->generateCycle();</code></p><code class="code_example">
                $output_array = array_merge($output_array, $iterated_array);</code></p><code class="code_example">
            }</code></p><code class="code_example">
            echo '<p>', implode(', ', $output_array) . '</p>';</code></p><code class="code_example">
            <?php
            $square_1_minus_1_2 = new \controller\game_controller\iterators\SquareFunctionGenerator(1, -1, 2);
            $output_array = array();
            foreach(range(0, 8) as $i) {
                $iterated_array = $square_1_minus_1_2->generateCycle();
                $output_array = array_merge($output_array, $iterated_array);
            }
            echo '<p>', implode(', ', $output_array) . '</p>';
            ?>
</section>
    </article>
    <time datetime="2017-07-31" id="last-edit">#LAST EDIT 31-07-2017</time>
</div>