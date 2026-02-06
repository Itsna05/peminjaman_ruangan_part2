document.addEventListener('input', function (e) {
    if (e.target.id !== 'searchInputPersetujuan') return;

    const keyword = e.target.value.toLowerCase().trim();

    // 🔥 TARGET YANG BENAR
    const table = document.querySelector('.approval-table');
    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display =
            keyword === '' || text.includes(keyword)
                ? ''
                : 'none';
    });
});
