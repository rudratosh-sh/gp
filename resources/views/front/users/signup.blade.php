<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <title>Signup Page</title>
</head>

<body>
    <div class="container_pg13">
        <div class="header_pg13">
            <!-- <h3>Logo</h3> -->
            <img src="{{ asset('assets/MaskGP1.png') }}" alt="" class="main_logo" />
        </div>
        <div class="form_container_pg13">
            <div class="form_content">
                <!-- SignIn/SignUp -->
                <div class="form_heading_pg1">
                    <div class="login_heading_pg1">
                        <h3 class="heading_pg1 active" onclick="setActive(this)">Sign up</h3>
                        <h3 class="heading_pg1" onclick="setActive(this)">Sign in</h3>
                    </div>
                </div>
                <!-- Form Container -->
                <div class="form_center_pg1">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" autocomplete="off"  action="{{ route('user.signup') }}">
                        @csrf

                        <!-- First Name, Middle Name, Last Name -->
                        <div class="firstname_container_pg1">
                            <!-- First Name -->
                            <div class="input_field_pg1">
                                <label for="first_name">First name</label>
                                <input type="text" id="first_name" name="first_name" placeholder="First Name"
                                    required />
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Middle Name -->
                            <div class="input_field_pg1">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name" />
                            </div>

                            <!-- Last Name -->
                            <div class="input_field_pg1">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Last Name"
                                    required />
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <!-- Mobile Number -->
                        <div class="input_field_pg1">
                            <label for="mobile" class="mobile">Enter Mobile Number</label>
                            <div class="flx_pg1">
                                <div class="country-code-container_pg1">
                                    <select class="country-code-select_pg1" name="country_code">
                                        <option value="+91">+91 (IND)</option>
                                        <option value="+91">+91</option>
                                        <option value="+44">+44</option>
                                        <!-- Add more country code options here -->
                                    </select>
                                </div>
                                <input type="text" autocomplete="off" id="mobile" name="mobile" pattern="[0-9]+" placeholder="Enter Mobile Number" required />
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <!-- Password -->
                        <div class="input_field_pg1">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Password" required />
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="btn_pg1">
                            <button type="submit" style="width: 100%" class="login_pg13">Proceed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->

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
    <script src="{{ asset('js/public.js') }}"></script>
</body>

</html>
