function submitLoginForm() {
    event.preventDefault();

    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var formData = JSON.stringify({
        email: email,
        password: password
    });

    fetch('../../Web Layer/controllers/login.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (response.status < 400) {
                window.location.replace(response.url)
            } else {
                throw new Error("Error logging in");
            }
        })
        .catch(error => console.log(error))
};

function submitLogoutForm() {
    event.preventDefault();

    fetch('../../Web Layer/controllers/logout.php', {
            method: 'GET',
        }).then(response => window.location.replace(response.url))
        .catch(error => console.log(error))
};

function submitFindAllForm() {
    event.preventDefault();

    fetch('../../Web Layer/controllers/users.php', {
            method: 'GET',
        }).then(response => console.log(response))
        .catch(error => console.log(error))
};

function submitCreateForm() {
    event.preventDefault();

    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var formData = JSON.stringify({
        email: email,
        username: username,
        password: password
    });

    fetch('../../Web Layer/controllers/register.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => console.log(response))
        .catch(error => console.log(error))
};


function clearInputFields() {
    var email = document.getElementById('email');
    if (email != null) {
        email.value = "";
    }

    var username = document.getElementById('username');
    if (username != null) {
        username.value = "";
    }

    var password = document.getElementById('password');
    if (password != null) {
        password.value = "";
    }
}