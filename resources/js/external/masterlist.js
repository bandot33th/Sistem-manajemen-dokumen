// mastterlis js

document.addEventListener('DOMContentLoaded', () => {
    const updateButtons = document.querySelectorAll('.addmasterlist-slide-trigger');
    const formSection = document.getElementById('update-form');
    const backButton = document.getElementById('back-button');
    const tableContainer = document.querySelector('.table-container'); // Reference to the table container

    updateButtons.forEach(button => {
        button.addEventListener('click', () => {
            tableContainer.classList.remove('w-full');
            tableContainer.classList.add('w-2/3');
            formSection.classList.remove('hidden');
            formSection.classList.add('slide-in');
        });
    });

    backButton.addEventListener('click', () => {
        formSection.classList.add('hidden');
        tableContainer.classList.remove('hidden');
        tableContainer.classList.remove('w-2/3');
        tableContainer.classList.add('w-full');
    });
});

// tab button add masterlist dan dropdown
const buttons = document.querySelectorAll('.tab-button');


buttons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.stopPropagation();
        buttons.forEach(btn => btn.classList.remove('bg-sky-100', 'text-sky-600'));
        this.classList.add('bg-sky-100', 'text-sky-600');
    });
});

document.addEventListener('click', function() {
    buttons.forEach(btn => btn.classList.remove('bg-sky-100', 'text-sky-600'));
});

var maxFilesizeVal = 100;
var maxFilesVal = 500;

Dropzone.options.myDragAndDropUploader = {
    paramName: "file",
    maxFilesize: maxFilesizeVal, // MB
    maxFiles: maxFilesVal,
    resizeQuality: 1.0,
    acceptedFiles: ".csv,.xlsx",
    addRemoveLinks: false,
    timeout: 60000,
    dictDefaultMessage: `
        <div class="col-span-4">
            <div class="flex flex-col items-center justify-center pt-8 pb-8">
                <svg class="w-12 h-12 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
            </div>
            <span class="font-semibold">Click to upload Masterlist File</span><br>
                File needs to be XLXS (MAX. 100mb)
        </div>
    `,
    previewsContainer: "#myDragAndDropUploader", // Set preview container to the form itself
    dictFallbackMessage:
        "Your browser doesn't support drag and drop file uploads.",
    dictFileTooBig: "File is too big. Max filesize: " + maxFilesizeVal + "MB.",
    dictInvalidFileType:
        "Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed.",
    dictMaxFilesExceeded:
        "You can only upload up to " + maxFilesVal + " files.",
    maxfilesexceeded: function (file) {
        this.removeFile(file);
    },
    sending: function (file, xhr, formData) {
        $("#message").text("Image Uploading...");
    },
    init: function () {
        let finish = document.getElementById("finish-button");

        this.on("sending", function (file, xhr, formData) {

            finish.classList.add("hidden");
        });

        this.on("success", function (file, response) {
            finish.classList.remove("hidden");
        });
    },
    success: function (file, response) {
        $("#message").text(response.success);
        console.log(response.success);
        console.log(response);
    },
    error: function (file, response) {
        $("#message").text("Something Went Wrong! " + response);
        console.log(response);
        return false;
    },
};

// Reset the Dropzone container when the button is clicked
document.querySelectorAll('.resetButton').forEach(function(button) {
    button.addEventListener('click', function() {
        const dropzoneForm = document.querySelector('#myDragAndDropUploader');

        dropzoneForm.reset();
        Dropzone.forElement(dropzoneForm).removeAllFiles();

        const messageContainer = document.querySelector('.default-message');
        if (messageContainer) {
            messageContainer.innerHTML = `
                <svg class="w-12 h-12 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <span class="font-semibold">Click to upload</span> or drag and drop<br>
                PDF, DOCX, or XLXS (MAX. 100mb)
            `;
        }
    });
});
