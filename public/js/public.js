const openProfileDropDown = () => {
    let profileDropdown = document.getElementsByClassName("profile-dropdown")
    profileDropdown[0].classList.toggle('is-active')
}

const openChatDrawer = () => {
    let profileDropdown = document.getElementsByClassName("chats-list")
    profileDropdown[0].classList.toggle('is-active')
}
