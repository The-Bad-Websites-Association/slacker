let form = document.getElementById('newUserForm');
let errorBox = document.getElementById('errorBox');

form.addEventListener('submit', function (e) {
    e.preventDefault()
    let username = escapeHtml(document.getElementById('username').value);
    let passwd1 =  escapeHtml(document.getElementById('pass1').value);
    let passwd2 = escapeHtml(document.getElementById('pass2').value);

    createUser(username, passwd1, passwd2)
        .then(response => response.json())
        .then(response => errorBox.textContent = response.message)
        .catch(function (error) {
        console.log(error);
    });

});

async function createUser(user, pass1, pass2) {

    let account_data = {
        username: user,
        password: pass1,
        password2: pass2
    };

    console.log(JSON.stringify(account_data))

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(account_data)
    };

    let response = await fetch('functions/user/new_user.php', fetch_data);
    return response;
}