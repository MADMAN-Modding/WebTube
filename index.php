<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8" lang="en">

<head>
  <title>Web YT-DLP</title>
  <link type="text/css" rel="stylesheet" href="css/index.css" />
</head>

<body>
  <h1>Welcome to Web YT-DLP</h1>
  </head>

  <body>
    <form method="post">
      <input type="text" name="url" id="downloader">
      <p> Enter the url of the video</p>
    </form>
    <?php

    // Change for your use
    // mkdir("videos");
    mkdir("/var/www/localhost/htdocs/videos");

    // I know, I should filter
    if (isset($_POST["url"])) {
      exec("cd Videos/ && yt-dlp -f mp4 $_POST[url]");
    }
    if ($videoFinder = opendir('videos/')) {

      // Makes the videpList array
      $videoList = [];

      // Reads the directory till the end
      while (false !== ($video = readdir($videoFinder))) {
        // Adds each video to the list
        $videoList[] = $video;
      }

      // Removes . and .. from the array
      array_splice($videoList, 0, 2);

      // Closes the directory to save resources
      closedir($videoFinder);

      // Alphabetically sorts the consoles
      natsort($videoList);
    }

    echo "<div id=\"videos\">";

    foreach ($videoList as $video) {
      echo "<h3 class=\"video\" id=\"$video\">$video<a href=\"videos/$video\" download><img src=\"images/Download Button.png\" class=\"download\"/></a><img src=\"images/Trash Button.png\" id=\"delete\" class=\"delete\" onclick=\"fileDelete('$video')\"/></h3><br> ";
    }

    echo "</div>";
    ?>
  </body>
  <script src="js/index.js"></script>

  </html>