let isRecording = false;
let recorder;

async function toggleRecording(questionId) {
    try {
        const micImage = document.getElementById(`mic_${questionId}`);
        if (!isRecording) {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: {
                    sampleRate: 44100,
                },
            });

            audio_context = new AudioContext();
            recorder = new Recorder(
                audio_context.createMediaStreamSource(stream)
            );

            recorder.record();
            isRecording = true;
            micImage.src = "/assets/mic_recording.png"; // Update with the correct path
        } else {
            recorder.stop();
            isRecording = false;
            micImage.src = "/assets/mic.png"; // Update with the correct path

            // create WAV download link using audio data blob
            createDownloadLink(questionId);

            recorder.clear();
        }
    } catch (error) {
        console.error("Error toggling recording:", error);
    }
}

function createDownloadLink(questionId) {
    recorder.exportWAV(async function (blob) {
        try {
            // const formData = new FormData();
            // formData.append('audio', blob, 'recorded_audio.wav'); // 'audio' is the key
            var counter = 1;
            var url = URL.createObjectURL(blob);
            var fileName = "Recording" + counter + ".wav";
            var fileObject = new File([blob], fileName, {
                type: "audio/wav",
            });
            var formData = new FormData();
            // recorded data
            formData.append("audio-blob", fileObject);
            // file name
            formData.append("audio-filename", fileObject.name);

            console.log("formdata", formData, "blob", blob);
            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            const response = await fetch("/speech-to-text", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": token,
                },
            });

            const { transcripts } = await response.json();
            console.log(transcripts);
            console.log(questionId);
            document.getElementById(`answer_${questionId}`).value =
                transcripts.join(" ");
        } catch (error) {
            console.error("Error sending audio to server:", error);
        }
    });
}

$(document).ready(function () {
    let openCard = $(".open-card");
    let rightMessagesBtn = $(".right-messages");
    let headerUserProfile = $(".login_user");
    let openNotificationModal = $("#openNotificationModal");

    const activityCards = $(".activity-card");
    openCard.each(function (index) {
        $(this).on("click", function (event) {
            event.stopPropagation();

            activityCards.each(function (i) {
                if (i !== index) {
                    $(this).hide();
                }
            });

            const activityCard = activityCards.eq(index);
            if (
                activityCard.css("display") === "none" ||
                activityCard.css("display") === ""
            ) {
                activityCard.css("display", "flex");
            } else {
                activityCard.css("display", "none");
            }
        });
    });

    $(".activity-btn").on("click", function () {
        $(".backdrop").addClass("backdrop-open");
        $(".model-content-activity").removeClass("hide");
    });

    $("div.close").on("click", function () {
        $(".backdrop").removeClass("backdrop-open");
        $(".model-content-activity").addClass("hide");
    });

    function openModalContainer(event) {
        $(".modal-container").css("display", "block");
    }

    rightMessagesBtn.each(function () {
        $(this).on("click", openModalContainer);
    });

    function closeModalContainer(event) {
        let modalContainer = $(".modal-container");

        if (
            modalContainer.css("display") === "block" &&
            $(event.target).hasClass("modal-container")
        ) {
            modalContainer.css("display", "none");
        }
    }

    $(document).on("click", closeModalContainer);

    function handleHeaderUserProfile() {
        let userPopup = $(".user_profile_popup");
        let userProfileImage = $(".circles").find("img");
        let userName = $(".user_name_txts");

        if (userPopup.css("display") === "flex") {
            userPopup.css("display", "none");
        } else {
            userPopup.css("display", "flex");
        }

        $(document).on("click", function (event) {
            if (
                !$(event.target).is(userProfileImage) &&
                !$(event.target).is(userName) &&
                !$(event.target).is(userPopup)
            ) {
                userPopup.css("display", "none");
            }
        });
    }
    headerUserProfile.on("click", handleHeaderUserProfile);

    function closeNotificationModalContainer(event) {
        let modalContainer = $(".modal-container-notification");

        if (
            modalContainer.css("display") === "block" &&
            $(event.target).hasClass("modal-container-notification")
        ) {
            modalContainer.css("display", "none");
        }
    }

    function openNotificationModalContainer(event) {
        $(".modal-container-notification").css("display", "block");
    }
    openNotificationModal.on("click", openNotificationModalContainer);
    $(document).on("click", closeNotificationModalContainer);

    function navigateToPage(pageURL) {
        window.location.href = pageURL;
    }
});

// Function to close the modal container
function closeModalContainer(event) {
    var modalContainer = document.querySelector(".modal-container");

    // Hide the modal container
    if (
        modalContainer.style.display == "block" &&
        event.target.classList.contains("modal-container")
    ) {
        modalContainer.style.display = "none";
        let whiteSideDrawer = document.getElementsByClassName(
            "modal-side-drawer-white"
        )[0];
        let graySideDrawer = document.getElementsByClassName(
            "modal-side-drawer-gray"
        )[0];
        let conversationWrp = document.getElementsByClassName(
            "conversations-list-wrp"
        )[0];

        if (graySideDrawer) {
            //remove this current class and add another class
            graySideDrawer.classList.add("modal-side-drawer-white");
            graySideDrawer.classList.remove("modal-side-drawer-gray");
        }
        conversationWrp.style.display = "block";
    }
}

// Function to open the modal container
function openModalContainer(event) {
    var modalContainer = document.querySelector(".modal-container");
    let conversationWrap =
        document.getElementsByClassName("conversation-wrp")[0];

    // Display the modal container
    modalContainer.style.display = "block";
    conversationWrap.style.display = "none";
}
