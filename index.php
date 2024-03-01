<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
  <title>Web YT-DLP</title>
  <!--Bootstrap5-->
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  <link type="text/css" rel="stylesheet" href="css/index.css" />
</head>

<body>
  <h1>Welcome to Web YT-DLP</h1>
  <input type="text" name="url" id="downloader">
  <p> Enter the url of the video</p>
  <button onclick="fileDownload()">Download!</button>
  <?php

  // Change for your use and in fileHandler.php
  // $dir = "/var/www/localhost/htdocs/videos";
  $dir = "videos";

  mkdir($dir);
  ?>

  <div id="videos">
  </div>
  <script src="js/index.js"></script>

  
</body>

</html>