document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // EARLY EXIT → BUKAN HALAMAN MANAJEMEN USER
    // =====================================================
    if (!document.querySelector('.user-table')) {
        return;
    }

    const filterBtn = document.querySelector('.user-filter-btn');
    const filterDropdown = document.querySelector('.user-filter-dropdown');
    const filterItems = document.querySelectorAll('.filter-item');
    const rows = document.querySelectorAll('.user-table tbody tr');

    // =====================================================
    // GUARD PENTING
    // =====================================================
    if (!filterBtn || !filterDropdown || !rows.length) {
        return;
    }

    /* =========================
       TOGGLE DROPDOWN
    ========================= */
    filterBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        filterDropdown.classList.toggle('d-none');
    });

    document.addEventListener('click', function () {
        filterDropdown.classList.add('d-none');
    });

    /* =========================
       FILTER TABLE
    ========================= */
    filterItems.forEach(item => {
        item.addEventListener('click', function () {
            const value = this.dataset.value || '';

            rows.forEach(row => {
                const role = row.dataset.role || '';

                if (!value || role === value) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            filterDropdown.classList.add('d-none');
        });
    });

});
