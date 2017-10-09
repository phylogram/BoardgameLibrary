<?php

ini_set('html_errors', true);
set_time_limit(0);
ob_end_flush();
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
ob_implicit_flush(1);
$time = time();
echo 'start: ', date('H:i:s'), '<br>';
flush();
#this if only for internal use: so we set up a database
require_once '..\mogeuge.php';
$database = new mysqli(...$writer);
if ($database->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $database->connect_error;
}
$parse_to_database = new \controller\parser\ParsePGNIntoDatabase('..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'GMallboth.pgn' ,$database);
$parse_to_database->execute();

$time = time() - $time;

echo '<p><strong>', $parse_to_database->getGame(), ' games and ', $parse_to_database->getLine(), " lines parsed in $time seconds</strong></p>";