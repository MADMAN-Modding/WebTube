<?php

$videoLister = new VideoLister();

$videoLister->videoOutput();

class VideoLister
{
    public $row = true;

    public $searchDirectory = "../videos";

    public $mediaDirectory = "../videos";

    public $videoList = [];

    // List of the videos without the full path
    public $niceNamesVideoList = [];

    function videoOutput()
    {
        $this->search($this->searchDirectory, 1);
    }

    function videoFilter()
    {
        for ($i = 0; $i < count($this->videoList); $i++) {

            // Gets the file size in GB with two decimal places 
            $fileSize = filesize($this->videoList[$i]);
            if ($fileSize >= 1073741824) {

                $fileSize = ((int) (($fileSize / 1073741824) * 100)) / 100;
                $dataValue = "GiB";
            } else {
                $fileSize = ((int) (($fileSize / 1048576) * 100)) / 100;
                $dataValue = "MiB";
            }

            // Gets rid of illegal characters cause they're annoying
            $illegalChars = array("'", "\"", "&");

            $videoOldName = $this->videoList[$i];

            $videoNewName = str_replace($illegalChars, "", $this->videoList[$i]);

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
                $this->load(".mp4", $videoNewName, $fileSize, $dataValue, $this->niceNamesVideoList[$i]);
            } else if (str_contains($videoNewName, ".m4a")) {
                $this->load(".m4a", $videoNewName, $fileSize, $dataValue, $this->niceNamesVideoList[$i]);
            }
        }
    }

    function load(String $format, String $video, int $fileSize, String $dataValue, String $niceName)
    {
        echo "<div class=\"col-sm-4\">\n";
        // echo "<div class=\"videoContainer\">";
        echo "<a href=\"$video\" target=\"_blank\"><img src=\"$this->mediaDirectory/" . str_replace($format, ".webp", $video) . "\" class=\"thumbnail img-fluid\" width=\"400px\"></a>\n";

        // Echos the data and buttons for file handling, also changes the video name to look nice
        echo "<h4 class=\"video\" id=\"$niceName\">" . substr(str_replace($format, "", $niceName), 0, -13) . "| $fileSize $dataValue <a href=\"videos/$video\" download><img src=\"images/Download Button.png\" class=\"download\"/></a>
            <img src=\"images/Trash Button.png\" id=\"delete\" class=\"delete\" onclick='fileDelete(\"$video\")'/></h4> \n";
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

    function search(String $path, int $count)
    {
        print_r($this->niceNamesVideoList);

        $this->videoList = null;
        $this->niceNamesVideoList = null;

        $this->videoList = [];
        $this->niceNamesVideoList = [];

        if ($videoFinder = opendir($path)) {
            // Reads the directory till the end
            while (false !== ($video = readdir($videoFinder))) {
                // Adds each video to the list
                if (str_contains($video, ".m")) {
                    $this->videoList[] = "$path/$video";
                    $this->niceNamesVideoList[] = $video;
                    // $this->load(".mp4", "$path/$video", "12", "GiB", $video);
                } else if ($video != "." && $video != ".." && !str_contains($video, ".webp")) {

                    echo "<h$count>$video</h1>";
                    $this->search("$path/$video", $count + 1);
                }
            }

            $this->videoFilter();

            // Alphabetically sorts the videos
            natsort($this->videoList);

            // Closes the directory to save resources
            closedir($videoFinder);
        }
    }
}
