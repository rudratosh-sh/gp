<!-- resources/views/includes/header.blade.php -->
<header>
    <div class="header_col">
        <div class="super_logo">
            <img class="site_logo" src="{{ asset('assets/MaskGP1.png') }}" />
        </div>
        <div class="user_details">
            <div class="notifications">
                <img src="{{ asset('assets/bell.svg') }}" />
            </div>
            <div class="login_user">
                <div class="circle"></div>
                <h4 class="user_name_txt">{{ auth()->user()->name  }}</h4>
            </div>
        </div>
    </div>
</header>
