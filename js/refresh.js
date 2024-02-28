setInterval(function () {
    var xhrRefresh = new XMLHttpRequest;

    // Sends the download request
    xhrRefresh.open('GET', 'fileHandler.php?refresh=" "');

    // Send the request 
    xhrRefresh.send();
}, 1000);