let messageBox = document.getElementById('message-box')
let message = document.getElementById('message')
let errorBox = document.getElementById('errorBox');
let messageDisplay = document.getElementById('message-display');
let Display = document.getElementById('display');
let messages = null;

Display.scrollTop = Display.scrollHeight;

function getMessages(){
    messageDisplay.innerHTML = ''
    let request = {
        user: localStorage.getItem('user'),
        channel: 1,
        token: localStorage.getItem('tokenActive')
    };

    console.log(JSON.stringify(request));

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(request)
    };

    fetch('functions/msg/get_msgs.php', fetch_data)
        .then(response => {
            return response;
        })
        .then(response => response.json())
        .then(response => {
            console.log(response)
            localStorage.setItem('tokenActive', response.token);
            errorBox.innerText = response.message;
            console.log(response.token)
            console.log(localStorage.getItem('tokenActive'))
            messages = response.message_list
            console.log(response)
            setTimeout(function () {
                displayMessages()
                Display.scrollTop = Display.scrollHeight;
            },10)

        })

}

function displayMessages() {
    messages.forEach(function (messageItem) {
        messageDisplay.innerHTML += '<tr><td><strong>' + messageItem.user + '</strong>: '+ messageItem.message + '</td></tr>'
    })
}

getMessages()