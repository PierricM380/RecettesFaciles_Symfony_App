// animJS animation
AOS.init({
	easing: 'linear',
	duration: 1500,
})

// Scroll Event Navigation bar
const nav = document.querySelector("nav");

window.addEventListener("scroll", () => {
  if (window.scrollY < 300) {
    nav.style.top = "0";
  } else {
    nav.style.top = "-140px";
  }
});