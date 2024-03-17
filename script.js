/* document.getElementById("uploadLink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default behavior of the link
    uploadToDatabase();
});

function uploadToDatabase() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "upload.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                console.log("Data uploaded successfully");
            } else {
                console.error("Error:", xhr.statusText);
            }
        }
    };
    xhr.send(); // Send the request
}
 */