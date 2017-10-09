
    <article class="pure-u-20-24" id="doc_IteratorClasses" style="margin-left: 2%; margin-top: 1px;">

        <section>
    <h1>The Board, his fields and their pieces</h1>
            <p>The board, his fields and their pieces are closely interwoven. All actions are actually conducted by the conductor classes, which will be covered later. Note that none of this classes apply rules. They just inform, so that they can be overruled by the controlling class.</p>
            <h2>Putting a piece on the board</h2>
            <p>To keep it simple we will create a board of the size 5x5, which allows us to check if everything works.</p>
            <code class="code_example">$board_5x5 = new \model\game\arrays\ChessBoard([5, 5]);</code>
                <?php
                $board_5x5 = new \model\game\arrays\ChessBoard([5, 5]);
                ?>

            <p>We will create a queen to put on the field. For the moment we will do this by hand with the AnyFigure class. For constructing the class needs name that is unique for all pieces (for interacting with the view and jquery), a color (number), a Rule object, an AddExtraField object, and iterator signature. This is quite a lot - but will allow later to simply change features by data from the database or even a random generator. Let's go through them:</p>
            <p>We will create a queen called queen0 and with color 1 (black).</p>
            <code class="code_example">$color = 1;</code>
            <code class="code_example">$name = 'queen0';</code>

                <?php
                $color = 1;
                $name = 'queen0';
                ?>

            <p>The Rule object is an object which allows to reject fields in the iteration. The queen has the fewer or the same limitations as all other chess pieces, so we can apply the <code>ChessRule</code> class.</p>
            <code class="code_example">
                $rule = new \controller\game_controller\figures\ChessRule();
            </code>

                <?php
                $rule = new \controller\game_controller\figures\ChessRule();
                ?>

            <p>which is: She can't jump, that means she can move as long their is no other piece. She can't kill one of her own, but one of the opposite color.</p>
            <p>While the rule objects deny fields the AddExtraField objects ... adds extra fields ... In chess you need this for castling and for the first two steps of the pawns. However the queen has no such abilities. The grandfather of all these objects just never returns any value:</p>
            <code class="code_example">
                $addExtraField = new controller\game_controller\figures\addExtraField();
            </code>
            <?php
            $addExtraField = new controller\game_controller\figures\addExtraField();
            ?>
        </section>
        <p>Then we need the iteration signature as it is covered on the <a href="IteratorClasses.doc.php">Iterator classes page</a>. We can borrow the signature from the king, and make it sub-iterable</p>
        <code class="code_example">
            $queen_signature = new controller\game_controller\iterators\SignatureFigure(array(</code>
            <code class="code_example">new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),</code>
                <code class="code_example">new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),</code>
                    <code class="code_example">), 0, 2, 6,  true, 1)</code>

        </code>
        <?php
        $queen_signature = new controller\game_controller\iterators\SignatureFigure(array(
            new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
            new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
        ), 0, 2, 6,  true, 1);
        ?>

        <p>Now we can create the queen and ask her for name and color</p>
        <?php
        $queen = new \model\game\figures\AnyFigure(
                $name, $color, $rule, $addExtraField, $queen_signature
        );
        echo "<p>Name: {$queen->getName()} Color: {$queen->getColor()}</p>";
        ?>
        <code class="code_example">
            $queen = new \model\game\figures\AnyFigure(
            $name, $color, $rule, $addExtraField, $queen_signature
            );

        </code>
        <p>now we put the queen at row 0 and column 1:</p>
        <code class="code_example">$board_5x5->addFigure($queen, [0, 1]);</code>
        <?php
            $board_5x5->addFigure($queen, [0, 1]);
        ?>
        <p>The queen as well as the board should now be aware where she can move to. Let's test:</p>
        <code class="code_output">
        <?php
        foreach ($queen->getFieldsICanReach() as $phase => $fields) {
            echo "<p><strong>Phase: $phase</strong></p>";
            foreach ($fields as $field) {
                $position = implode(' | ', $field->getPosition());
                $field_on_array = $board_5x5->selectFromChessBoard($field->getPosition());
                $position_on_array = implode(' | ', $field_on_array->getPosition());
                $occupied = $field->isOccupied() ? '' : 'not';
                $occupied_board = $field_on_array->isOccupied() ? '' : 'not';
                echo "<p><strong>The queen says:</strong> Field at position $position is $occupied occupied || <strong>The board says:</strong> Field at position $position_on_array is $occupied_board occupied</p>";

            }
        }

        ?>
        </code>
        <p>Now let's move the queen. Therefore we have a move object and try it again</p>
        <code class="code_example">
            $move = new \model\game\figures\Move([0, 1], [2, 1]);
        </code>
        <code class="code_example">$queen->move($move);</code>
        <code class="code_output">
        <?php
        $move = new \model\game\figures\Move([0, 1], [2, 1]);
        $queen->move($move);


        foreach ($queen->getFieldsICanReach() as $phase => $fields) {
            echo "<p><strong>Phase: $phase</strong></p>";
            foreach ($fields as $field) {
                $position = implode(' | ', $field->getPosition());
                $field_on_array = $board_5x5->selectFromChessBoard($field->getPosition());
                $position_on_array = implode(' | ', $field_on_array->getPosition());
                echo "<p><strong>The queen says:</strong> Field at position $position <br/> <strong>The board says:</strong> Field at position $position_on_array </p>";

            }
        }
        ?>

        </code>
        <p>Now let's add a white king to the board and see if the queen can move beyond him and "kill" him.</p>
<code class="code_output">
    <?php
    #This actual king can't do castling and he can move into check
    $king_signature = new controller\game_controller\iterators\SignatureFigure(array(
        new controller\game_controller\iterators\Signature1Dim(0,1,8,6, 0),
        new controller\game_controller\iterators\Signature1Dim(-1,0,8,7, 1),
    ), 0, 2, 6,  false, 1);

    $king = new \model\game\figures\AnyFigure('king', !$color, $rule, $addExtraField, $king_signature);
    $board_5x5->addFigure($king, [2, 3]);

    $move = new \model\game\figures\Move($king->getPosition(), [2,2]);
    $king->move($move);

    foreach ($queen->getFieldsICanReach() as $phase => $fields) {
        echo "<p><strong>Phase: $phase</strong></p>";
        foreach ($fields as $field) {
            $position = implode(' | ', $field->getPosition());

            echo "<p><strong>Queen</strong> $position</p>";

        }
    }
    echo "<hr/>";
    foreach ($king->getFieldsICanReach() as $phase => $fields) {
        echo "<p><strong>Phase: $phase</strong></p>";
        foreach ($fields as $field) {
            $position = implode(' | ', $field->getPosition());

            echo "<p><strong>King:</strong> $position</p>";

        }
    }

    ?>
</code>
    </section
    </article>
