<!-- Chat MODAL Start-->
@include('staff.modals.chats')
<!-- Chat MODAL end-->

<!-- Notification MODAL Start-->
@include('staff.modals.notification')
<!-- Notification MODAL end-->
<!-- header.blade.php -->
<header class="header flex justify-between items-center bg-white">
    <input type="hidden" id="receiver_id_chat" value="{{ Auth::user()->id }}" />
    <div class="flex items-center">
        <div class="logo-wrapper">
            <img class="logo" width="134px" height="35px" src="{{ asset('assets/images/logo.png') }}" alt="" />
            <div class="flex items-center logo-text" style="display: flex;column-gap: 2.8rem;">
                <img class="mr-15" width="24px" height="24px"
                    src="{{ asset('assets/images/hospital-user(1).svg') }}" alt="" />
                <p class="text-grey1 text-22 font-semibold">{{ $user->clinic->name }}</p>
                <span
                    style="color: #17a269;
              font-size: 24px;
              font-weight: 500;
              font-style: italic;
              ">Allied
                    Staff</span>
            </div>
        </div>
    </div>
    <div class="flex items-center ml-10">
        <button class="header-message-icon openChatModel">
            <span class="message-icon"></span>
            <img class="mes-icon-header " src="{{ asset('assets/images/messages2.svg') }}" alt="message">
        </button>
        <button class="header-message-icon" id="openNotificationModal">
            <span class="noti-icon"></span>
            <img class="noti-icon-header" src="{{ asset('assets/bell-notification.png') }}" alt="" />
        </button>

        <div class="login_user" style="display: flex; align-items: center; position: relative">
            <div class="circles">
                <img class="user-icon" width="35px" height="35px" src="{{ asset('assets/images/chat-profile.png') }}"
                    alt="" />
            </div>
            <p class="text-grey text-base ml-10 user-name-header user_name_txts">{{ auth()->user()->name }}</p>
        </div>

        <div class="user_profile_popup" style="position: absolute; top: 0px; margin-top: 4.2rem; display: flex;">
            <a href="{{route('staff.profile.get')}}" style="all: unset;cursor: pointer;"><span>My Profile</span></a>
            <a href="{{route('logout')}}" style="all: unset; cursor: pointer; color:red"><span>Logout</span></a>
        </div>
    </div>
</header>
