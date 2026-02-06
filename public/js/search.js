document.addEventListener('input', function (e) {
    if (!e.target.matches('.search-box input')) return;

    const keyword = e.target.value.toLowerCase().trim();

    // 🔥 AMBIL BLOK TERDEKAT (CARD / TABLE CONTAINER)
    const block =
        e.target.closest('.table-wrapper') ||
        e.target.closest('.table-container') ||
        e.target.closest('.card-wrapper') ||
        e.target.closest('section');

    if (!block) return;

    // =====================
    // SEARCH TABEL (KHUSUS BLOK INI)
    // =====================
    const table = block.querySelector('.status-table');
    if (table) {
        table.querySelectorAll('tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display =
                keyword === '' || text.includes(keyword) ? '' : 'none';
        });
    }

    // =====================
    // SEARCH CARD (JIKA ADA)
    // =====================
    const cards = block.querySelectorAll('.room-card, .search-item');
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display =
            keyword === '' || text.includes(keyword) ? '' : 'none';
    });
});
