document.querySelectorAll('.today-slider, .room-slider').forEach(slider => {
    let scrollAmount = 0;

    setInterval(() => {
        scrollAmount += 1;
        slider.scrollLeft = scrollAmount;

        if (scrollAmount >= slider.scrollWidth - slider.clientWidth) {
            scrollAmount = 0;
        }
    }, 30);
});
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('todaySlider');
    if (!slider) return;

    // clone isi slider biar looping
    slider.innerHTML += slider.innerHTML;
});