<?php

// $dir = "/var/www/localhost/htdocs/videos/";


$handler = new FileHandler();

if (isset($_GET["deleteVideo"]) || isset($_GET["deleteImage"])) {
    unlink($handler->directory . $_GET["deleteVideo"]);
    unlink($handler->directory . $_GET["deleteImage"]);
    $handler->videoOutput();
}

if (isset($_GET["download"])) {
    exec("cd $handler->directory && yt-dlp -f $_GET[format] --write-thumbnail $_GET[download]");

    $handler->videoOutput();
}

if (isset($_GET["refresh"])) {
    $handler->videoOutput();
}


class FileHandler
{
    public $row = false;

    public $directory = "videos/";

    function videoOutput()
    {
        // Scans the videos
        if ($videoFinder = opendir($this->directory)) {

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


        for ($i = 0; $i < count($videoList); $i++) {

            // Gets the file size in GB with two decimal places 
            $fileSize = filesize("videos/$videoList[$i]");
            if ($fileSize >= 1073741824) {
                $fileSize = ((int) (($fileSize / 1073741824) * 100)) / 100;
                $dataValue = "GiB";
            } else {
                $fileSize = ((int) (($fileSize / 1048576) * 100)) / 100;
                $dataValue = "MiB";
            }

            // Gets rid of illegal characters cause they're annoying
            $illegalChars = array("'", '"', "&");

            $videoOldName = $videoList[$i];

            // The variable video is used as it was used in a foreach loop and this was an easier fix
            foreach ($illegalChars as $char) {
                $video = str_replace($char, "", $videoList[$i]);
            }

            rename("videos/$videoOldName", "videos/$video");

            if ($i + 1 % 5 === 0 && !$this->row && $i != 0) {
                echo "</div>";
                $this->row = true;
            }

            if ($i % 3 === 0 && $this->row || $i == 0) {
                echo "<div class=\"row\">\n";
                $this->row = false;
            }

            if(str_contains($video, ".mp4")) {
                $this->load(".mp4", $video, $fileSize, $dataValue);
            } else if(str_contains($video, ".m4a")) {
                $this->load(".m4a", $video, $fileSize, $dataValue);
            }

        }
    }

    function load(String $format, String $video, int $fileSize, String $dataValue) {
                echo "<div class=\"col-sm-4\">\n";
                // echo "<div class=\"videoContainer\">";
                echo "<a href=\"$this->directory/$video\" target=\"_blank\"><img src=\"$this->directory/" . str_replace($format, ".webp", $video) . "\" class=\"thumbnail img-fluid\" width=\"400px\"></a>\n";

                // Echos the data and buttons for file handling, also changes the video name to look nice
                echo "<h4 class=\"video\" id=\"$video\">" . substr(str_replace($format, "", $video), 0, -13) . "| $fileSize $dataValue <a href=\"videos/$video\" download><img src=\"images/Download Button.png\" class=\"download\"/></a>
            <img src=\"images/Trash Button.png\" id=\"delete\" class=\"delete\" onclick='fileDelete(\"$video\")'/></h4> \n";
                // echo "</div>";
                echo "</div>";
            
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
}
