<?php

// $dir = "/var/www/localhost/htdocs/videos/";

$dir = "videos/";

if (isset($_GET["delete"])) {
    unlink($dir . $_GET["delete"]);
    videoOutput($dir);
}

if (isset($_GET["download"])) {
    exec("cd $dir && yt-dlp -f mp4 $_GET[download]");

    videoOutput($dir);
}

if (isset($_GET["refresh"])) {
    videoOutput($dir);
}

function videoOutput($directory)
{
    // Scans the videos
    if ($videoFinder = opendir($directory)) {

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
        // Gets rid of illegal characters cause they're annoying
        $illegalChars = array("'", '"', "&");

        $videoOldName = $video;

        foreach ($illegalChars as $char) {
            $video = str_replace($char, "", $video);
        }

        rename("videos/$videoOldName", "videos/$video");

        echo "<h3 class=\"video\" id=\"$video\">$video | ". fileSizeCalc($video) ."<a href=\"videos/$video\" download><img src=\"images/Download Button.png\" class=\"download\"/></a><img src=\"images/Trash Button.png\" id=\"delete\" class=\"delete\" onclick='fileDelete(\"$video\")'/></h3><br> ";

    }
}

function fileSizeCalc($videoFile)
{
    // Gets the file size in GB with two decimal places 
    $fileSize = filesize("videos/$videoFile");
    if ($fileSize >= 1073741824) {
        $fileSize = ((int) (($fileSize / 1073741824) * 100)) / 100;
        $dataValue = "GB";
    } else {
        $fileSize = ((int) (($fileSize / 1048576) * 100)) / 100;
        $dataValue = "MB";
    }

    return $fileSize . " " . $dataValue . " ";
}
