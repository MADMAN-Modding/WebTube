<?php

// $dir = "/var/www/localhost/htdocs/videos/";
$dir = "videos/";

if (isset($_GET["delete"])) {
    unlink($dir . $_GET["delete"]);
    echo "";
}

if (isset($_GET["download"])) {
    exec("cd $dir && yt-dlp -f mp4 $_GET[download]");

    // Scans the videos
    if ($videoFinder = opendir($dir)) {

        // Makes the videpList array
        $videoList = [];

        // Reads the directory till the end
        while (false !== ($video = readdir($videoFinder))) {
            // Adds each video to the list
            $videoList[] = $video;
        }

        // Alphabetically sorts the videos
        natsort($videoList);

        // Removes . and .. from the array
        array_splice($videoList, 0, 2);

        // Closes the directory to save resources
        closedir($videoFinder);
    }

    foreach ($videoList as $video) {
        echo "<h3 class=\"video\" id=\"$video\">$video<a href=\"videos/$video\" download><img src=\"images/Download Button.png\" class=\"download\"/></a><img src=\"images/Trash Button.png\" id=\"delete\" class=\"delete\" onclick=\"fileDelete('$video')\"/></h3><br> ";
    }
}
