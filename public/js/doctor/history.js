$(document).ready(function () {
    let currentMonth = $(".current-month");
    let currentMonths = $(".current-months");
    let calendarDays = $(".calendar-days");
    let today = new Date();
    let date = new Date();
    let openCard = $(".open-card");
    let rightMessagesBtn = $(".right-messages");
    let headerUserProfile = $(".login_users");
    let openNotificationModal = $("#openNotificationModal");

    currentMonth.text(
        date.toLocaleDateString("en-IN", {
            month: "long",
            year: "numeric",
        })
    );
    today.setHours(0, 0, 0, 0);
    currentMonths.text(
        date.toLocaleDateString("en-IN", {
            day: "2-digit",
            month: "long",
            year: "numeric",
        })
    );
    today.setHours(0, 0, 0, 0);
    renderCalendar();

    function renderCalendar() {
        const prevLastDay = new Date(
            date.getFullYear(),
            date.getMonth(),
            0
        ).getDate();
        const totalMonthDay = new Date(
            date.getFullYear(),
            date.getMonth() + 1,
            0
        ).getDate();
        const startWeekDay = new Date(
            date.getFullYear(),
            date.getMonth(),
            1
        ).getDay();
        calendarDays.html("");
        let totalCalendarDay = 6 * 7;
        for (let i = 0; i < totalCalendarDay; i++) {
            let day = i - startWeekDay;
            if (i <= startWeekDay) {
                // adding previous month days
                calendarDays.append(
                    `<div class='padding-day'>${prevLastDay - i}</div>`
                );
            } else if (i <= startWeekDay + totalMonthDay) {
                // adding this month days
                date.setDate(day);
                date.setHours(0, 0, 0, 0);
                let dayClass =
                    date.getTime() === today.getTime()
                        ? "current-day"
                        : "month-day";
                let $dayElement = $(`<div class='${dayClass}'>${day}</div>`);

                // Add click event to select date
                $dayElement.addClass("month-day").on("click", function () {
                    $(".current-day").removeClass("current-day");
                    $(this).addClass("current-day");

                    // Handle logic when a date is selected here...
                    // For example, trigger an AJAX call to fetch appointments
                });

                calendarDays.append($dayElement);
            } else {
                // adding next month days
                calendarDays.append(
                    `<div class='padding-day'>${day - totalMonthDay}</div>`
                );
            }
        }

        // Ensure current day is set on initial render
        // $(".current-day").removeClass("current-day");
        const todayElement = $(`.month-day:contains(${today.getDate()})`);
        console.log("todayElement", todayElement, "today", today);
        // if (todayElement.length > 0) {
        //     todayElement.addClass("current-day");
        // }
    }

    // Function to change the date on the right side
    function changeRightSideDate(selectedDate) {
        $(".content-right .status").text(
            selectedDate.toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            })
        );

        $(".current-months").text(
            selectedDate.toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            })
        );
    }

    $(document).on("click", ".month-day", function () {
        let day = parseInt($(this).text());
        let month = $(".current-month").text().split(" ")[0];
        let year = $(".current-month").text().split(" ")[1];

        // Construct the date directly with year, month, and day values
        let selectedDate = new Date(year, monthToNumber(month) - 1, day);
        let selectedDateAjax = `${year}-${padZero(
            monthToNumber(month)
        )}-${padZero(day)}`;

        changeRightSideDate(selectedDate);
        getHistory(selectedDateAjax);
    });

    // Helper function to convert month name to number
    function monthToNumber(month) {
        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];
        return months.indexOf(month) + 1;
    }

    // Helper function to pad single-digit months or days with zero
    function padZero(num) {
        return num.toString().padStart(2, "0");
    }

    $(".soft-btn").on("click", function () {
        date = new Date(currentMonth.text());
        let dates = new Date(currentMonths.text());
        date.setMonth(date.getMonth() + ($(this).hasClass("prev") ? -1 : 1));
        currentMonth.text(
            date.toLocaleDateString("en-US", {
                month: "long",
                year: "numeric",
            })
        );
        currentMonths.text(
            date.toLocaleDateString("en-US", {
                day: "2-digit",
                month: "long",
                year: "numeric",
            })
        );
        renderCalendar();
    });

    $(".btn").on("click", function () {
        let btnClass = $(this).attr("class");
        date = new Date(currentMonth.text());
        if (btnClass.includes("today")) date = new Date();
        else if (btnClass.includes("prev-year"))
            date = new Date(date.getFullYear() - 1, 0, 1);
        else date = new Date(date.getFullYear() + 1, 0, 1);
        currentMonth.text(
            date.toLocaleDateString("en-US", {
                month: "long",
                year: "numeric",
            })
        );
        renderCalendar();
    });

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

