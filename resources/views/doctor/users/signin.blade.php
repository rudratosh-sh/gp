<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SGP - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <section class="landing-page columns">
        <div class="login-section-container column is-two-third">
            <div class="section header-section">
                <header class="header-solo-m">
                    <img class="logo" src="{{ asset('assets/logo.png') }}">
                    <img class="staff staff-m" src="{{ asset('assets/staff.png') }}">
                </header>
                <div class="section login-section">
                    <h2 class="is-size-2 has-text-weight-semibold">Sign in</h2>
                    <div class="login-form">
                        <form method="POST" action="{{ route('doctor.signin.post') }}">
                            @csrf <!-- CSRF token -->

                            <div class="form-field">
                                <label for="email">Enter Email Address</label>
                                <input id="email"
                                    class="input is-normal input-signin @error('email') is-danger @enderror"
                                    type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter Email Address">
                                @error('email')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="mobile">Enter Mobile Number</label>
                                <div class="m-input-wrapper">
                                    <div class="mobile-code">
                                        <p>+61 (AUS)</p>
                                        <div></div>
                                    </div>
                                    <input id="mobile"
                                        class="input is-normal input-signin @error('mobile') is-danger @enderror"
                                        type="text" name="mobile" value="{{ old('mobile') }}"
                                        placeholder="Enter Mobile Number">
                                    @error('mobile')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="password">Enter Password</label>
                                <input id="password"
                                    class="input is-normal input-signin @error('password') is-danger @enderror"
                                    type="password" name="password" placeholder="Enter Password">
                                @error('password')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="button">Sign In</button>
                            <div style="padding-top: 10px"></div>
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="colored-background is-centered columns column is-one-third is-vcentered">
            <div class="">
                <img src="{{ asset('assets/landing-image.png') }}">
                <p class="text-center landing-colored-text">Get Online Consultation</p>
            </div>
        </div>
    </section>

</body>

</html>
