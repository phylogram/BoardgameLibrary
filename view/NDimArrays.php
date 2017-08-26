
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous" />
<style>


    .code_example {
        padding-left: 4em;
        display: block;
        background-color: rgba(189,195,165,0.35);
        border-radius: 2%;
        margin: 4%;
    }

    .code_output {
        display: block;
        padding-left: 2em;
        background-color: rgba(197,176,176,0.42);
        border-radius: 2%;
        margin: 4%;
        column-count: 2; !important;

    }

    .pure-menu-horizontal {
        border-color: rgba(21,14,27,0.92);
        border-bottom-style: solid;
        border-width: 2px;
        background-color: rgba(172,181,214,0.09);
    }

    html {
        background-color: rgba(202,213,251,0.07);
    }

    code {
        font-family: "Cambria Math";
        color = rgba(1,4,4,0.89)
    }

    figcaption {
        font-family: "Cambria Math";
        font-size: smaller;
        padding-top: ;
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

        <img src="pictures/LOGO.png" style="margin-left: auto; margin-right: auto; display: block;">

    </div>
    <article class="pure-u-20-24" id="doc_NDimArrays">
        <?php require('../bootstrap/init.php');
        ?>
        <header>
            <h1 itemprop="headline">The n_dim_array & cognate classes</h1>

            <i> convenience wrapper for n-dimensional nested arrays</i>
            <p><code>namespace model\chess\arrays;</code></p>
        </header>
        <section class="code-overview" id="construct">
            <code class="code_example"></code>
            <h2 >__construct</h2>
            <p>produces a empty rectangular array, of the size <code>integer<sub>0</sub> * integer<sub>1</sub> * ... * integer<sub>n</sub> </code>, with <code>n<sub>max</sub> = const maxDim = 6;</code> in configuration file.</p>
            <p>The <code>const MAX_DIM</code> and <code>const MAX_V</code> are necessary for performance issues. A error message is thrown if <code>max_x</code> is exceeded</p>
                <code class="code_example">$to_big_array = new \model\game\arrays\NDimArrays(1,2,3,4,5,6,7,17, -1);</code>
            <code class="code_output">
            <?php
                $to_big_array = new \model\game\arrays\NDimArrays(1,2,3,4,5,6,7,17, -1);
            ?>
            </code>
            <p>... but initiated properly will return an empty nested array:</p>
            <code class="code_example">$array_2_3 = new \model\game\arrays\NDimArrays(2,3);</code>
            <code class="code_example">var_dump($array_2_3->getSkeleton());</code>
            <code class="code_output">
                <?php

                    $array_2_3 = new \model\game\arrays\NDimArrays(2,3);
                    var_dump($array_2_3->getSkeleton());
                ?>
                </code>
            <p>Now that is an empty array with the keys being that of the lowest dimension</p>
            </section>
        <section>
            <h2>The PutFieldsOnArray class</h2>
            <i>Performs recursive logic on NDimArrays (and only on them)</i>
                <code class="code_example">namespace controller\game_controller\arrays;</code>
            <p>This class puts GameField objects into the empty array. Since we don't know the desired depth of the nested array in advance, we have to use recursive iteration. We know the extend of the array at excecution time though - so we can use an position vector and pointer instead of testing each node we pass.</p>
            <p>This is implemented as a Depth-first search (
<a href="https://en.wikipedia.org/wiki/Depth-first_search" target="_blank">en.wikipedia.org/wiki/Depth-first_search</a>). An outer loop visits the nodes and calls the function itself and an inner loop puts the GameFields with <code>GameField::position</code> as n-dimensional position vector.</p>
            <p>The recursive function itself is protected and be asscessesd with the static function PutFieldsOnArray::excecute() which only takes NDminArrays as arguments: </p>

                <code class="code_example">
                    \controller\game_controller\arrays\PutFieldsOnArray::execute($array_2_3);
                </code>

                <code class="code_example">
                    \controller\game_controller\arrays\PutFieldsOnArray::execute($array_1_1_1);
                </code>

                <code class="code_output">
                    <?php
                    $array_1_1_1 = new \model\game\arrays\NDimArrays(2,1,2);

                    \controller\game_controller\arrays\PutFieldsOnArray::execute($array_2_3);
                    \controller\game_controller\arrays\PutFieldsOnArray::execute($array_1_1_1);

                    var_dump($array_2_3->getNestedArray());
                    var_dump($array_1_1_1->getNestedArray())
                    ?>
                </code>
            </p>
        </section>
        <section class="code-overview" id="select">
            <h2>SELECTING</h2>
            <p>Selection is done with the recursive function NDimArrays::select</p>
            <p>
                Giving less arguments than <code>NDimArrays::n_dim</code>will return an array, if equal arguments the content of the field, and if more, throw an error:
            </p>

                <code class="code_example">
                    var_dump($array_2_3->select([1], $array_2_3->getNestedArray()));
                </code>


                <code class="code_example">
                    var_dump($array_2_3->select([0,0], $method = 'nested_array'));
                </code>

                <code class="code_output">
                    <?php
            var_dump($array_2_3->select([1],'nested_array'));
            var_dump($array_2_3->select([0,0], 'nested_array'));
                    ?>
                    </code>


        </section>
            </article>

</div>
</div>