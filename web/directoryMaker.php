<?php
    include("fileHandler.php");

    $handler = new FileHandler();

    $illegalChars = ["\\", "/", "$", "&", "\"", "'"];

    $directory = str_ireplace($illegalChars, "", $_GET["directory"]);

    mkdir("videos/" . $directory);

    $handler->videoOutput();