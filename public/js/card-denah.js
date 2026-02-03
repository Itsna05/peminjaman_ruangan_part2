document.addEventListener("DOMContentLoaded", () => {

  const slider = document.querySelector('.ruangan-slider');
  const track = document.querySelector('.ruangan-track');
  if (!slider || !track) return;

  /* =========================================
     HANYA FUNGSI SPOTLIGHT CARD TENGAH
     (tanpa clone, tanpa infinite)
     ========================================= */

  function updateActiveCard() {
    const sliderRect = slider.getBoundingClientRect();
    const sliderCenter = sliderRect.left + sliderRect.width / 2;

    document.querySelectorAll('.detail-card').forEach(card => {
      const cardRect = card.getBoundingClientRect();
      const cardCenter = cardRect.left + cardRect.width / 2;
      const distance = Math.abs(sliderCenter - cardCenter);

      card.classList.toggle(
        'is-active',
        distance < cardRect.width * 0.45
      );
    });
  }

  slider.addEventListener('scroll', () => {
    requestAnimationFrame(updateActiveCard);
  });

  /* Lindungi tombol carousel supaya tidak ikut geser slider */
  document.querySelectorAll('.foto-carousel button').forEach(btn => {
    btn.addEventListener('mousedown', e => e.stopPropagation());
    btn.addEventListener('touchstart', e => e.stopPropagation());
    btn.addEventListener('click', e => e.stopPropagation());
  });

  updateActiveCard();
});