$(document).ready(function () {
    // Function to change the date
    function changeDate(delta) {
        let currentDate = new Date($(".current-months").text());
        currentDate.setDate(currentDate.getDate() + delta);

        // Update the displayed date
        $(".current-months").text(
            currentDate.toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            })
        );

        // Update the date on the right side
        $(".content-right .status").text(
            currentDate.toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            })
        );
        // Get the year, month, and day values from the currentDate object
        let year = currentDate.getFullYear();
        let month = String(currentDate.getMonth() + 1).padStart(2, "0"); // Adding 1 to month because it's zero-based
        let day = String(currentDate.getDate()).padStart(2, "0");

        // Format the date as 'Y-m-d' (Year-Month-Day)
        let formattedDate = `${year}-${month}-${day}`;
        getHistory(formattedDate);
    }

    // Event listener for the "Prev" button
    $("#prevBtn").click(function () {
        changeDate(-1);
    });

    // Event listener for the "Next" button
    $("#nextBtn").click(function () {
        changeDate(1);
    });

    // Event listener for the "Today" text
    $(".today-btn").click(function () {
        // Set the date to the current date
        let today = new Date();
        $(".current-months").text(
            today.toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            })
        );

        // Update the date on the right side to today's date
        $(".content-right .status").text(
            today.toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            })
        );

        // Get the year, month, and day values from the currentDate object
        let year = today.getFullYear();
        let month = String(today.getMonth() + 1).padStart(2, "0"); // Adding 1 to month because it's zero-based
        let day = String(today.getDate()).padStart(2, "0");

        // Format the date as 'Y-m-d' (Year-Month-Day)
        let formattedDate = `${year}-${month}-${day}`;
        getHistory(formattedDate);
    });
});

function convertToAMPM(dateTimeString) {
    const dateTime = new Date(dateTimeString);

    // Get hours and minutes
    let hours = dateTime.getHours();
    const minutes = dateTime.getMinutes();

    // Convert hours to AM/PM format
    const ampm = hours >= 12 ? "PM" : "AM";
    hours %= 12;
    hours = hours || 12; // Handle midnight (0 hours)

    // Format minutes to have leading zero if less than 10
    const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;

    // Construct the formatted time string
    const formattedTime = `${hours}:${formattedMinutes} ${ampm}`;

    return formattedTime;
}

// Function to calculate age from birthdate
function calculateAge(birthdate) {
    const today = new Date();
    const dob = new Date(birthdate);
    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();

    // Check if the current month is before the birth month
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    return age;
}

