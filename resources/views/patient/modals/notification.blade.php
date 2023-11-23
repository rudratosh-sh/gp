{{-- <div class="modal-container-notification">
    <div class="modal-side-drawer-white">
        <div class="modal-head">
            <span>Notifications</span>
        </div>
        <div class="modal-body">
            @foreach (showNotifications() as $notification)
                <div class="each-notification">
                    <p class="notification-wrap">
                        <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22" height="20">
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
<div class="modal-container-notification">
    <div class="modal-side-drawer-white">
        <div class="modal-head">
            <span>Notifications</span>
        </div>
        <div class="modal-body" id="notificationContainer">
            @foreach (showNotifications() as $notification)
                <!-- Display existing notifications -->
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

<script>
    const notificationContainer = document.getElementById('notificationContainer');

    // Function to append new notification to the container
    function appendNotification(notification) {
        const newNotificationElement = document.createElement('div');
        newNotificationElement.classList.add('each-notification');
        newNotificationElement.innerHTML = `
        <p class="notification-wrap">
            <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22" height="20">
        </p>
        <div>
            <span>${notification.title}</span>
            <span>${notification.message}</span>
        </div>
    `;
        notificationContainer.appendChild(newNotificationElement);
    }

    // WebSocket setup
    const socket = new WebSocket('ws://your-websocket-endpoint');
    socket.onmessage = function(event) {
        const newNotification = JSON.parse(event.data);
        appendNotification(newNotification);
    };
</script> --}}
<!-- Blade view for displaying notifications -->
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
