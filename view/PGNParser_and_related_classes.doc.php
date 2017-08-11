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
    <article class="library-description" id="doc_PGNParser_and_related_classes">
        <?php require('../bootstrap/init.php'); #To Do: write functions/classes for all that repeating stuff

        ?>
        <header>
            <h1 itemprop="headline">The PGNParser class and helper classes</h1>
            <p>
                <time itemprop="datePublished" datetime="2017-08-09">published: 09.08.2017</time>
            </p>
            <i>parse <a href="../Standard_ Portable Game Notation Specification and Implementation Guide.pdf" target="_blank">Portable Game Notation</a> files (including Standard Algebraic Notation [<a href="https://en.wikipedia.org/wiki/Algebraic_notation_(chess)" target="_blank">wiki</a>] into php arrays</i>
        </header>
    <p>The PGNParser class has to be initiated for each parsing process. <code>PGNParser::parse(str $string)</code> takes each line of the file as argument. The controlling class has to take care of file reading and delegating to database classes. Furthermore a lot of information in PGN has to be taken from context like which pieces at which fields are able to move to a field. So the controlling parser class has to actually play the game. <code>PGNParser::parse(str $string)</code> only returns a value when parsing of a game is concluded, else NULL. The return value is an array of</p>
        <p>
            <code class="code_example">
                array( 'Tags' => array('Unknown' => unknown tags as string, 'Event' => an event, 'Site', the site of the game, ... <br />
                &emsp; 'Moves' => array(<br />
                &emsp;&emsp;27 => array('color' => 0, 'start_position' => [0,0], 'target_position' => [3,0], 'Figure' => 'Rook', 'Kill' => true, 'error' => false));
            </code>
        </p>
    <p>There is no __construct() function, calling <code>$current_parser = new \model\chess\parser\PGNParser;</code> is sufficient.</p>
    <p>
        <code class="code_example">
        <?php
        $current_parser = new \model\chess\parser\PGNParser();
        ?>
        </code>
    </p>
    <p>Writing a PGN Parser algorithm could have been done with one big and complex regex which would have been hard to read and reuse. Instead most of the splitting and decision processes are achieved with simple php string functions
    </p>
        <p>Before any further processing however <code>PGNParse::parse()</code> will call the static method <code>\controller\SecureAndClean\SecureAndClean::convert()</code> to secure and clean the line, since it is external input.</p>
        <p>There are two types of main information. Tags for the whole game, like 'Site' or 'Result' and the moves in Algebraic standard notation.</p>
        <h1 id="Tags">Tags</h1>
        <p>If the $line starts with an '[' the public method <code>PGNParser::readTag($string)</code> is called. This is handled in the class internal, since this is not part of any other standard.</p>
        <p>Known tags are added to their respective keys, all other are added to the 'unknown' string</p>
        <p>
            <code class="code_example">
                $current_parser->readTag($example_tag);<br />
                &emsp;$resulting_tags = $current_parser->getTags()
            </code>
        </p>
        <p>
            <code class="code_output">
                <?php
                $example_tags = array(
                    'known_example_tag_one' => '[Event "Favoriten Chess Championship"] {Is this really an existing tournament?}',
                    'known_example_tag_two' => '[Site "1010 Vienna"]',
                    'unknown_example_tag_one' => '[Additional_activities "Poker"]',
                    'unknown_example_tag_two' => '[lost_figures "one knife"]',
                );
                foreach ($example_tags as $example_tag) {
                    $current_parser->readTag($example_tag);
                }
                $resulting_tags = $current_parser->getTags();

                foreach ($resulting_tags as $tag_name => $tag_value) {
                    echo "<p>Tag name: $tag_name, Tag value: $tag_value";
                }
                ?>
            </code>
            <h2>The Standard Algebraic Notation</h2>
        <p>If a line starts with a number and following period it is assumed the line initiates the move section. To parse SAN the SANParser class is called since this functionality can be used in different contexts.</p>

        </>
    <time datetime="2017-08-09" id="last-edit">#LAST EDIT 09-08-2017</time>
</div>

