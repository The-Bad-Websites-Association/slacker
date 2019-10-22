const input = document.getElementById('composer')
const messages = document.getElementById('message-box')

input.addEventListener('submit', function (e) {
    e.preventDefault()
    e.stopPropagation()

    let user = document.getElementById('user').value
    let message = document.getElementById('message').value

    sendMessage(user, message)

})

async function sendMessage(user, content) {

    let message_data = {
        username: user,
        message_content: content
    }

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(message_data)
    }

    let response = await fetch('inbox.php', fetch_data)

    response = response.json()
    let responseStore = response.data

    messages.innerHTML += "<p><strong>" + responseStore.username + ": </strong>" + responseStore.message_content + "</p>"

}