// Function to fetch appointments via AJAX
function getHistory(selectedDate) {
    $.ajax({
        url: "/doctor/getHistory",
        type: "GET",
        data: {
            selectedDate: selectedDate,
        },
        success: function (response) {
            // Clear previous appointments
            $(".card-right").empty();

            // Append the newly fetched appointments
            response.appointments.forEach((appointment) => {
                // Generate HTML for each appointment and append it to .card-right
                let imageSrc =
                    appointment.booking_type === "video"
                        ? "../assets/images/video-camera-alt.svg"
                        : "../assets/images/hospital-user(1).svg";

                let imageAlt =
                    appointment.booking_type === "video"
                        ? "video-camera"
                        : "hospital-user";
                // Generate HTML for each appointment and append it to .card-right
                $(".card-right").append(`
                    <div class="card-right-content">
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <img src="${imageSrc}" alt="${imageAlt}" style="height: 24px; width: 24px;" />
                            <div>
                                <div onclick="navigateToPage('/gp/patient-details.html')" class="card-right-name">${
                                    appointment.user.name
                                }</div>
                                <div class="card-right-details">
                                    <div>${
                                        appointment.medicare_detail.gender
                                    }</div>
                                    <div>${calculateAge(
                                        appointment.medicare_detail.birthdate
                                    )} Years</div>
                                    <div>${
                                        appointment.user.country_code +
                                        "-" +
                                        appointment.user.mobile
                                    }</div>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button class="right-other-ajax">
                                    <img src="/assets/images/description_black_24dp.svg" alt="video-camera" style="width: 24px; height: 16px">
                                    <div class="right-video-start">Other</div>
                                </button>
                                <button class="right-note-ajax">
                                    <img src="/assets/images/history_edu_black_24dp.svg" alt="video-camera" style="width: 24px; height: 16px">
                                    <div class="right-video-start">Note</div>
                                </button>
                                <button class="right-ref-ajax">
                                    <img src="/assets/images/email_black_24dp.svg" alt="video-camera" style="width: 24px; height: 16px">
                                    <div class="right-video-start">Referral Letter</div>
                                </button>
                            <button class="right-messages openChatModel" >
                                        <img src="../assets/images/messages.svg" alt="message"
                                            style="width: 28px;height: 28px;margin: 0 20px;">
                                    </button>
                                    <button class="open-card"
                                        style="position: relative;border-style: none;margin-right: 20px;margin-left:18px;">
                                        <i class='fa fa-ellipsis-v'></i>
                                        <div class="activity-card"
                                            style="z-index:2;position: absolute;background: #FFF;width: 138px;height: 120px;box-shadow: 0px 3px 6px #00000029;border-radius: 7px;right:0;margin-right:1rem;margin-top:-1.5rem;display:none;flex-direction: column;align-items: flex-start;row-gap: 1.5rem;padding: 1rem;">
                                            <span>Notify</span>
                                            <span class="activity-btn">Activity</span>
                                        </div>
                                    </button>                        </div>
                    </div>
                `);
                // Append modal content
                const otherInfoModalContent = `
                <div class="detail-card hide model-content-other">
                    <div class="title-ref">
                        <p class="text-grey2 text-22 font-bold">Other Information</p>
                    </div>
                    <div class="px-36 user-ref">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="text-purple text-30 font-bold mr-15">${
                                    appointment.user.name
                                }</p>
                                <p class="text-grey3 text-15 font-thin">
                                    ${appointment.medicare_detail.gender}
                                    <span class="ml-10">${Math.abs(
                                        new Date(
                                            new Date() -
                                                new Date(
                                                    appointment.medicare_detail.birthdate
                                                )
                                        ).getUTCFullYear() - 1970
                                    )}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center mt-16">
                            <p class="text-grey3 text-xs font-thin">
                                Contact:
                                <span class="font-normal">${
                                    appointment.user.country_code +
                                    "-" +
                                    appointment.user.mobile
                                }</span>
                            </p>
                            <p class="text-grey3 text-xs font-thin ml-30">
                                Medicare No. :
                                <span class="font-normal">${
                                    appointment.medicare_detail.medicare_number
                                }</span>
                            </p>
                            <p class="text-grey3 text-xs font-thin ml-30">
                                Last Visited:
                                <span class="font-normal">${
                                    appointment.last_visited
                                }</span>
                            </p>
                        </div>
                    </div>
                    <div class="details-note">
                        <p class="text-grey2 text-18 font-normal mt-16">Presenting Complaints</p>
                        <p class="text-grey2 text-base font-thin mt-8">${
                            appointment.otherInfo &&
                            appointment.otherInfo.presenting_complaints
                                ? appointment.otherInfo.presenting_complaints
                                : ""
                        }</p>
                        <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
                        <p class="text-grey2 text-base font-thin mt-8">${
                            appointment.otherInfo &&
                            appointment.otherInfo.relevant_history
                                ? appointment.otherInfo.relevant_history
                                : ""
                        }</p>
                        <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
                        <p class="text-grey2 text-base font-thin mt-8">${
                            appointment.otherInfo &&
                            appointment.otherInfo.examination
                                ? appointment.otherInfo.examination
                                : ""
                        }</p>
                        <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
                        <p class="text-grey2 text-base font-thin mt-8">${
                            appointment.otherInfo &&
                            appointment.otherInfo.recommendation
                                ? appointment.otherInfo.recommendation
                                : ""
                        }</p>
                        <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
                        <p class="text-grey2 text-base font-thin mt-8">${
                            appointment.otherInfo &&
                            appointment.otherInfo.followup
                                ? appointment.otherInfo.followup
                                : ""
                        }</p>
                        <p class="text-grey2 text-18 font-normal mt-16">Personalization Framework</p>
                        <p class="text-grey2 text-base font-thin mt-8">${
                            appointment.otherInfo &&
                            appointment.otherInfo.personalization_framework
                                ? appointment.otherInfo
                                      .personalization_framework
                                : ""
                        }</p>
                    </div>
                </div>
            `;

                const noteModalContent = `
            <div class="detail-card hide model-content-note">
                <div class="title-ref">
                    <p class="text-grey2 text-22 font-bold">Other Information</p>
                </div>
                <div class="px-36 user-ref">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <p class="text-purple text-30 font-bold mr-15">${
                                appointment.user.name
                            }</p>
                            <p class="text-grey3 text-15 font-thin">
                                ${appointment.medicare_detail.gender}
                                <span class="ml-10">${Math.abs(
                                    new Date(
                                        new Date() -
                                            new Date(
                                                appointment.medicare_detail.birthdate
                                            )
                                    ).getUTCFullYear() - 1970
                                )}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center mt-16">
                        <p class="text-grey3 text-xs font-thin">
                            Contact:
                            <span class="font-normal">${
                                appointment.user.country_code +
                                "-" +
                                appointment.user.mobile
                            }</span>
                        </p>
                        <p class="text-grey3 text-xs font-thin ml-30">
                            Medicare No. :
                            <span class="font-normal">${
                                appointment.medicare_detail.medicare_number
                            }</span>
                        </p>
                        <p class="text-grey3 text-xs font-thin ml-30">
                            Last Visited:
                            <span class="font-normal">${
                                appointment.last_visited
                            }</span>
                        </p>
                    </div>
                </div>
                <div class="details-note">
                    <p class="text-grey2 text-18 font-normal mt-16">Presenting Complaints</p>
                    <p class="text-grey2 text-base font-thin mt-8">${
                        appointment.notes &&
                        appointment.notes.presenting_complaints
                            ? appointment.notes.presenting_complaints
                            : ""
                    }</p>
                    <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
                    <p class="text-grey2 text-base font-thin mt-8">${
                        appointment.notes && appointment.notes.relevant_history
                            ? appointment.notes.relevant_history
                            : ""
                    }</p>
                    <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
                    <p class="text-grey2 text-base font-thin mt-8">${
                        appointment.notes && appointment.notes.examination
                            ? appointment.notes.examination
                            : ""
                    }</p>
                    <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
                    <p class="text-grey2 text-base font-thin mt-8">${
                        appointment.notes && appointment.notes.recommendation
                            ? appointment.notes.recommendation
                            : ""
                    }</p>
                    <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
                    <p class="text-grey2 text-base font-thin mt-8">${
                        appointment.notes && appointment.notes.followup
                            ? appointment.notes.followup
                            : ""
                    }</p>
                    <p class="text-grey2 text-18 font-normal mt-16">Personalization Framework</p>
                    <p class="text-grey2 text-base font-thin mt-8">${
                        appointment.notes &&
                        appointment.notes.personalization_framework
                            ? appointment.notes.personalization_framework
                            : ""
                    }</p>
                </div>
            </div>
        `;

                const refeModalContent = `
            <div class="detail-card hide model-content">
                <div class="title-ref">
                    <p class="text-grey2 text-22 font-bold">Other Information</p>
                </div>
                <div class="px-36 user-ref">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <p class="text-purple text-30 font-bold mr-15">${
                                appointment.user.name
                            }</p>
                            <p class="text-grey3 text-15 font-thin">
                                ${appointment.medicare_detail.gender}
                                <span class="ml-10">${Math.abs(
                                    new Date(
                                        new Date() -
                                            new Date(
                                                appointment.medicare_detail.birthdate
                                            )
                                    ).getUTCFullYear() - 1970
                                )}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center mt-16">
                        <p class="text-grey3 text-xs font-thin">
                            Contact:
                            <span class="font-normal">${
                                appointment.user.country_code +
                                "-" +
                                appointment.user.mobile
                            }</span>
                        </p>
                        <p class="text-grey3 text-xs font-thin ml-30">
                            Medicare No. :
                            <span class="font-normal">${
                                appointment.medicare_detail.medicare_number
                            }</span>
                        </p>
                        <p class="text-grey3 text-xs font-thin ml-30">
                            Last Visited:
                            <span class="font-normal">${
                                appointment.last_visited
                            }</span>
                        </p>
                    </div>
                </div>
                <div class="details-ref px-36 py-20">
        <p class="text-grey2 text-xs font-normal">Date:
        ${$.datepicker.formatDate('DD d MM yy', new Date(appointment.ref_letter.date))}
        </p>
            <p class="text-grey2 text-xs font-normal mt-16">
                To
                <br />
                ${
                    appointment.ref_letter && appointment.ref_letter.refer_to
                        ? appointment.ref_letter.refer_to
                        : ""
                }
            </p>
        <p class="text-grey2 text-xs font-bold mt-16">
            Subject
            <span class="font-normal">${
                appointment.ref_letter && appointment.ref_letter.subject
                    ? appointment.ref_letter.subject
                    : ""
            }
            </span>
        </p>
        <p class="text-grey2 text-xs font-normal text-justify">
        ${
            appointment.ref_letter && appointment.ref_letter.content
                ? appointment.ref_letter.content
                : ""
        }
        </p>
    </div>
            </div>
        `;

                // Append modal content to the body or an appropriate container
                $("body").append(otherInfoModalContent);
                $("body").append(noteModalContent);
                $("body").append(refeModalContent);
                $("body").append('<div class="backdrop close"></div>');
            });
            // Setup the modal functionality after appending modal content
        },
        error: function (error) {
            console.error("Error fetching appointments:", error);
        },
    });
}

