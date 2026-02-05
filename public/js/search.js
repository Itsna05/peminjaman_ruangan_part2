document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchInput');
    const icon = document.querySelector('.search-box i');

    function doSearch() {
        const keyword = input.value.toLowerCase().trim();

        // AMBIL SEMUA BARIS TABEL
        const rows = document.querySelectorAll('.status-table tbody tr');

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase();

            // kalau keyword kosong → tampil semua
            if (keyword === '') {
                row.style.display = '';
                return;
            }

            // filter per baris
            if (rowText.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    input.addEventListener('input', doSearch);
    icon.addEventListener('click', doSearch);
});
