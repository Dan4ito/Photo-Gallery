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

function uploadImage() {
    event.preventDefault();

    let imageDescription = document.getElementById('imageDescriptionInput').value;
    let fileInput = document.getElementById('fileInput');
    console.log()
    const formData = new FormData();

    formData.append('fileDescription', imageDescription);
    formData.append('file', fileInput.files[0]);


    fetch('../../Web Layer/controllers/uploadImage.php', {
            method: 'POST',
            body: formData,
            //If you add this, upload won't work
            // headers: {
            //   'Content-Type': 'multipart/form-data',
            // }
        }).then(response => window.location.replace(response.url))
        .catch(error => console.log(error))
};

function createGallery() {
    event.preventDefault();

    let galleryNameInput = document.getElementById('galleryNameInput').value;

    fetch('../../Web Layer/controllers/createGallery.php', {
            method: 'POST',
            body: JSON.stringify({
                galleryName: galleryNameInput
            }),
            headers: {
                'Content-Type': 'application/json',
            }
        }).then(response => window.location.replace(response.url))
        .catch(error => console.log(error))
};

function deleteGallery(galleryId) {
    event.preventDefault();


    fetch('../../Web Layer/controllers/deleteGallery.php', {
            method: 'DELETE',
            body: JSON.stringify({
                galleryId: galleryId
            }),
            headers: {
                'Content-Type': 'application/json',
            }
        }).then(response => window.location.replace(response.url))
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