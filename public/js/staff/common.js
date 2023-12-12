$(document).ready(function () {
    const tabs = $("#dashboard-tab, #booking-tab, #referral-tab, #profile-tab");
    const openChatModel = $(".openChatModel");
    const headerUserProfile = $(".login_user");
    const eachCard = $(".each-card");
    const openNotificationModal = $("#openNotificationModal");
    const modalContainer = $(".modal-container");
    const modalContainerNotification = $(".modal-container-notification");
    const conversationWrp = $(".conversation-wrp");
    const modalSideDrawerWhite = $(".modal-side-drawer-white");
    const modalSideDrawerGray = $(".modal-side-drawer-gray");
    const userPopup = $(".user_profile_popup");
    const leftIcon = $(
        ".conversation-header img[src='/assets/left-dark-icon.svg']"
    );

    tabs.on("click", function () {
        $("li").removeClass("active");
        $(this).addClass("active");
    });

    function handleUserPopup(event) {
        event.stopPropagation();
        userPopup.toggle();
    }

    function handleDocumentClick(event) {
        const target = $(event.target);
        if (!target.closest(".login_user, .user_profile_popup").length) {
            userPopup.hide();
        }
        if (
            modalContainer.css("display") === "block" &&
            target.hasClass("modal-container")
        ) {
            modalContainer.hide();
            modalSideDrawerGray
                .addClass("modal-side-drawer-white")
                .removeClass("modal-side-drawer-gray");
            conversationWrp.hide();
            $(".conversations-list-wrp").show();
        }
        if (
            modalContainerNotification.css("display") === "block" &&
            target.hasClass("modal-container-notification")
        ) {
            modalContainerNotification.hide();
        }
    }

    function openModalContainer(event) {
        modalContainer.show();
        conversationWrp.hide();
        $(".conversations-list-wrp").show();
        $(".message-icon").removeClass('active-notification')
    }

    function openConversation() {
        console.log(modalSideDrawerWhite);
        modalSideDrawerWhite.removeClass("modal-side-drawer-white");
        $(".conversations-list-wrp").hide();
        modalContainer
            .find('> div[class=""]')
            .addClass("modal-side-drawer-gray");
        modalSideDrawerGray.addClass("modal-side-drawer-gray"); // This line should add the class
        conversationWrp.show();
    }

    function openNotificationModalContainer() {
        modalContainerNotification.show();
        $(".noti-icon").removeClass('active-notification')
    }

    tabs.on("click", function () {
        $("li").removeClass("active");
        $(this).addClass("active");
    });

    openChatModel.on("click", openModalContainer);
    headerUserProfile.on("click", handleUserPopup);
    $(document).on("click", handleDocumentClick);
    openNotificationModal.on("click", openNotificationModalContainer);
    eachCard.on("click", openConversation);

    leftIcon.on("click", function () {
        conversationWrp.hide();
        $(".conversations-list-wrp").show();
    });

    // Function to fetch messages for a conversation

    function fetchMessages(otherUserId) {
        var currentUserId = $(".current_user_id").val();
        var currentAvatarDisplayed = false;
        var otherAvatarDisplayed = false;
        var lastSenderId = null; // Track the last sender ID
        var lastReceiverId = null; // Track the last receiver ID
        var currentSenderAvatar = null; // Store the current sender's avatar

        $.ajax({
            url: `/messages/${otherUserId}`,
            method: "GET",
            success: function (response) {
                // Sort messages by ID in ascending order
                response.sort((a, b) => a.id - b.id);

                console.log(response);
                // Clear previous messages and avatars
                $(".conversation-body").empty();
                response.forEach((message) => {
                    const messageContent = `<span>${message.message_content}</span>`;
                    const senderAvatar = message.sender.avatar;

                    if (
                        lastSenderId !== message.sender_id ||
                        lastReceiverId !== message.receiver_id
                    ) {
                        // New sender or receiver detected, update avatar and create a new card div
                        currentSenderAvatar = senderAvatar;
                        lastSenderId = message.sender_id;
                        lastReceiverId = message.receiver_id;

                        var messageCard = `<div class="card_">${messageContent}</div>`;
                        var conversationContainer = "";

                        if (message.sender_id == currentUserId) {
                            conversationContainer = `<div class="right-side-conversation">`;
                            conversationContainer += `<img src="${currentSenderAvatar}" alt="logo" height="30" width="30" style="border: 1px solid #707070;border-radius: 50%;">`;
                            conversationContainer += `<div class="cards">${messageCard}</div></div>`;
                            $(".sender-user-url").val(currentSenderAvatar);
                            $(".conversation-body").append(
                                conversationContainer
                            );
                            $(".sender-id").val(currentUserId);
                            currentAvatarDisplayed = true; // Set the flag for displaying the current avatar
                        } else {
                            conversationContainer = `<div class="left-side-conversation">`;
                            conversationContainer += `<img src="${currentSenderAvatar}" alt="logo" height="30" width="30" style="border: 1px solid #707070;border-radius: 50%;">`;
                            conversationContainer += `<div class="cards">${messageCard}</div></div>`;
                            $(".conversation-body").append(
                                conversationContainer
                            );
                            $(".receiver-id").val(message.sender_id);
                            otherAvatarDisplayed = true; // Set the flag for displaying the other avatar
                        }
                    } else {
                        // Append the message to the existing card div for the corresponding side
                        const messageSpan = `<div class="card_"><span>${message.message_content}</span></div>`;
                        if (message.sender_id == currentUserId) {
                            $(
                                ".conversation-body .right-side-conversation:last-child .cards"
                            ).append(messageSpan);
                        } else {
                            $(
                                ".conversation-body .left-side-conversation:last-child .cards"
                            ).append(messageSpan);
                        }
                    }
                });
            },
            error: function (error) {
                console.error("Error fetching messages:", error);
            },
        });
    }

    function markAsRead(conversationId) {
        const token = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: "/messages/mark-as-read",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: {
                sender_id: conversationId,
            },
            success: function (response) {
                console.log("Marked as read");
                // Maybe update UI after marking as read
            },
            error: function (error) {
                console.error("Error marking as read:", error);
            },
        });
    }
    // Usage example - Call fetchMessages when a conversation is clicked
    $(".each-card").on("click", function () {
        const conversationId = $(this).data("conversation-id"); // Assuming you have a data attribute for other user ID
        fetchMessages(conversationId);
        markAsRead(conversationId);
    });
});

