<?php

$videoLister = new VideoLister();

$videoLister->videoOutput();

class VideoLister
{
    public $row = false;

    public $searchDirectory = "../videos/";

    public $mediaDirectory = "../videos/";

    function videoOutput()
    {
        // Scans the videos
        if ($videoFinder = opendir($this->searchDirectory)) {

            // Makes the videoList array
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
            $fileSize = filesize("$this->searchDirectory/$videoList[$i]");
            if ($fileSize >= 1073741824) {
                $fileSize = ((int) (($fileSize / 1073741824) * 100)) / 100;
                $dataValue = "GiB";
            } else {
                $fileSize = ((int) (($fileSize / 1048576) * 100)) / 100;
                $dataValue = "MiB";
            }

            // Gets rid of illegal characters cause they're annoying
            $illegalChars = array("'", "\"", "&");

            $videoOldName = $videoList[$i];

            $videoNewName = str_replace($illegalChars, "", $videoList[$i]);

            rename("$this->searchDirectory/$videoOldName", "$this->searchDirectory/$videoNewName");

            if ($i + 1 % 5 === 0 && !$this->row && $i != 0) {
                echo "</div>";
                $this->row = true;
            }

            if ($i % 3 === 0 && $this->row || $i == 0) {
                echo "<div class=\"row\">\n";
                $this->row = false;
            }

            if (str_contains($videoNewName, ".mp4")) {
                $this->load(".mp4", $videoNewName, $fileSize, $dataValue);
            } else if (str_contains($videoNewName, ".m4a")) {
                $this->load(".m4a", $videoNewName, $fileSize, $dataValue);
            }
        }
    }

    function load(String $format, String $video, int $fileSize, String $dataValue)
    {
        echo "<div class=\"col-sm-4\">\n";
        // echo "<div class=\"videoContainer\">";
        echo "<a href=\"$this->mediaDirectory/$video\" target=\"_blank\"><img src=\"$this->mediaDirectory/" . str_replace($format, ".webp", $video) . "\" class=\"thumbnail img-fluid\" width=\"400px\"></a>\n";

        // Echos the data and buttons for file handling, also changes the video name to look nice
        echo "<h4 class=\"video\" id=\"$video\">" . substr(str_replace($format, "", $video), 0, -13) . "| $fileSize $dataValue <a href=\"videos/$video\" download><img src=\"images/Download Button.png\" class=\"download\"/></a>
            <img src=\"images/Trash Button.png\" id=\"delete\" class=\"delete\" onclick='fileDelete(\"$video\")'/></h4> \n";
        // echo "</div>";
        echo "</div>";
    }


    function fileSizeCalc($videoFile)
    {
        // Gets the file size in GB with two decimal places 
        $fileSize = filesize("$this->searchDirectory/$videoFile");
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
