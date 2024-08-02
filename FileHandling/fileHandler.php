<?php

// $dir = "/var/www/localhost/htdocs/videos/";

include("VideoLister.php");

$videoLister = new VideoLister();

if (isset($_GET["deleteVideo"]) || isset($_GET["deleteImage"])) {
    // Make sure the files being deleted are valid
    if (str_contains($_GET["deleteVideo"], ".mp4") || str_contains($_GET["deleteVideo"], ".m4a") && str_contains($_GET["deleteImage"], ".webp")) {
        unlink($_GET["deleteVideo"]);
        unlink($_GET["deleteImage"]);
    }
}

if (isset($_GET["download"])) {
    $folder = str_contains($_GET["format"], "mp4") ? "/Videos" : "/Music";
    exec("cd $videoLister->searchDirectory/$folder && yt-dlp -f $_GET[format] --write-thumbnail $_GET[download] -k");

    $videoLister->videoOutput();
}
