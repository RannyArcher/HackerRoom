// this is for the chatting area
let messagesSection = document.getElementById("messages-section");

worker__getMessages = new Worker("/scripts/workers/worker__getMessages.js");
worker__getMessages.postMessage(USER_ID); // USER_ID will be set using php
worker__getMessages.onmessage = function (event) {
    messagesSection.innerHTML += event.data;
    messagesSection.scrollTop = messagesSection.scrollHeight;
}










// this is for the online users
let onlineUsersSection = document.getElementById("online-users-section");

worker__getOnlineUsers = new Worker("/scripts/workers/worker__getOnlineUsers.js");
worker__getOnlineUsers.onmessage = function (event) {
    onlineUsersSection.innerHTML = event.data;
}





// message input form
let messageForm = document.querySelector(".form-row")

messageForm.addEventListener("submit", (event) => {
    // this will send message to the database
    // in case it wasn't empty or only whitespaces
    if ( messageForm.firstElementChild.value.trim() ) {
        fetch(messageForm.action, {
            method: messageForm.method,
            body: new FormData(messageForm)
        });

        messageForm.firstElementChild.value = ""
    }
    

    event.preventDefault()
})