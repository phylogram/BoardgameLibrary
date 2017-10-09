<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 31.08.2017
 * Time: 18:19
 */
if (isset($_SESSION['message'])) {
    var_dump( $_SESSION['message']);
} else {
    echo 'nada';
}