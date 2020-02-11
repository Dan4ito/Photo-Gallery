function toggleTextInput() {
    let status = document.getElementById("galleryInfo").style.visibility;
    document.getElementById("galleryInfo").style.visibility = status === "hidden" ? "visible" : "hidden";
}

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