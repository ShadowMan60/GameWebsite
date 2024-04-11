let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

let searchInput = document.getElementById('searchInput');
let listItems = document.querySelectorAll('#resultsList li');
let isSearchActive = false;

searchInput.addEventListener('focus', function () {
    isSearchActive = true;
    filterListItems();
});

searchInput.addEventListener('input', function () {
    isSearchActive = true;
    filterListItems();
});

searchInput.addEventListener('blur', function () {
    isSearchActive = false;
    filterListItems();
});

function filterListItems() {
    let searchValue = searchInput.value.toLowerCase();

    listItems.forEach(function (item) {
        (function (item) { // Encapsulation using closure
            let text = item.textContent.toLowerCase();
            if (!isSearchActive || text.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        })(item);
    });
}


function Dropdown() {
    var dropdown = document.getElementById("myDropdown");
    dropdown.classList.toggle("show");

    var arrow = document.querySelector('.dropbtn .arrow');
    arrow.textContent = dropdown.classList.contains("show") ? "\u25B2" : "\u25BC"; // Unicode for up and down arrows
}

window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
                var arrow = document.querySelector('.dropbtn .arrow');
                arrow.textContent = "\u25BC"; // Unicode for down arrow
            }
        }
    }
}