$(document).ready(function () {
    function setupModal(btnClass, contentClass) {
        $(document).on("click", `button.${btnClass}`, function () {
            const modelBackdrop = $(".backdrop");
            const modelContent = $(`.${contentClass}`);
            modelBackdrop.addClass("backdrop-open");
            modelContent.removeClass("hide");
        });

        $(document).on("click", "div.close", function () {
            const modelBackdrop = $(".backdrop");
            const modelContent = $(`.${contentClass}`);
            modelBackdrop.removeClass("backdrop-open");
            modelContent.addClass("hide");
        });
    }

    setupModal("right-ref", "model-content");
    setupModal("right-note", "model-content-note");
    setupModal("right-other", "model-content-other");

    // Function to open the modal container
    function openModalContainer(event) {
        const modalContainer = $(".modal-container");
        const conversationWrap = $(".conversation-wrp").eq(0);

        // Display the modal container
        modalContainer.css("display", "block");
    }

    $(document).on(
        "click",
        ".right-messages-btn , .right-messages",
        openModalContainer
    );

    $(document).on("click", ".right-other-ajax", function () {
        const modelBackdrop = $(".backdrop");
        const modelContent = $(".model-content-other");
        modelBackdrop.addClass("backdrop-open");
        modelContent.removeClass("hide");
    });

    $(document).on("click", ".right-note-ajax", function () {
        const modelBackdrop = $(".backdrop");
        const modelContent = $(".model-content-note");
        modelBackdrop.addClass("backdrop-open");
        modelContent.removeClass("hide");
    });
    $(document).on("click", ".right-ref-ajax", function () {
        const modelBackdrop = $(".backdrop");
        const modelContent = $(".model-content");
        modelBackdrop.addClass("backdrop-open");
        modelContent.removeClass("hide");
    });
});
