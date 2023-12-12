<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="{{ asset('/js/staff/common.js') }}"></script>
<script src="{{ asset('/js/chat.js') }}"></script>
<script src="{{ asset('/js/notification.js') }}"></script>

<script>
    // Function to handle file upload
    function handleFileUpload() {
        const fileInput = $('#photoUpload')[0];
        const clearButton = $('#clearButton');
        const preview = $('#imagePreview');
        const uploadPhotoTxt = $('#upload-photo-text');

        // Check if a file is selected
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const image = $('<img>').attr('src', reader.result).css('max-width', '100%');

                // Remove any previously displayed image
                preview.empty();

                // Display the uploaded image and the "Clear" button
                preview.append(image);
                clearButton.css('display', 'block');
                uploadPhotoTxt.css('display', 'none');
            };

            reader.readAsDataURL(file);
        }
    }

    // Function to clear the uploaded image
    function clearFileUpload() {
        const fileInput = $('#photoUpload');
        const clearButton = $('#clearButton');
        const preview = $('#imagePreview');
        const uploadPhotoTxt = $('#upload-photo-text');

        // Clear the file input and the displayed image
        fileInput.val('');
        preview.empty();

        // Hide the "Clear" button
        clearButton.css('display', 'none');
        uploadPhotoTxt.css('display', 'block');
    }

    // Attach a change event listener to the file input
    $('#photoUpload').on('change', handleFileUpload);

    // Attach a click event listener to the "Clear" button
    $('#clearButton').on('click', clearFileUpload);
</script>
