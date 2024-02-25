<?php

$video = $_GET["delete"];
// $video = $_GET["download"];

unlink("videos/" . $video);

echo "";