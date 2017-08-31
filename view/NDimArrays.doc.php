
    <article class="pure-u-20-24" id="doc_NDimArrays">

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
