const slides = document.querySelectorAll('.slide');
const dots   = document.querySelectorAll('.dot');

let current = 0;

function updateSlider() {
    slides.forEach((slide, i) => {
        slide.classList.remove('active', 'prev', 'next');

        if (i === current) {
            slide.classList.add('active');
        } 
        else if (i === (current - 1 + slides.length) % slides.length) {
            slide.classList.add('prev');
        } 
        else if (i === (current + 1) % slides.length) {
            slide.classList.add('next');
        }
    });

    dots.forEach(d => d.classList.remove('active'));
    dots[current % dots.length].classList.add('active');
}

updateSlider();

setInterval(() => {
    current = (current + 1) % slides.length;
    updateSlider();
}, 4000); // ganti tiap 4 detik
