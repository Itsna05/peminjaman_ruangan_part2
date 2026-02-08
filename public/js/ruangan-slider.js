document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("ruanganSlider");
    const cards = slider.querySelectorAll(".detail-card");

    if (!slider || cards.length === 0) return;

    function updateActiveCard() {
        const sliderRect = slider.getBoundingClientRect();
        const centerX = sliderRect.left + sliderRect.width / 2;

        let closestCard = null;
        let minDistance = Infinity;

        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const cardCenter = rect.left + rect.width / 2;
            const distance = Math.abs(centerX - cardCenter);

            if (distance < minDistance) {
                minDistance = distance;
                closestCard = card;
            }
        });

        cards.forEach(card => card.classList.remove("is-active"));
        if (closestCard) closestCard.classList.add("is-active");
    }

    // Initial
    updateActiveCard();

    // On scroll
    slider.addEventListener("scroll", () => {
        window.requestAnimationFrame(updateActiveCard);
    });
});
