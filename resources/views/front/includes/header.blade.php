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
                <h4 class="user_name_txt">{{ $user->name }}</h4>
                <div class="dropdown">
                    <button class="dropbtn">&#9660;</button>
                    <div class="dropdown-content">
                        <a href="#">Profile</a>
                        <a href="{{ route('logout') }}">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>

    /* Style the user details */
    .user_details {
        display: flex;
        align-items: center;
    }

    /* Style the notifications icon */
    .notifications img {
        margin-right: 10px;
    }

    /* Style the user name and dropdown */
    .login_user {
        display: flex;
        align-items: center;
        position: relative;
    }

    /* Style the user name text */
    .user_name_txt {
        margin-right: 20px;
    }

    /* Style the dropdown button */
    .dropbtn {
        background-color: transparent;
        font-size: 18px;
        border: none;
        cursor: pointer;
    }

    /* Style the dropdown content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Style the dropdown links */
    .dropdown-content a {
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        color: #333;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
