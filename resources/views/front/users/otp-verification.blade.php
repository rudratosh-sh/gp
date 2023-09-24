<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <title>OTP Verification</title>
    <style>
        /* Add this CSS to style the disabled button */
        .otp_resend_pg2[disabled] {
            background-color: #ccc;
            /* Change the background color to gray */
            cursor: not-allowed;
            /* Change the cursor style to not-allowed */
        }
    </style>
</head>

<body>
    <div class="container_pg13">
        <div class="header_pg13">
            <img src="{{ asset('assets/MaskGP1.png') }}" alt="" class="main_logo" />
        </div>
        <div class="form_container_pg13">
            <div class="form_content">
                <div class="alert alert-danger error-message">
                    {{ session('error') }}
                </div>
                <div class="form_center_pg1">
                    <div class="firstname_container_pg2">
                        <div>
                            <h3 class="user_name_pg2">Hi {{ $userData['first_name'] }} {{ $userData['last_name'] }},
                            </h3>
                            <h3 class="otp_info_pg2">We just sent an OTP to your Mobile number</h3>
                            <div class="flx_pg2 user_name_pg2">
                                <h3>{{ $userData['mobile'] }}</h3>
                                <a href="{{ route('user.signup') }}" class="change_number_pg2">Change number</a>
                            </div>
                        </div>
                    </div>
                    <div class="flx_pg2">
                        <h3 class="ft_w">Enter OTP</h3>
                        <div class="flx">
                            <h3 class="ft_w time_clock_pg2" id="otpTimer">{{ $otpExpiration }}</h3>
                            <button class="ft_w otp_resend_pg2" id="resendOtp" onclick="resendOtp()">Resend</button>
                        </div>
                    </div>
                    <form method="POST" id="otpForm" action="{{ route('user.verifyOtp.post') }}">
                        @csrf
                        <div class="otp-container_pg2">
                            <input type="text" class="otp-input_pg2" maxlength="1" tabindex="1" name="otp1" />
                            <input type="text" class="otp-input_pg2" maxlength="1" tabindex="2" name="otp2" />
                            <input type="text" class="otp-input_pg2" maxlength="1" tabindex="3" name="otp3" />
                            <input type="text" class="otp-input_pg2" maxlength="1" tabindex="4" name="otp4" />
                            <input type="text" class="otp-input_pg2" maxlength="1" tabindex="5" name="otp5" />
                            <input type="text" class="otp-input_pg2" maxlength="1" tabindex="6" name="otp6" />
                            <input type="hidden" name="otp" id="otp" />
                        </div>
                        <!-- Display the error message for the hidden OTP input -->
                        @error('otp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button type="submit" style="width: 100%" class="btn_pg1">Proceed</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="banner_pg13">
            <div>
                <div>
                    <img src="{{ asset('assets/Group137.png') }}" alt="" class="main_logo_pg13" />
                </div>
                <div class="right_online_pg13">
                    <h5>Get Online Consultation</h5>
                </div>
                <div class="radio_btn_pg13">
                    <input type="radio" name="radiogroup" checked />
                    <input type="radio" name="radiogroup" />
                    <input type="radio" name="radiogroup" />
                    <input type="radio" name="radiogroup" />
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // jQuery code to handle the "input" event
        $(document).ready(function() {
            $(".otp-input_pg2").on("input", function() {
                const maxLength = parseInt($(this).attr("maxlength"));
                let inputValue = $(this).val();
                // Remove any non-numeric characters from the input value
                inputValue = inputValue.replace(/[^0-9]/g, "");
                // Ensure the input value is not less than 0
                const numericValue = parseInt(inputValue);
                if (isNaN(numericValue) || numericValue < 0) {
                    inputValue = "";
                }
                // Update the input value
                $(this).val(inputValue);

                if (inputValue.length === 0) {
                    // Move focus to the previous input element when the current input is cleared
                    $(this).prev(".otp-input_pg2").focus();
                } else if (inputValue.length === maxLength) {
                    // Move focus to the next input element when the current input is filled
                    const $nextInput = $(this).next(".otp-input_pg2");
                    if ($nextInput.length > 0) {
                        $nextInput.focus();
                    } else {
                        // If there is no next input, prevent form submission
                        event.preventDefault();
                    }
                }
            });
        });

        // Countdown timer for OTP expiration
        let otpExpiration = parseInt("{{ $otpExpiration }}"); // Parse the initial value as an integer
        const otpTimerElement = document.getElementById("otpTimer");
        const resendButton = document.getElementById("resendOtp");
        let maxAttempts = 3; // Maximum number of OTP resend attempts
        let attempts = 0; // Current number of attempts

        function startOtpTimer() {
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}.${remainingSeconds.toString().padStart(2, '0')}`;
            }

            otpTimerElement.innerText = formatTime(otpExpiration);
            const timerInterval = setInterval(() => {
                otpExpiration--;
                otpTimerElement.innerText = formatTime(otpExpiration);
                if (otpExpiration === 0) {
                    clearInterval(timerInterval);
                    if (attempts < maxAttempts) {
                        resendButton.disabled = false; // Enable the Resend button
                    }
                }
            }, 1000);
        }

        startOtpTimer();

        // Function to resend OTP (you can implement this)
        function resendOtp() {
            if (attempts < maxAttempts) {
                attempts++;
                // Implement the OTP resend logic here
                // Once OTP is successfully sent, update the expiration and start the timer again
                otpExpiration = parseInt("{{ $otpExpiration }}"); // Parse the expiration time again
                startOtpTimer();
                resendButton.disabled = true; // Disable the Resend button again
            } else {
                resendButton.disabled = true; // Disable the Resend button permanently
            }
        }

        $(document).ready(function() {
            // Track the number of wrong OTP attempts
            let wrongAttempts = 0;
            const maxAttempts = 3; // Maximum number of wrong attempts allowed

            function showError(message) {
                // Display error message on the page
                $(".error-message").text(message);
            }

            function clearError() {
                // Clear error message on the page
                $(".error-message").text("");
            }

            function disableForm() {
                // Disable the form after reaching the max wrong attempts
                $(".otp-input_pg2").prop("disabled", true);
                $("#resendOtp").prop("disabled", true);
                $("button[type=submit]").prop("disabled", true);
            }

            function verifyOtp() {
                const otpDigits = $(".otp-input_pg2")
                    .map(function() {
                        return $(this).val();
                    })
                    .get()
                    .join("");

                // AJAX request to verify OTP
                $.ajax({
                    url: "{{ route('user.verifyOtp.post') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        otp: otpDigits,
                    },
                    success: function(response) {
                        if (response.success) {
                            // OTP verification successful, redirect to the dashboard route
                                // Encode the user data as a JSON string and include it as a query parameter
                                const userDataQueryParam = encodeURIComponent(JSON.stringify(response.userData));
                                // Redirect to the dashboard route with the user data as a query parameter
                                window.location.href = "{{ route('user.verifyMedicare.get') }}";
                        } else {
                            // Wrong OTP entered
                            wrongAttempts++;
                            if (wrongAttempts >= maxAttempts) {
                                // Reached max wrong attempts, disable the form
                                disableForm();
                            }
                            // Show error message
                            showError("Invalid OTP. Please try again.");
                        }
                    },
                    error: function() {
                        // Show error message for AJAX request failure
                        showError("An error occurred. Please try again later.");
                    },
                });
            }

            $("#otpForm").on("submit", function(e) {
                e.preventDefault();
                clearError();
                verifyOtp();
            });

            $("#resendOtp").on("click", function() {
                if (wrongAttempts < maxAttempts) {
                    // Implement OTP resend logic here using AJAX
                    // Once OTP is successfully sent, update the expiration and start the timer again
                    // Then, reset the wrongAttempts count
                    wrongAttempts = 0;
                    clearError();
                }
            });

        });
    </script>
</body>

</html>
