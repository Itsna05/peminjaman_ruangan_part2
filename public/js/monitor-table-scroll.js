document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.querySelector(".table-wrapper");

    let scrollPos = 0;
    const speed = 0.4;

    function autoScroll() {
        scrollPos += speed;
        wrapper.scrollTop = scrollPos;

        if (wrapper.scrollTop + wrapper.clientHeight >= wrapper.scrollHeight) {
            scrollPos = 0;
        }
    }

    setInterval(autoScroll, 30);
});
