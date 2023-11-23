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

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
    window.onload=function(){
        // Listen for broadcast event
        // Echo.channel('events') // for public channel
        // Echo.private('events')
        //     .listen('RealTimeMessage', (e) => {
        //         console.log('Private RealTimeMessage: ' + e.message)
        //         window.dispatchEvent(new CustomEvent('flash', { detail: e.message }));
        //     });

        // // Listen for broadcast notification on private channel
        // Echo.private('App.Models.User.1')
        //     .notification((notification) => {
        //         console.log(notification.message);
        //         window.dispatchEvent(new CustomEvent('flash', { detail: notification.message }));
        //     });
        console.log(Echo); // Logs the broadcaster property of the Echo object
        Echo.private(`notifications.${28}`)
        .notification((notification) => {
            // Handle received notifications in real-time
            console.log(notification);
            // Update UI or show notifications
        });
    };
</script>
