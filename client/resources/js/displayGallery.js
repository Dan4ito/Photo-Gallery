var slide = 1;

function expandImage(image, slideNumber) {
    event.preventDefault();
    var container = document.getElementById("polaroid");
    var expandedImage = document.getElementById("expandedImage");
    var captionDescription = document.getElementById("captionDescription");
    var captionTime = document.getElementById("captionTime");
    container.style.display = "block";
    expandedImage.src = image.src;
    captionDescription.innerHTML = image.title.replace("+", " ");
    captionTime.innerHTML = image.alt.replace("+", " ");

    slide = slideNumber;

    var close = document.getElementsByClassName("closeButton")[0];
    close.onclick = function() {
        container.style.display = 'none';
    }
}

function changeSlide(number) {
    console.log(number);
    slideFocus(slide += number);
}

function currentSlide(number) {
    slideFocus(slide = number);
}

function slideFocus(slideNumber) {
    console.log("funct");
    var i;
    var slides = document.getElementsByClassName("images");
    //   var dotSlides = document.getElementsByClassName("previewsImages");

    if (slideNumber > slides.length) {
        slide = 1;
    }
    if (slideNumber < 1) {
        slide = slides.length;
    }

    for (i = 0; i < slides.length; i++) {
        //        dotSlides[i].className = dotSlides[i].className.replace("Active", "");
    }
    previous = slide - 1;
    image = slides[previous];
    //dotSlides[previous].className += "Active";

    var container = document.getElementById("polaroid");
    var expandedImage = document.getElementById("expandedImage");
    var captionDescription = document.getElementById("captionDescription");
    var captionTime = document.getElementById("captionTime");
    container.style.display = "block";
    expandedImage.src = image.src;
    captionDescription.innerHTML = image.title.replace("+", " ");
    captionTime.innerHTML = image.alt.replace("+", " ");


}