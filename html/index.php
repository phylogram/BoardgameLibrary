<?php

require_once('../bootstrap/init.php');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>

        <?php
        \controller\client_action\routing\PersonalRouter::find();
        ?>


    
</body>
</html>