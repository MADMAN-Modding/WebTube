<?php
include("VideoLister.php");

$videoLister = new VideoLister();

$illegalChars = ["\\", "/", "$", "&", "\"", "'"];

$directory = str_ireplace($illegalChars, "", $_GET["directory"]);

mkdir("../videos/" . $directory);

// mkdir("web/");

$videoLister->videoOutput();
