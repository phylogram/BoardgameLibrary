<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 25.08.2017
 * Time: 17:28
 */

namespace view;


class HomepageAND404
{
    public static function show($error_message)
    {
        echo <<<OUTPOUT
 <article class="pure-u-20-24" id="doc_IteratorClasses" style="margin-left: 2%; margin-top: 1px;">
 <script>$( window).keypress(function( event ) {
  if ( event.which == 39 ) {
     window.open( 'http://boardgame.dev/videogames' , '_self');
  }

if (event.which == 37) {
window.open( '#', '_self');
}});</script>
                <header>
            <h1 itemprop="headline">Swinging NDim Board Games</h1>

           
        </header>
        
         <img class="CHESSSTART" src="pictures/schachbrett.svg">
         
         <img class="CHESSSTART" src="pictures/videoGamesTuring.png" >
         <embed 
         
 </article>
        

OUTPOUT;


    }
}