<?php

// $dir = "/var/www/localhost/htdocs/videos/";
$dir = "videos/";

$video = $_GET["delete"];

// $video = $_GET["download"];

unlink($dir . $video);

echo "";