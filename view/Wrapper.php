<?php
namespace view;

class Wrapper
{
    public static function header(): string
    {
        $output_html = <<<OUTPUT
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/base/jquery-ui.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

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
    .code_example .inside {
        margin: 0%;
        border-radius: 0%;
        background-color: rgba(197,176,176, 0);
    }

    .pure-menu-horizontal {
        border-color: rgb(12, 60, 64);
        border-bottom-style: solid;
        border-width: 2px;
        background-color: rgba(172,181,214,0.09);
    }

    html {
        background-color: rgba(202,213,251,0.07);
    }

    code {
        font-family: "Cambria Math";
        color: rgba(1,4,4,0.89)
    }

    figcaption {
        font-family: "Cambria Math";
        font-size: smaller;
        padding-top: ;
    }
    
    .LOGO {
        height: 4em;
        text-align: center;
        padding: 0.5em 1em; 
    }
    
    .CHESSSTART {
        text-align: left;
        padding-top: 2em;
        
    }
    
    .pure-menu-item pure-menu-selected {
        text-align: right;
    }
    .pure-u-20-24 {
    margin-left: 2%;
    margin-top: 1px;
    }
    
        .cls-1{
            stroke:#000;
            stroke-miterlimit:10;
        }
        .cls-1 .black {
        fill:#000;
        stroke-width:0px;
        }
        .cls-1 .white {
            fill: #fff;
            stroke-width: 1.5px;
        }
    </style>
</head><body>
<div class="pure-g">
    

    
<div class="pure-menu pure-menu-horizontal pure-u-22-24">
    <ul class="pure-menu-list">
        <li class="pure-menu-item pure-menu-selected"><a href="/" class="pure-menu-link">The N-Dim Board Game Library</a></li>
        <li class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
            <a href="#" id="menuLink1" class="pure-menu-link">Play and Search</a>
            <ul class="pure-menu-children">
                <li class="pure-menu-item"><a href="/PlayExample" class="pure-menu-link">Play Example</a></li>
                <li class="pure-menu-item"><a href="/SelectBoard" class="pure-menu-link">database</a></li>
                <li class="pure-menu-item"><a href="Play" class="pure-menu-link">Play</a></li>
            </ul>
        </li>
        <li class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
            <a href="#" id="menuLink2" class="pure-menu-link">The Docs</a>
            <ul class="pure-menu-children">
                <li class="pure-menu-item"><a href="/NDimArrays" class="pure-menu-link">NDimArrays</a></li>
                <li class="pure-menu-item"><a href="/IteratorClasses" class="pure-menu-link">IteratorClasses</a></li>
                <li class="pure-menu-item"><a href="BoardFieldPiece" class="pure-menu-link">BoardFieldPiece</a></li>
            </ul>
        </li>
    </ul>
</div>
    
    
<div id="layout" class="pure-g">
    <div class="pure-u-2-24" style="background-color: #111112;">

        <img class="LOGO" src="pictures/Bauer_transparent.png" alt="Logo">

    </div>
OUTPUT;
        return $output_html;
    }
    public static function footer()
    {
        return <<<OUTPUT
</div>

</body></html>
OUTPUT;

    }
}