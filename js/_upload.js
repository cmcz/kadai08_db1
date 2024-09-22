
$(document).ready(function() {

    //////// Image Slide ////////
    let slideIndex = 1;
    showSlides(slideIndex);

    // jQuery event listener for dot click
    $('.dot').click(function() {
        // Get the index of the clicked dot (1-based index)
        let index = $(this).index() + 1;
        currentSlide(index);
    });

    //////// Image Upload ////////
    const $imageInput = $('#image-input');
    const $previewContainer = $('#preview-container');
    let filesArray = [];

    // Handle file selection and preview
    $imageInput.on('change', function(event) {
        const files = event.target.files;
        $.each(files, function(index, file) {
            // Ensure the file is an image
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                // Event listener to load and display image preview
                reader.onload = function(e) {
                    const $previewBox = $('<div class="preview-box"></div>');
                    const $img = $('<img>').attr('src', e.target.result);
                    const $removeBtn = $('<button class="remove-btn">X</button>');

                    // Add event listener to remove button
                    $removeBtn.on('click', function() {
                        $previewBox.remove();
                        filesArray = filesArray.filter(f => f.name !== file.name); // Remove the file from array
                    });

                    // Append image and remove button to the preview box
                    $previewBox.append($img).append($removeBtn);
                    $previewContainer.append($previewBox);
                };

                // Read the image file as a data URL for preview
                reader.readAsDataURL(file);
                filesArray.push(file);
            }
        });

        // Clear the file input to allow re-selection of the same file
        $imageInput.val('');
    });

    // Intercept the form submission to append the selected files programmatically
    $('#locationForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Disable the submit button to prevent multiple submissions
        const $submitButton = $(this).find('button[type="submit"]');
        $submitButton.prop('disabled', true);

        // Check if filesArray is empty
        if (filesArray.length === 0) {
            alert('Please select at least one image to upload.');
            return; // Exit the function if no files are selected
        }

        const formData = new FormData(this); // Include all form data

        // Create a new FormData object to exclude previous images[]
        const newFormData = new FormData();
        for (let [key, value] of formData.entries()) {
            if (key !== 'images[]') { // Exclude previous images[]
                newFormData.append(key, value);
            }
        }

        // Append only non-empty files to the new FormData
        $.each(filesArray, function(index, file) {
            if (file.size > 0) { // Check if the file is not empty
                newFormData.append('images[]', file);
            }
        });

        // Submit the new form data via AJAX
        $.ajax({
            url: 'php/write_place_upload_image.php', // Updated URL
            type: 'POST',
            data: newFormData,
            processData: false,
            contentType: false,
            success: function(result) {

                $('#error-messages').html(result); // Display the result
                $previewContainer.empty(); // Clear previews after successful upload
                filesArray = []; // Reset files array
            },
            error: function(error) {
                console.error('Error:', error);
            },
            complete: function() {
                // Re-enable the submit button after the request completes
                $submitButton.prop('disabled', false);
            }
        });
    });

});


//////// Image Slide ////////

// Function to display the current slide
function currentSlide(n) {
    showSlides(slideIndex = n);
}

// Main function to display the corresponding slide
function showSlides(n) {
    let slides = $(".mySlides");
    let dots = $(".dot");

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    slides.hide();  // Hide all slides
    dots.removeClass("active");  // Remove active class from all dots

    // Show the current slide and mark the corresponding dot as active
    slides.eq(slideIndex - 1).show();  
    dots.eq(slideIndex - 1).addClass("active");
}

