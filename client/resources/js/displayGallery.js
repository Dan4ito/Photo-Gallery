var slide = 0;

function openImage(image, slideNumber) {
    var container = document.getElementById("polaroid");
    var expandedImage = document.getElementById("expandedImage");
    var captionDescription = document.getElementById("captionDescription");
    var captionTime = document.getElementById("captionTime");

    container.style.display = "block";
    expandedImage.src = image.src;
    captionDescription.innerHTML = image.title.replace("+", " ");
    captionTime.innerHTML = image.alt.replace("+", " ");

    slide = slideNumber;
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
    var slides = document.getElementsByClassName("images");
    slide += number
    slide %= slides.length

    openImage(slides[slide], slide)
}
