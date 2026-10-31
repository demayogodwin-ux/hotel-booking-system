const menuOpenButton =  document.querySelector("#menu-open-button");
const menuCloseButton =  document.querySelector("#menu-close-button");

menuOpenButton.addEventListener("click", () => {
    // Toggle mobile menu visibility
    document.body.classList.toggle("show-mobile-menu");
});

// Close new menu when the close button is clicked
menuCloseButton.addEventListener("click", () => menuOpenButton.click() );
// Give the navbar a background once the page is scrolled
const header = document.querySelector("header");

window.addEventListener("scroll", () => {
    header.classList.toggle("scrolled", window.scrollY > 50);
});

// Close the mobile menu after a link is clicked
document.querySelectorAll(".nav-menu .nav-links").forEach(link => {
    link.addEventListener("click", () => document.body.classList.remove("show-mobile-menu"));
});
