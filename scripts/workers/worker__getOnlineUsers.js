// this worker brings the onlines users from database
// and then it turns them into html code
// after that the html code will be sent to main.js
// main.js will put them at the online users section


let last_users_array, htmlCode, htmlOutput;

setInterval(() => {
    fetch("/essentials/getOnlineUsers.php")
        .then((d) => {
            if (d.ok) {
                postMessage("ok")
                return d.json()
            }
        })
            .then((users_array) => {
                if (users_array != last_users_array) {


                    htmlCode = "<div class='online-user'>FULLNAME</div>";
                    htmlOutput = "";

                    for (user of users_array) {
    
                        htmlOutput += htmlCode.replace("FULLNAME", user.fullname);
                
                    }

                    postMessage(htmlOutput);
                    last_users_array = users_array;
                }
            })

}, 1000);
