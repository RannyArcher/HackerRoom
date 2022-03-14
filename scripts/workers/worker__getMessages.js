// this worker brings the recent messages from database
// every 500ms the server return those messages as json text
// the current worker convert them to json object
// and iterate over them, while iterating over those messages
// it will make a html code, that code will be posted to main.js
// after posting the code, main.js will put it in messages section




self.onmessage = function (event) {

    let USER_ID = event.data;

    setInterval(() => {

        fetch("/essentials/getMessages.php")
            .then((r) => {
                if (r.ok) {
                    return r.json();
                }
            })
                .then((messages) => {

                    if ( messages.length ) {

                        let htmlOutput = '';
                        let htmlCodeMine = `<div class="message-row mine"><div class="message">MESSAGE</div></div>`;
                        let htmlCode = `<div class="message-row"><div class="sender-info">&lt;FULLNAME&gt;: </div><div class="message">MESSAGE</div></div>`;

                        for (message of messages) {

                            if (message.sender_id == USER_ID) {

                                htmlOutput += htmlCodeMine.replace("MESSAGE", message.message);
                                continue;
                            }

                            htmlOutput += htmlCode.replace("MESSAGE", message.message)
                            .replace("FULLNAME", message.fullname);

                        }

                        postMessage(htmlOutput);
                    
                    }

                })

    }, 500);

}