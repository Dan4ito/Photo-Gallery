var slide = 1;
var MAX_SLIDES = 6;

function slidePreviews(slideNumber) {
    var dotSlides = document.getElementsByClassName("preview");
    var displayedImages = 0;

    for (i = 0; i < dotSlides.length; i++) {
        var firstImageToDisplay = slideNumber - MAX_SLIDES / 2;
        if (firstImageToDisplay < 0) {
            firstImageToDisplay = 0;
        }
        for (j = 0; j < firstImageToDisplay; j++) {
            dotSlides[j].style.display = "none";
        }

        var lastImageToDisplay = slideNumber - 1;
        if (firstImageToDisplay == 0) {
            lastImageToDisplay += MAX_SLIDES;
        } else {
            lastImageToDisplay += MAX_SLIDES / 2;
        }
        if (lastImageToDisplay > dotSlides.length) {
            lastImageToDisplay = dotSlides.length;
        }
        for (j = firstImageToDisplay; j < lastImageToDisplay; j++) {
            if (displayedImages < MAX_SLIDES) {
                dotSlides[j].style.display = "inline-block";
                displayedImages++;
            }
        }

        for (j = lastImageToDisplay; j < dotSlides.length; j++) {
            dotSlides[j].style.display = "none";
        }
    }
}

function openImage(image, slideNumber) {
    var container = document.getElementById("polaroid");
    var expandedImage = document.getElementById("expandedImage");
    var captionDescription = document.getElementById("captionDescription");
    var captionTime = document.getElementById("captionTime");

    container.style.display = "block";
    expandedImage.src = image.src;
    captionDescription.innerHTML = image.title.split("+").join(" ");
    captionTime.innerHTML = image.alt.split("+").join(" ");
    var slides = document.getElementsByClassName("images");
    if (slideNumber == slides.length / 2) {
        document.getElementsByClassName("next")[0].hidden = true;
    } else {
        document.getElementsByClassName("next")[0].hidden = false;
    }
    if (slideNumber == 1) {
        document.getElementsByClassName("prev")[0].hidden = true;
    } else {
        document.getElementsByClassName("prev")[0].hidden = false;
    }

    slide = slideNumber;

    slidePreviews(slide);
}

function expandImage(image, slideNumber) {
    openImage(image, slideNumber);

    var container = document.getElementById("polaroid");
    var close = document.getElementsByClassName("closeButton")[0];
    close.onclick = function() {
        container.style.display = 'none';
    }
}

function changeSlide(number) {
    slideFocus(slide += number);
}

function currentSlide(number) {
    slideFocus(slide = number);
}

function slideFocus(slideNumber) {
    var i;
    var slides = document.getElementsByClassName("images");
    var dotSlides = document.getElementsByClassName("preview");

    if (slideNumber > slides.length) {
        slide = 1;
    }
    if (slideNumber < 1) {
        slide = slides.length;
    }

    for (i = 0; i < dotSlides.length; i++) {
        dotSlides[i].className = dotSlides[i].className.replace(" lightbox", "");
        if (i > MAX_SLIDES) {
            dotSlides[i].style.display = "none";
        }
    }
    previous = slideNumber - 1;
    image = slides[previous];

    openImage(image, slide);

    dotSlides[previous].className += " lightbox";
}

function highlightImage(imageID) {
    var image = document.getElementsByClassName("images")[imageID];
    image.style.opacity = 1.0;
}

function normalizeImage(imageID) {
    var image = document.getElementsByClassName("images")[imageID];
    image.style.opacity = 0.8;
}