<?php

$videoLister = new VideoLister();

$videoLister->videoOutput();

class VideoLister
{
    public $row = true;

    public $searchDirectory = "../videos";

    public $mediaDirectory = "../videos";

    public $directoryList = [];

    // List of videos with the full path
    public $videoList = [];

    // List of the videos without the full path
    public $niceNamesVideoList = [];

    public $niceNamesDirectoryList = [];

    function videoOutput()
    {
        $this->search($this->searchDirectory, 1);

        for ($i = 0; $i < count($this->directoryList); $i++) {
            echo "<h1>" . $this->niceNamesDirectoryList[$i] . "</h1>";

            $this->niceNamesVideoList = [];
            if ($videoFinder = opendir($this->directoryList[$i])) {
                // Reads the directory till the end
                while (false !== ($video = readdir($videoFinder))) {
                    // Adds each video to the list
                    if (str_contains($video, ".mp4") || str_contains($video, ".m4a")) {
                        $this->niceNamesVideoList[] = $video;
                        $this->videoList[] = $this->directoryList[$i] . "/" . $video;
                    }
                }

                // Alphabetically sorts the videos
                natsort($this->niceNamesVideoList);

                // Closes the directory to save resources
                closedir($videoFinder);

                $this->videoFilter();
            }
        }
    }

    function videoFilter()
    {
        for ($i = 0; $i < count($this->niceNamesVideoList); $i++) {

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

            rename("$this->directoryList/$videoOldName", "$this->directoryList/$videoNewName");

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
        if ($videoFinder = opendir($path)) {
            // Reads the directory till the end
            while (false !== ($video = readdir($videoFinder))) {
                // Adds each video to the list
                if ($video != "." && $video != ".." && is_dir("$path/$video")) {
                    $this->directoryList[] = "$path/$video";
                    $this->niceNamesDirectoryList[] = $video;
                    $this->search("$path/$video", $count + 1);
                }
            }

            // $this->videoFilter();

            // Alphabetically sorts the videos
            natsort($this->directoryList);

            // Closes the directory to save resources
            closedir($videoFinder);

            echo "</div>";
        }
    }
}
