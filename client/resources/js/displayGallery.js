var allSlides = Array.from(document.getElementsByClassName("imageItem"));
var slide = 0;
var reversed = false;


function openImage(image, slideNumber) {
    var container = document.getElementById("polaroid");
    var expandedImage = document.getElementById("expandedImage");
    var captionDescription = document.getElementById("captionDescription");
    var captionTime = document.getElementById("captionTime");
    var tagsParagraph = document.getElementById("tags");

    container.style.display = "block";
    expandedImage.src = image.src;
    captionDescription.innerHTML = image.title.replace("+", " ");

    let altSplit = image.alt.split(';')
    captionTime.innerHTML = altSplit[0]

    let tags = ""
    if (altSplit.length > 1 && altSplit[1].length > 0) {
        tags = altSplit[1].split(',').map(tag => "#" + tag).join(' ');
    }
    tagsParagraph.innerHTML = tags

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
    slide += number + slides.length
    slide %= slides.length

    openImage(slides[slide], slide)
}

function sortImages() {
    let slides = document.getElementsByClassName("imageItem");
    let arr = Array.from(slides)

    // perform sort
    if (reversed) {       
        arr.sort(function(a, b) {
            let ind = a.children.length - 1
            return Date.parse(b.children[ind].alt.split(';')[0]) - Date.parse(a.children[ind].alt.split(';')[0]);    
        });
    }
    else {   
        arr.sort(function(a, b) {
            let ind = a.children.length - 1
            return Date.parse(a.children[ind].alt.split(';')[0]) - Date.parse(b.children[ind].alt.split(';')[0]);    
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

function filterByTag() {
    tag = document.getElementById('filterDescription').value

    newSlides = allSlides.filter(img => {
        let ind = img.children.length - 1
        let split = img.children[ind].alt.split(';')
        if (split.length < 2) {
            return false
        }
        
        return split[1].includes(tag)
    })

    let output = "";
    newSlides.forEach(x => {
        output += x.outerHTML;
    })

    // append output to div 'myDiv'
    document.getElementById('imagesContainer').innerHTML = output;
    reversed = false;
    document.getElementById('sortBtnId').innerHTML = "Sort by time asc";
}
