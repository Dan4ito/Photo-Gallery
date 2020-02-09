submitLoginForm = async () => {
    event.preventDefault();

    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var formData = JSON.stringify({
        email: email,
        password: password
    });

    try {
        const response = await fetch('../../Web Layer/controllers/login.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'application/json'
            },
        });
        if (response.status < 400) {
            window.location.replace(response.url)
        } else {
            const body = await response.json();
            throw new Error(body.error);
        }
    } catch (error) {
        alert(error);
    }
};

submitLogoutForm = async () => {
    event.preventDefault();
    try {
        const response = await fetch('../../Web Layer/controllers/logout.php', {
            method: 'GET',
        });

        if (response.status < 400) {
            window.location.replace(response.url)
        } else {
            const body = await response.json();
            throw new Error(body.error);
        }
    } catch (error) {
        alert(error);
    }
};

submitCreateForm = async () => {
    event.preventDefault();

    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var formData = JSON.stringify({
        email: email,
        username: username,
        password: password
    });

    try {
        const response = await fetch('../../Web Layer/controllers/register.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (response.status < 400) {
            alert("Successfully created an account!")
        } else {
            const body = await response.json();
            throw new Error(body.error);
        }
    } catch (error) {
        alert(error);
    }
};

uploadImage = async () => {
    event.preventDefault();

    let imageDescription = document.getElementById('imageDescriptionInput').value;
    let fileInput = document.getElementById('fileInput');
    const formData = new FormData();

    formData.append('fileDescription', imageDescription);
    formData.append('file', fileInput.files[0]);

    try {
        const response = await fetch('../../Web Layer/controllers/uploadImage.php', {
            method: 'POST',
            body: formData
        });
        debugger;
        if (response.status < 400) {
            window.location.replace(response.url)
        } else {
            const body = await response.json();
            throw new Error(body.error);
        }
    } catch (error) {
        alert(error);
    }
};

createGallery = async () => {
    event.preventDefault();

    let galleryNameInput = document.getElementById('galleryNameInput').value;

    try {
        const response = await fetch('../../Web Layer/controllers/createGallery.php', {
            method: 'POST',
            body: JSON.stringify({
                galleryName: galleryNameInput
            }),
            headers: {
                'Content-Type': 'application/json',
            }
        });
        if (response.status < 400) {
            window.location.replace(response.url)
        } else {
            const body = await response.json();
            throw new Error(body.error);
        }
    } catch (error) {
        alert(error);
    }
};

deleteGallery = async (galleryId) => {
    event.preventDefault();

    try {
        const response = await fetch('../../Web Layer/controllers/deleteGallery.php', {
            method: 'DELETE',
            body: JSON.stringify({
                galleryId: galleryId
            }),
            headers: {
                'Content-Type': 'application/json',
            }
        });
        if (response.status < 400) {
            window.location.replace(response.url)
        } else {
            const body = await response.json();
            throw new Error(body.error);
        }
    } catch (error) {
        alert(error);
    }
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