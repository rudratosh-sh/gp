<div class="modal-container">
    <div class="modal-side-drawer-white">
        <div class="conversations-list-wrp">
            <div class="modal-head">
                <span>Chats</span>
                <span>1 New Message</span>
            </div>
            <div class="modal-body">
                @foreach (showMessagesWithUsers() as $conversation)
                    <div class="each-card" data-conversation-id="{{$conversation->id}}">
                        <div class="clinic-wrapper">
                            <img width="65" height="65" style="border-radius:50%" src="{{asset($conversation->avatar)}}" alt="logo">
                            <div>
                                <span>{{ $conversation->name }}</span>
                                <span>{{ $conversation->latest_message_content }}</span>
                            </div>
                        </div>
                        <div class="message-count">
                            <span>{{ $conversation->unread }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="conversation-wrp">
            <div class="conversation-header">
                <img src="../assets/left-dark-icon.svg" alt="left-icon">
                <img src="../assets/clinic-logo.png" alt="logo">
                <div>
                    <span>People First Clinic</span>
                    <span>7 July 2023</span>
                </div>
            </div>
            <div class="conversation-body">
                <div class="left-side-conversation">
                    <div class="cards">

                    </div>
                </div>
                <div class="right-side-conversation">
                    <div class="cards">
                    </div>
                </div>
            </div>
            <div class="conversation-bottom">
                <input type="text" class="message-input" placeholder="Type Your Message Here"/>
                <img src="../assets/send-icon.png" alt="send-icon" height="60" width="60">
                <input type="hidden" class="sender-id" />
                <input type="hidden" class="receiver-id" />
            </div>
        </div>
    </div>
</div>
