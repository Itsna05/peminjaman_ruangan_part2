document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".gallery-slider .slide");
    const dots = document.querySelectorAll(".gallery-indicator .dot");

    if (!slides.length) return;

    let current = 0;

    function updateSlider() {
        slides.forEach((slide, i) => {
            slide.classList.remove("active", "prev", "next");

            if (i === current) {
                slide.classList.add("active");
            } else if (i === (current - 1 + slides.length) % slides.length) {
                slide.classList.add("prev");
            } else if (i === (current + 1) % slides.length) {
                slide.classList.add("next");
            }
        });

        dots.forEach((d) => d.classList.remove("active"));
        if (dots[current]) {
            dots[current].classList.add("active");
        }
    }

    updateSlider();

    setInterval(() => {
        current = (current + 1) % slides.length;
        updateSlider();
    }, 4000);
});
