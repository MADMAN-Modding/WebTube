// Makes the xhr object for the XMLHttpRequest class
var xhr = new XMLHttpRequest();

function fileDelete(file) {



    let fileType;

    // Checks to see what to replace the file type with for the image
    if (file.endsWith("mp4")) {
        fileType = "mp4";
    } else {
        fileType = "m4a";
    }

    console.log(file);

    // Sends the delete request
    xhr.open('GET', 'FileHandling/fileHandler.php?deleteVideo=' + file + '&deleteImage=' + file.replace(fileType, "webp"));

    // Send the request 
    xhr.send();

        // Calls the refresh function
    xhrRefresh("videos");
}

function fileDownload() {
    // Sends the download request
    xhr.open('GET', 'FileHandling/fileHandler.php?download=' + document.getElementById('downloader').value + "&format=" + document.getElementById("format").value);

    // Send the request 
    xhr.send();

    // Clears the form
    document.getElementById('downloader').value = "";

        // Calls the refresh function
    xhrRefresh("videos");
}

function xhrRefresh(id) {
    var xhr = new XMLHttpRequest();
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

    xhr.open('GET', 'FileHandling/VideoLister.php');

    // Send the request 
    xhr.send();
}

function mkDir() {
    xhr.open('GET', 'FileHandling/directoryMaker.php?directory=' + document.getElementById('directory').value);
    xhr.send();
}

// To run on the page load, wahoo
xhrRefresh("videos");

xhr.open('GET', 'FileHandling/VideoLister.php');

xhr.send();