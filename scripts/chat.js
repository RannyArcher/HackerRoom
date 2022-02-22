// this is for the chatting area
let messagesSection = document.getElementById("messages-section")
setInterval(() => {
    fetch("../essentials/getMessage.php")
        .then((r) => {
            if (r.ok) {
                return r.text()
            }
        }).then((d) => {
            if (d !== "") {
                messagesSection.innerHTML += d
            }
        })
}, 500)










// this is for the online users
let onlineUsersSection = document.getElementById("online-users-section")
setInterval(async () => {
    await fetch("../essentials/getOnlineUsers.php")
        .then((r) => {
            if (r.ok) {
                return r.text()
            }
        }).then((d) => {
            if (!(d === onlineUsersSection.innerHTML)) {
                onlineUsersSection.innerHTML = d
            }
        })
}, 500);








// message entry form
let messageForm = document.querySelector(".form-row")
messageForm.addEventListener("submit", (e) => {

    // this will send message to the database
    fetch(messageForm.action, {
        method: messageForm.method,
        body: new FormData(messageForm)
    })

    messageForm.firstElementChild.value = ""

    e.preventDefault()
})