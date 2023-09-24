<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/medicare.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Verify Credit Card</title>
</head>

<body>
    <div class="container_pg13">
        <div class="header_pg13 xs-hidden">
            <img src="{{ asset('assets/logo.png') }}" alt="" class="main_logo">
        </div>
        <header class="hide-desktop header-solo-m">
            <img class="logo" src="{{ asset('assets/logo.png') }}">
        </header>
        <div class="form_container_pg13 mt-100 xs-m-0">
            <div class="form_content">
                <!-- SignIn/SignUp -->
                <form method="POST" action="{{ route('user.verifyCreditCard.post') }}" novalidate>
                    @csrf
                    <div class="form_heading_pg13">
                        <div class="login_heading_pg13">
                            <h3 class="heading_pg13 active" onclick="setActive(this)">
                                Sign up
                            </h3>
                            <a href="{{ route('user.signin.get') }}"class="heading_pg1">Sign in</a>
                        </div>
                    </div>
                    <!-- Form Container -->
                    <div class="form_center">
                        <div class="firstname_container_pg13">
                            <div class="first_container_pg13">
                                <h3 class="user_name_pg13">Enter your Credit card Details</h3>
                                <div class="flx_sp_pg13 user_name_pg13">
                                    <h3 class="otp_info_pg13">Card Number</h3>
                                </div>
                                <div class="input_card_pg13">
                                    <input type="text" name="card_number" placeholder="Card Number"
                                        data-inputmask="'mask': '9999 9999 9999 9999'" value="{{ old('card_number') }}">
                                </div>
                                @error('card_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- DOB -->
                        <div class="dob_container_pg13">
                            <div class="date_field_pg13">
                                <p>Month</p>
                                <input type="text" name="expiration_month" placeholder="Month"
                                    data-inputmask="'mask': '99'" value="{{ old('expiration_month') }}">
                                @error('expiration_month')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="date_field_pg13">
                                <div class="date_field_input_pg13">
                                    <p>Year</p>
                                    <input type="text" name="expiration_year" placeholder="Year"
                                        data-inputmask="'mask': '9999'" value="{{ old('expiration_year') }}">
                                    @error('expiration_year')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flx_sp_pg13 user_name_pg13">
                            <h3 class="address_info_pg13">CVV Number</h3>
                            <div class="input_card_cvv_pg13">
                                <div class="cvv_input_pg13">
                                    <input type="text" name="cvv_number" placeholder="CVV" id="cvv_number"
                                        value="{{ old('cvv_number') }}">

                                    @error('cvv_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="cvv_condition_pg13">
                                    <span>3 or 4 Digits Usually found On the signature strip</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%" class="btn_pg1">Proceed</button>
                </form>
            </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize input masking for card number, expiration month, and CVV number
            $('[name="card_number"]').inputmask('9999 9999 9999 9999');
            $('[name="expiration_month"]').inputmask('99');
            $('[name="expiration_year"]').inputmask('9999');
            $('[name="cvv_number"]').inputmask('9999');

            // Add an event listener to the CVV input field
            document.getElementById('cvv_number').addEventListener('input', function(e) {
                // Remove non-numeric characters
                this.value = this.value.replace(/\D/g, '');

                // Limit the input to a maximum of 4 characters
                if (this.value.length > 4) {
                    this.value = this.value.slice(0, 4);
                }
            });

            // Add a submit event listener to the form
            document.querySelector('form').addEventListener('submit', function(e) {
                // Get the card number input
                const cardNumberInput = document.querySelector('[name="card_number"]');
                // Remove spaces from the card number
                const cardNumber = cardNumberInput.value.replace(/\s/g, '');
                // Validate the card number using the Luhn algorithm
                if (!validateCreditCard(cardNumber)) {
                    // Prevent form submission
                    e.preventDefault();
                    // Display an error message
                    alert('Invalid Credit Card Number');
                }
            });

            function validateCreditCard(cardNumber) {
                // Luhn algorithm validation logic
                let sum = 0;
                let shouldDouble = false;
                for (let i = cardNumber.length - 1; i >= 0; i--) {
                    let digit = parseInt(cardNumber.charAt(i));

                    if (shouldDouble) {
                        if ((digit *= 2) > 9) digit -= 9;
                    }

                    sum += digit;
                    shouldDouble = !shouldDouble;
                }

                return sum % 10 === 0;
            }
        });
    </script>
</body>

</html>
