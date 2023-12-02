<div class="modal-container-notification">
    <div class="modal-side-drawer-white">
        <div class="modal-head">
            <span>Notifications</span>
        </div>
        <div class="modal-body" id="notificationContainer">
            <!-- Existing notifications -->
            @foreach (showNotifications() as $notification)
                <div class="each-notification">
                    <p class="notification-wrap">
                        <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22"
                            height="20">
                    </p>
                    <div>
                        <span>{{ $notification->title }}</span>
                        <span>{{ $notification->message }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
