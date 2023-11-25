{{-- <div class="modal-container-notification">
    <div class="modal-side-drawer-white">
        <div class="modal-head">
            <span>Notifications</span>
        </div>
        <div class="modal-body">
            <div class="each-notification">
                <p class="notification-wrap">
                    <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22" height="20">
                </p>
                <div>
                    <span>You have an appointment</span>
                    <span>You have an appointment in the next 2 hours</span>
                </div>
            </div>
            <div class="each-notification">
                <p class="notification-wrap">
                    <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22" height="20">
                </p>
                <div>
                    <span>You have an appointment</span>
                    <span>You have an appointment in the next 2 hours</span>
                </div>
            </div>
            <div class="each-notification">
                <p class="notification-wrap">
                    <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22" height="20">
                </p>
                <div>
                    <span>GP just created a referral letter</span>
                    <span>You have an appointment in the next 2 hours</span>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal-container-notification">
    <div class="modal-side-drawer-white">
        <div class="modal-head">
            <span>Notifications</span>
        </div>
        <div class="modal-body" id="notificationContainer">
            <!-- Old notifications -->
            @foreach (showNotifications() as $notification)
                <div class="each-notification">
                    <!-- Display old notifications -->
                </div>
            @endforeach
        </div>
    </div>
</div>

