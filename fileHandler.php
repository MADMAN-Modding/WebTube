<?php

$video = $_GET["delete"];
// $video = $_GET["download"];

unlink("/var/www/localhost/htdocs/videos/" . $video);

echo "";