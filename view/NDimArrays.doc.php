<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
<style>    article {
        font-family: 'Noto Sans', sans-serif;
    }
            div article {
                margin: 4%;
            }
            h1 {font:700;
                font-size:x-large;
            }
            h2 {font:500;
                font-size:larger;
            }
            h3 {font:300;
                font-size:medium;
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
    <article class="library-description" id="doc_NDimArrays">
        <?php require('../bootstrap/init.php');
        ?>
        <header>
            <h1 itemprop="headline">The n_dim_array & cognate classes</h1>
            <p><time itemprop="datePublished" datetime="2017-07-23">erstellt am: 23.07.2017</time></p>
            <i> convenience wrapper for n-dimensional nested arrays</i>
            <p><code>namespace model\chess\arrays;</code></p>
        </header>
        <section class="code-overview" id="construct">
            <code class="code_example"></code>
            <h2 >__construct</h2>
            <p>produces a empty renctengular array, of the size <code>integer<sub>0</sub> * integer<sub>1</sub> * ... * integer<sub>n</sub> </code>, with <code>n<sub>max</sub> = const maxDim = 6;</code> in configuration file.</p>
            <p>The <code>const MAX_DIM</code> and <code>const MAX_V</code> are necessary for performance issues. A error message is thrown if <code>max_x</code> is exceeded</p>
            <p>
                <code class="code_example">$to_big_array = new \model\chess\arrays\NDimArrays(1,2,3,4,5,6,7,17, -1);</code>
            </p>
            <?php
                $to_big_array = new \model\chess\arrays\NDimArrays(1,2,3,4,5,6,7,17, -1);
            ?>
            <p>... but initiazised properly will return an empty nested array:</p>
            <p>
                <code class="code_example">$array_2_3 = new \model\chess\arrays\NDimArrays(2,3);</code>
            </p>
            <p>
                <code class="code_example">print_r($array_2_3->getSkeleton());</code>
            </p>
            <code class="code_output">
                <?php

                    $array_2_3 = new \model\chess\arrays\NDimArrays(2,3);
                    var_dump($array_2_3->getSkeleton());
                    var_dump($array_2_3->getPosVector());
                ?>
                </code>
            <p>Now that is an empty array with the keys being that of the lowest dimension</p>
            </section>
        <section>
            <h2>The PutFieldsOnArray class</h2>
            <i>Performs recursiv logic on NDimArrays (and only on them)</i>
            <p>
                <code class="code_example">namespace controller\game_controller\arrays;</code>
            </p>
            <p>This class puts GameField objects into the empty array. Since we don't know the desired depth of the nested array in advance, we have to use recursive iteration. We know the extend of the array at excecution time though - so we can use an position vector and pointer instead of testing each node we pass.</p>
            <p>This is implemented as a Depth-first search (
<a href="https://en.wikipedia.org/wiki/Depth-first_search" target="_blank">en.wikipedia.org/wiki/Depth-first_search</a>). An outer loop visits the nodes and calls the function itself and an inner loop puts the GameFields with <code>GameField::position</code> as n-dimensional position vector.</p>
            <p>The recursive function itself is protected and be asscessesd with the static function PutFieldsOnArray::excecute() which only takes NDminArrays as arguments: </p>
            <p>
                <code class="code_example">
                    \controller\game_controller\arrays\PutFieldsOnArray::excecute($array_2_3);
                </code>
            </p>
            <p>
                <code class="code_example">
                    \controller\game_controller\arrays\PutFieldsOnArray::excecute($array_1_1_1);
                </code>
            </p>
            <p>
                <code class="code_output">
                    <?php
                    $array_1_1_1 = new \model\chess\arrays\NDimArrays(2,1,2);

                    \controller\game_controller\arrays\PutFieldsOnArray::excecute($array_2_3);
                    \controller\game_controller\arrays\PutFieldsOnArray::excecute($array_1_1_1);

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
                Giving less arguments than
                <code>NDimArrays::n_dim</code>will return an array, if equal arguments the content of the field, and if more, throw an error:
            </p>
            <p>
                <code class="code_example">
                    var_dump($array_2_3->select([1], $array_2_3->getNestedArray()));
                </code>
            </p>
            <p>
                <code class="code_example">
                    var_dump($array_2_3->select([0,0], $method = 'nested_array'));
                </code>
            </p>
            <p>
                <code class="code_output">
                    <?php
            var_dump($array_2_3->select([1],'nested_array'));
            var_dump($array_2_3->select([0,0], 'nested_array'));
                    ?>
                    </code>
                </p>

        </section>
            </article>
    <time datetime="2017-07-25" id="last-edit">#LAST EDIT 25-07-2017</time>
</div>