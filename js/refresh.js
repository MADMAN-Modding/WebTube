setInterval(function () {
    var xhrRefresh = new XMLHttpRequest;

    // Sends the download request
    xhrRefresh.open('GET', 'web/FileHandling/fileHandler.php?refresh=" "');

    // Send the request 
    xhrRefresh.send();
}, 1000);