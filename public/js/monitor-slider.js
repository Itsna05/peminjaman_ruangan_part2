document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("todaySlider");
    if (!slider) return;

    // kalau cuma 1 item, gandakan sampai penuh
    const original = slider.innerHTML;

    // ulangi sampai lebar cukup
    while (slider.scrollWidth < slider.clientWidth * 2) {
        slider.innerHTML += original;
    }
});
