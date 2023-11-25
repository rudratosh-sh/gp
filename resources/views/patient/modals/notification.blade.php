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
</div> --}}
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
{{-- @vite('resources/js/app.js')

<script>
    window.onload = function() {
    console.log('Echo instance:', Echo);

    Echo.channel('app-test')
        .listen('.NotificationEvent', (data) => {
            console.log('Received data:', data);

            let notificationContainer = document.getElementById('notificationContainer');

            let newNotification = document.createElement('div');
            newNotification.classList.add('each-notification');

            newNotification.innerHTML = `
                <p class="notification-wrap">
                    <img src="{{ asset('assets/bell-notification.png') }}" alt="icon" width="22" height="20">
                </p>
                <div>
                    <span>${data.title}</span>
                    <span>${data.message}</span>
                </div>
            `;

            notificationContainer.prepend(newNotification);
        })
        .error((error) => {
            console.error('Echo error:', error);
        })
        .listenForWhisper('typing', (e) => {
            console.log('Whisper event:', e);
        });
};

</script> --}}
