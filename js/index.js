function fileDelete(file) {

    // Instantiate an xhr object 
    var xhr = new XMLHttpRequest();

    // What to do when response is ready   
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById(file).innerHTML =
                    xhr.responseText;
            } else {
                console.log('Error Code: ' + xhr.status);
                console.log('Error Message: ' + xhr.statusText);
            }
        }
    }
    xhr.open('GET', 'fileHandler.php?delete=' + file);

    // Send the request 
    xhr.send();
}

// Might make this work idk

// function fileDownload(file) {
//     // Instantiate an xhr object 
//     var xhr = new XMLHttpRequest();



//     // What to do when response is ready   
//     xhr.onreadystatechange = () => {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 document.getElementById('videos').innerHTML = document.getElementById('videos').innerHTML +
//                     xhr.responseText;
//             } else {
//                 console.log('Error Code: ' + xhr.status);
//                 console.log('Error Message: ' + xhr.statusText);
//             }
//         }
//     }
//     xhr.open('GET', 'fileHandler.php?download=' + file);

//     // Send the request 
//     xhr.send();
// }

// setInterval(function () {
//     document.getElementById('downloadButton').onclick = "fileDownload(" + document.getElementById('downloader').value + ")";
//     console.log(document.getElementById('downloadButton').onclick)

// }, 100);