import Dropzone from "dropzone";
import '../styles/dropzone.css';


// set the dropzone container id
const id = "#kt_dropzonejs_example_3";
const dropzone = document.querySelector(id);

// set the preview element template
const previewNode = dropzone.querySelector(".dropzone-item");
previewNode.id = "";
const previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

const myDropzone = new Dropzone(id, { // Make the whole body a dropzone
    url: "/dropzone", // Set the url for your upload script location
    maxFiles: 1,
    maxFilesize: .3, // Max filesize (300 Ko = 0.3 Mo)
    acceptedFiles: ".png, .jpg, .jpeg",
    previewTemplate: previewTemplate,
    previewsContainer: id + " .dropzone-items", // Define the container to display the previews
    clickable: "#dropzone-select" // Define the element that should be used as click trigger to select files.
});

myDropzone.on("addedfile", function (file) {
    // Hookup the start button
    const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
    dropzoneItems.forEach(dropzoneItem => {
        dropzoneItem.style.display = '';
    });
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function (progress) {
    const progressBars = dropzone.querySelectorAll('.progress-bar');
    progressBars.forEach(progressBar => {
        progressBar.style.width = progress + "%";
    });
});

myDropzone.on("sending", function (file) {
    // Show the total progress bar when upload starts
    const progressBars = dropzone.querySelectorAll('.progress-bar');
    progressBars.forEach(progressBar => {
        progressBar.style.opacity = "1";
    });
});

// Hide the total progress bar when nothing"s uploading anymore
myDropzone.on("complete", function (progress) {
    const progressBars = dropzone.querySelectorAll('.dz-complete');

    setTimeout(function () {
        progressBars.forEach(progressBar => {
            progressBar.querySelector('.progress-bar').style.opacity = "0";
            progressBar.querySelector('.progress').style.opacity = "0";
        });
    }, 300);
});

export {myDropzone}