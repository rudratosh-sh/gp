<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/medicare.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>Verify Medicare Card</title>

    <style>
        /* Add the CSS styles for the image upload and preview here */
        .center {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-input {
            width: 100%;
            padding: 20px;
            background: #fff;
            border: 1px dashed #c5c5c5;
        }

        .form-input input {
            display: none;
        }

        .form-input label {
            display: block;
            width: 45%;
            height: 45px;
            margin-left: 25%;
            line-height: 50px;
            text-align: center;
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-input img {
            width: 100%;
            display: none;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container_pg13">
        <div class="header_pg13">
            <img src="{{ asset('assets/logo.png') }}" alt="" class="main_logo">
        </div>
        <header class="hide-desktop header-solo-m">
            <img class="logo" src="{{ asset('assets/logo.png') }}">
        </header>
        <div class="form_container_pg13 mt-100 xs-m-0" style="padding-right:15px">
            <form method="POST" action="{{ route('user.verifyMedicare.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="form_content">
                    <!-- SignIn/SignUp -->
                    <div class="form_heading_pg2">
                        <div class="login_heading_pg2">
                            <h5 class="heading_pg2 active" onclick="setActive(this)">
                                Sign up
                            </h5>
                            <a href="{{ route('user.signin.get') }}"class="heading_pg2">Sign in</a>
                        </div>
                    </div>
                    <!-- Form Container -->
                    <div class="form_center_pg1">
                        <h2 class="hide-desktop is-size-2 has-text-weight-semibold text-24">Medicare Info</h2>
                        <div class="firstname_container_pg2 xs-mb-14">
                            <div class="first_container_pg12">
                                <h5 class="user_name_pg2">Hi Sean Rada,</h5>
                                <h5 class="otp_info_pg2">
                                    Please Verify your Medicare Card and Personal Details
                                </h5>
                                <div class="flx_pg2 user_name_pg2">
                                    <h4 class="otp_info">Medicare Number</h4>
                                </div>
                                <div class="input_card_pg12">
                                    <input type="text" id="medicare_number" name="Medicare_number"
                                        value="{{ old('Medicare_number') }}" placeholder="XXXX XX XXX X">
                                    @error('Medicare_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="center">
                            <div class="form-input">
                                <div class="preview">
                                    <img id="file-ip-1-preview" style="display: none;">
                                </div>
                                <label for="file-ip-1">Upload Medicare Photo</label>
                                <input type="file" id="file-ip-1"name="medicare_image" accept="image/*"
                                    onchange="showPreview(event);">
                            </div>
                        </div>
                        @error('medicare_image')
                            <span class="text-danger text-center">{{ $message }}</span>
                        @enderror
                        <!-- DOB -->
                        <div class="dob_container_pg12">
                            <div class="date_field_pg12">
                                <p>Date of birth</p>
                                <input type="text" id="birthdatePicker" name="birthdate"
                                    value="{{ old('birthdate') }}" placeholder="Select Birthdate">

                            </div>
                            <div class="gender_container_pg12">
                                <p class="gender_head_pg12">Gender</p>
                                <div class="gender_selection_pg12">
                                    <button class="gender-option_pg12 active" data-gender="Male">
                                        Male
                                    </button>
                                    <button class="gender-option_pg12" data-gender="Female">
                                        Female
                                    </button>
                                    <button class="gender-option_pg12" data-gender="Other">
                                        Other
                                    </button>
                                    <input type="hidden" id="gender" value="{{ old('gender') }}"  name="gender" />
                                </div>
                            </div>
                        </div>
                        @error('birthdate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="date_field_pg12 address-field">
                            <p>Enter Address</p>
                            <input type="text" placeholder="Enter here" id="autocomplete" name="address"
                                value="{{ old('address') }}" style="width: 801px;">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" style="width: 100%" class="btn_pg1">Proceed</button>
                </div>
            </form>
        </div>
        <!-- RIGHT SIDE -->
        <div class="banner_pg13">
            <div>
                <div>
                    <img src="{{ asset('assets/Group137.png') }}" alt="" class="main_logo_pg13">
                </div>
                <div class="right_online_pg13">
                    <h5>Get Online Consultation</h5>
                </div>
                <div class="radio_btn_pg13">
                    <input type="radio" name="radiogroup" checked>
                    <input type="radio" name="radiogroup">
                    <input type="radio" name="radiogroup">
                    <input type="radio" name="radiogroup">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Include Inputmask plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
        integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD21xJxqBgHKLqM_k2IBeQ95ZUupe08yoE&libraries=places">
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const genderOptions = document.querySelectorAll(".gender-option_pg12");
            const genderInput = document.getElementById(
            "gender"); // Assuming you have an input field with id "genderInput"

            // Set the default value to "Male"
            genderInput.value = "Male";

            genderOptions.forEach(function(option) {
                option.addEventListener("click", function() {
                    const selectedGender = this.getAttribute("data-gender");

                    // Remove the 'active' class from all options
                    genderOptions.forEach(function(item) {
                        item.classList.remove("active");
                    });

                    // Add the 'active' class to the selected option
                    this.classList.add("active");

                    // Set the selected gender as the input field's value
                    genderInput.value = selectedGender;
                });
            });
        });
    </script>

    <script>
        flatpickr("#birthdatePicker", {
            dateFormat: "Y-m-d", // Customize date format
            maxDate: "today", // Optionally limit the max date to today
        });

        function showPreview(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }

        $(document).ready(function() {
            // Apply masking to the Medicare number input
            $('#medicare_number').inputmask('9999 9999 9', {
                placeholder: 'X',
                clearIncomplete: true
            });

            // Validate Medicare number format when the input value changes
            $('#medicare_number').on('input', function() {
                // Get the input value
                var inputValue = $(this).val();

                // Remove spaces from the value for validation
                var valueWithoutSpaces = inputValue.replace(/\s/g, '');

                // Check if the value matches the Medicare number format
                var isValidMedicareNumber = /^([2-6]\d{3} \d{4} \d{1})$/.test(valueWithoutSpaces);

                if (isValidMedicareNumber) {
                    // Value is valid
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    // Value is invalid
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });
        });

        // Initialize the autocomplete for the input field
        const input = document.getElementById('autocomplete');
        const autocomplete = new google.maps.places.Autocomplete(input);

        let hasUserSelected = false; // Flag to track if the user has made a selection

        // Add an event listener when a user selects a suggestion
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                // User selected a suggestion, but it's not a valid place
                input.value = ''; // Clear the input
            } else {
                hasUserSelected = true; // User selected a valid place
            }
        });

        // Add an event listener to clear the input when it loses focus
        input.addEventListener('blur', function() {
            if (!hasUserSelected) {
                input.value = ''; // Clear the input if the user didn't make a selection
            }
        });

        // Request the user's location
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // No need to set initial bounds for autocomplete
            });
        }
    </script>
</body>

</html>
