// Makes the xhr object for the XMLHttpRequest class
var xhr = new XMLHttpRequest();

function fileDelete(file) {

    // Calls the refresh function
    xhrRefresh(file);

    // Sends the delete request
    xhr.open('GET', 'fileHandler.php?delete=' + file);

    // Send the request 
    xhr.send();
}

function fileDownload() {

    // Calls the refresh function
    xhrRefresh("videos");

    // Sends the download request
    xhr.open('GET', 'fileHandler.php?download=' + document.getElementById('downloader').value);

    // Send the request 
    xhr.send();

    // Clears the form
    document.getElementById('downloader').value = "";
}

function xhrRefresh(id) {
    // Waits for a response from the xml and then sets the data to the correct value
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById(id).innerHTML =
                    xhr.responseText;
            } else {
                console.log('Error Code: ' + xhr.status);
                console.log('Error Message: ' + xhr.statusText);
            }
        }
    }
}