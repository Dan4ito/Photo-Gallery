var allSlides = document.getElementsByClassName("imageItem");
var slide = 0;
var reversed = false;


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
    let slides = document.getElementsByClassName("images");
    console.log(slides)
    slide += number
    slide %= slides.length

    openImage(slides[slide], slide)
}

function sortImages() {
    let slides = document.getElementsByClassName("imageItem");
    let arr = Array.from(slides)

    // perform sort
    if (reversed) {       
        arr.sort(function(a, b) {
            return Date.parse(b.children[1].alt) - Date.parse(a.children[1].alt);    
        });
    }
    else {   
        arr.sort(function(a, b) {
            return Date.parse(a.children[1].alt) - Date.parse(b.children[1].alt);    
        });
    }

    // join the array back into HTML
    let output = "";
    arr.forEach(x => {
        output += x.outerHTML;
    })

    // append output to div 'myDiv'
    document.getElementById('imagesContainer').innerHTML = output;

    if (reversed) {
        reversed = false;
        document.getElementById('sortBtnId').innerHTML = "Sort by time asc";
    }
    else {
        reversed = true;
        document.getElementById('sortBtnId').innerHTML = "Sort by time desc";
    }
}