function sendMessage(receiver_id, sender_id, messageContent) {
    const token = $('meta[name="csrf-token"]').attr("content");
    const sender_user_url = $(".sender-user-url").val();

    $.ajax({
        url: `/messages/send`,
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        data: {
            receiver_id: receiver_id,
            message_content: messageContent,
        },
        success: function (response) {
            // Handle success - maybe update UI or show a success message
            console.log("Message sent successfully");
            $(".sender-id").val(sender_id);
            $(".receiver-id").val(receiver_id);

            const lastConversation = $(".conversation-body").children().last();
            const messageSpan = `<div class="card_"><span>${messageContent}</span></div>`;

            if (lastConversation.hasClass("right-side-conversation")) {
                // Append the message to the existing conversation container
                lastConversation.find(".cards").append(messageSpan);
            } else {
                // Create a new conversation container for the new sender
                const conversationContainer = `<div class="right-side-conversation">
                    <img src="${sender_user_url}" alt="logo" height="30" width="30" style="border: 1px solid #707070;border-radius: 50%;">
                    <div class="cards">${messageSpan}</div>
                </div>`;
                $(".conversation-body").append(conversationContainer);
            }
            $(".sender-user-url").val(sender_user_url);
        },
        error: function (error) {
            console.error("Error sending message:", error);
        },
    });
}

$(document).ready(function () {
    $(".conversation-bottom img").on("click", function () {
        const messageContent = $(".conversation-bottom .message-input").val();
        const sender_id = $(".sender-id").val();
        const receiver_id = $(".receiver-id").val();

        console.log("sender_id", sender_id, "receiver_id", receiver_id);
        // Check if the message content is not empty
        if (messageContent.trim() !== "") {
            // Call the function to send the message
            sendMessage(receiver_id, sender_id, messageContent);

            // Clear the input field after sending the message
            $(".conversation-bottom input").val("");
        }
    });
});

// const recipientUserId = 28; // Set the recipient user's ID here
// const channelName = `private-user.${recipientUserId}`;

// pusher.connection.bind('connected', () => {
//     const socketId = pusher.connection.socket_id;
//     const token = $('meta[name="csrf-token"]').attr('content');
//     $.ajax({
//         url: '/pusher/auth',
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': token,
//         },
//         data: {
//             socket_id: socketId,
//             channel_name: channelName,
//         },
//         success: function(response) {
//             // Handle successful authentication
//             console.log('Channel authenticated:', response);
//             // Use the authentication response as needed for Pusher
//             // const privateChannel = pusher.subscribe(channelName);
//             // privateChannel.bind('chat', function(data) {
//             //     console.log('Received message:', data.message);
//             //     // Handle received message here
//             // });
//         },
//         error: function(error) {
//             // Handle authentication error
//             console.error('Channel authentication error:', error);
//         },
//     });
// });

// Use the authentication response as needed for Pusher
// Subscribe to the channel
// const privateChannel = pusher.subscribe(channelName);
// privateChannel.bind('pusher:subscription_succeeded', (data) => {
//     console.log('Subscribed to private channel',data);
// });

// privateChannel.bind('chat', function(data) {
//     console.log('data', data);
//     $.post('/receive', {
//         _token: $('meta[name="csrf-token"]').attr('content'),
//         message: data.message,
//     })
//     .done(function(res) {
//         $('.messages > .message').last().after(res);
//         $(document).scrollTop($(document).height());
//     })
//     .fail(function(error) {
//         console.error('Error receiving message:', error);
//     });
// });
