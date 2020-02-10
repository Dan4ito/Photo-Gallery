function open() {
    document.getElementById("imageToBeExpanded").style.display = "block";
}

function expandImage(image) {
    event.preventDefault();
    var container = document.getElementById("polaroid");
    var expandedImage = document.getElementById("expandedImage");
    var captionDescription = document.getElementById("captionDescription");
    var captionTime = document.getElementById("captionTime");
    container.style.display = "block";
    expandedImage.src = image.src;
    captionDescription.innerHTML = image.alt.replace("+", " ");
    captionTime.innerHTML = image.title.replace("+", " ");

    var close = document.getElementsByClassName("closeButton")[0];
    close.onclick = function() {
        container.style.display = 'none';
    }
}
/*
function slides(number) {
    var slide = 1;
    changeSlide(number);
}

function changeSlide(number) {
    slideFocus(slide += number);
}

function currentSlide(number) {
    slideFocus(slide = number);
}

function slideFocus(slideNumber) {
    var i;
    var slides = document.getElementsByClassName("galleryContainer");
    var dotSlides = document.getElementsByClassName("previews");
    var captionText = document.getElementById("caption");

    if (slideNumber > slides.length) {
        slide = 1;
    }
    if (slideNumber < 1) {
        slide = slides.length;
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < slides.length; i++) {
        dotSlides[i].className = dotSlides[i].className.replace(" active", "");
    }
    previous = slide - 1;
    slides[previous].style.display = "block";
    dotSlides[previous].className += "active";
    captionText.innerHTML = dotSlides[previous].alt;
}
*/