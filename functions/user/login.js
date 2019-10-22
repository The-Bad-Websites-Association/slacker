let form = document.getElementById('userForm');
let errorBox = document.getElementById('errorBox');

form.addEventListener('submit', function (e) {
    e.preventDefault()
    let username = escapeHtml(document.getElementById('username').value);
    let password =  escapeHtml(document.getElementById('pass').value);

    loginUser(username, password)
        .then(response => response.json())
        .then(response => {
            if(response.success === true) {
                localStorage.setItem('user', response.user)
                localStorage.setItem('tokenActive', response.token)
                window.location.replace("index.html");
            } else {
                errorBox.textContent = response.message
            }
        })
        .catch(function (error) {
        console.log(error);
    });

});

async function loginUser(user, password) {

    let account_data = {
        username: user,
        password: password
    };

    console.log(JSON.stringify(account_data));

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(account_data)
    };

    let response = await fetch('functions/user/login.php', fetch_data);
    return response;
}