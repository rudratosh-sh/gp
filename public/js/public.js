const openProfileDropDown = () => {
    let profileDropdown = document.getElementsByClassName("profile-dropdown");
    profileDropdown[0].classList.toggle("is-active");
};

const openChatDrawer = () => {
    let profileDropdown = document.getElementsByClassName("chats-list");
    profileDropdown[0].classList.toggle("is-active");
};

var dashboardTab = document.getElementById("dashboard-tab");
var bookingTab = document.getElementById("booking-tab");
var referralTab = document.getElementById("referral-tab");
var profileTab = document.getElementById("profile-tab");

// Function to handle the click event on booking tab
function handleBookingClick() {
    // Remove active class from all tabs
    var tabs = document.getElementsByTagName("li");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("active");
    }

    // Add active class to booking tab
    bookingTab.classList.add("active");

    // Navigate to the booking page
    window.location.href = "page4.html"; // Replace 'page4.html' with the path to your booking page
}

// // Attach click event listener to booking tab
// bookingTab.addEventListener("click", handleBookingClick);

// // Function to handle the click event on referral tab
// function handleReferralClick() {
//     // Remove active class from all tabs
//     var tabs = document.getElementsByTagName("li");
//     for (var i = 0; i < tabs.length; i++) {
//         tabs[i].classList.remove("active");
//     }

//     // Add active class to referral tab
//     referralTab.classList.add("active");

//     // Navigate to the referral page
//     window.location.href = "page11.html"; // Replace 'page11.html' with the path to your referral page
// }

// // Attach click event listener to referral tab
// referralTab.addEventListener("click", handleReferralClick);

// function navigateToPage(pageURL) {
//     window.location.href = pageURL;
// }
