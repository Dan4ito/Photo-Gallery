submitLoginForm = async() => {
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

submitLogoutForm = async() => {
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

submitCreateForm = async() => {
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

uploadImage = async(galleryId) => {
    event.preventDefault();

    let imageDescription = document.getElementById('imageDescriptionInput').value;
    let fileInput = document.getElementById('fileInput');
    let compression = document.getElementById("resize").value;
    if (compression == "") {
        compression = "0";
    }

    const formData = new FormData();
    formData.append('fileDescription', imageDescription);
    formData.append('file', fileInput.files[0]);
    formData.append('galleryId', parseInt(galleryId));
    formData.append('compression', parseInt(compression));

    try {
        const response = await fetch('../../Web Layer/controllers/uploadImage.php', {
            method: 'POST',
            body: formData
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

deleteImageFromGallery = async(imageId, galleryId) => {
    event.preventDefault();

    try {
        const response = await fetch('../../Web Layer/controllers/deleteImage.php', {
            method: 'DELETE',
            body: JSON.stringify({
                imageId: imageId,
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

createGallery = async() => {
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

deleteGallery = async(galleryId) => {
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

toggleGalleryType = async(galleryId) => {
    event.preventDefault();

    try {
        const response = await fetch('../../Web Layer/controllers/toggleGalleryType.php', {
            method: 'POST',
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

openGallery = async(galleryId) => {
    event.preventDefault();

    try {
        const response = await fetch('../../Web Layer/controllers/openGallery.php', {
            method: 'POST',
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

sortImages = async(galleryId) => {
    event.preventDefault();

    let sortType = document.getElementById("sortImages").value;
    try {
        const response = await fetch('../../Web Layer/controllers/sortImages.php', {
            method: 'POST',
            body: JSON.stringify({
                galleryId: galleryId,
                sorting: sortType
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

mergeGalleries = async(galleryIds) => {
    event.preventDefault();
    try {
        const response = await fetch('../../Web Layer/controllers/mergeGalleries.php', {
            method: 'POST',
            body: JSON.stringify({
                galleryIds: galleryIds
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