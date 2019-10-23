let messageBox = document.getElementById('messageBox')
let message = document.getElementById('message')
let errorBox = document.getElementById('errorBox');

messageBox.addEventListener('submit', function (e) {
    e.preventDefault()

    let new_message = {
        user: localStorage.getItem('user'),
        message_data: message.value,
        channel: 1,
        token: localStorage.getItem('tokenActive')
    };

    console.log(JSON.stringify(new_message));

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(new_message)
    };

    fetch('functions/msg/newMsg.php', fetch_data)
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

    })

})