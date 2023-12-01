var pusher = new Pusher("1a96c62d17b6395fe814", {
    cluster: "ap4",
    channelAuthorization: {
        endpoint: "/pusher/auth",
        headers: {
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
        },
    },
});

const recipientUserId = $("#receiver_id_chat").val(); // Set the recipient user's ID here
const channelName = `private-user.${recipientUserId}`;

const privateChannel = pusher.subscribe(channelName);
privateChannel.bind("pusher:subscription_succeeded", (data) => {
    console.log("Subscribed to private channel", data);
});

privateChannel.bind("chat", function (data) {
    console.log("datas", data);
    // Extracting data
    const message = data.message;
    const user = data.user;

    // Creating the chat notification HTML structure
    const notificationHtml = `
    <div class="compact-chat-notification">
        <div class="user-avatar">
            <img width="35" height="35" src="${user.avatar}" alt="User Avatar">
        </div>
        <div class="chat-content">
            <h4>${user.name}</h4>
            <p>${message.message_content}</p>
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

    toastr.success(notificationHtml, "New Chat Message");

    // $.post("/receive", {
    //     _token: $('meta[name="csrf-token"]').attr("content"),
    //     message: data.message,
    // })
    //     .done(function (res) {
    //         $(".messages > .message").last().after(res);
    //         $(document).scrollTop($(document).height());
    //     })
    //     .fail(function (error) {
    //         console.error("Error receiving message:", error);
    //     });
});
