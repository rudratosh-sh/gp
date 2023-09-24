<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>User Sign-in</title>

    <style>
        .input_field_pg1 input {
            width: 100% !important;
        }

        .input_field_pg1 {

            padding-top: 50px !important;
        }

        .btn_pg1 {
            margin-top: 55px !important;
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
                <!-- SignIn/SignUp -->
                <div class="form_heading_pg1">
                    <div class="login_heading_pg1">
                        <a href="{{ route('user.signup.get') }}"class="heading_pg1">Sign up</a>
                        <h3 class="heading_pg1 active" onclick="setActive(this)">Sign in</h3>
                    </div>
                </div>
                <!-- Form Container -->
                <div class="form_center_pg1">
                    <form method="POST" autocomplete="off" action="{{ route('user.signin.post') }}">
                        @csrf

                        <!-- Mobile Number or Email -->
                        <div class="input_field_pg1">
                            <label for="mobile_or_email">Mobile Number or Email</label>
                            <input type="text" id="mobile_or_email" name="mobile_or_email"
                                placeholder="Mobile Number or Email" required autocomplete="off" />
                            @error('mobile_or_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="input_field_pg1">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" autocomplete="new-password"
                                placeholder="Password" required />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" style="width: 100%" class="btn_pg1">Sign In</button>

                    </form>
                    <div style="padding-top: 50px"></div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
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
