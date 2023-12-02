var pusherNotfication = new Pusher("1a96c62d17b6395fe814", {
    cluster: "ap4",
    channelAuthorization: {
        endpoint: "/pusher/auth",
        headers: {
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
        },
    },
});

const recipientUserIdNotify = $("#receiver_id_chat").val(); // Set the recipient user's ID here
const channelNameNotify = `notification-user.${recipientUserIdNotify}`;

const privateChannelNotify = pusherNotfication.subscribe(channelNameNotify);
privateChannelNotify.bind("pusher:subscription_succeeded", (data) => {
    console.log("Subscribed to private channel ", privateChannelNotify, data);
});

privateChannelNotify.bind("notification", function (data) {
    console.log("datasNotification", data);
    // Extracting data
    const notification = data.notification;
    const user = data.user;
    $(".noti-icon").addClass('active-notification')
    // Creating the chat notification HTML structure
    const notificationHtml = `
    <div class="compact-chat-notification">
        <div class="notification-title">
            <h3>${notification.title}</h3>
        </div>
        <div class="user-avatar">
            <img width="35" height="35" src="${user.avatar}" alt="User Avatar">
        </div>
        <div class="chat-content">
            <h4>${user.name}</h4>
            <p>${notification.message}</p>
        </div>
    </div>
`;

    // Using Toastr to display the chat notification
    toastr.options = {
        closeButton: true,
        progressBar: true,
        timeOut: 0, // Adjust the time as needed
        positionClass: "toast-top-right",
        preventDuplicates: true,
        // Other options as needed
    };

    toastr.warning(notificationHtml, "");
});
