<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>User Signup</title>
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
                        <a href="{{ route('user.signup.get') }}"class="heading_pg1 active">Sign up</a>
                        <a href="{{ route('user.signin.get') }}"class="heading_pg1">Sign in</a>
                    </div>
                </div>
                <!-- Form Container -->
                <div class="form_center_pg1">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" autocomplete="off" action="{{ route('user.signup') }}">
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
                                        <option value="+61">+61(Aus)</option>
                                        <!-- Add more country code options here -->
                                    </select>
                                </div>
                                <input type="text" autocomplete="off" id="mobile" name="mobile" pattern="[0-9]+"
                                    placeholder="Enter Mobile Number" required />
                            </div>
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                        <button type="submit" style="width: 100%" class="btn_pg1">Sign Up</button>

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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

</html>
