async function checkAuth() {

    let token_data = {
        token: localStorage.getItem('tokenActive')
    };

    console.log(JSON.stringify(token_data));

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(token_data)
    };

    let response = await fetch('functions/user/auth.php', fetch_data);
    return response;
}

async function logoutUser() {

    let account_data = {
        username: localStorage.getItem('user'),
        token: localStorage.getItem('tokenActive')
    };

    console.log(JSON.stringify(account_data));

    let fetch_data = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(account_data)
    };

    let response = await fetch('functions/user/logout.php', fetch_data);
    return response;
}

checkAuth().then(authData => authData.json()).then(authData => {
    if (authData.auth === false) {
        window.location.replace("login.html");
        document.querySelector('body').style.display = "none";
    } else {
        console.log('login authorised')
        document.querySelector('body').style.display = "block";
    }
})

document.getElementById('username').innerText = localStorage.getItem('user')

document.getElementById('logout').addEventListener('click', function (e) {
    e.preventDefault()
    logoutUser().then(response => console.log(response))
    localStorage.setItem('user', '');
    window.location.replace("login.html");
})