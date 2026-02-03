document.addEventListener('DOMContentLoaded', function () {

    // 1️⃣ Ambil semua tombol filter
    const filterItems = document.querySelectorAll('.filter-item');

    // 2️⃣ Ambil semua baris tabel
    const rows = document.querySelectorAll('#tableBody tr');

    // 3️⃣ Tombol Filter (judul)
    const filterButton = document.getElementById('filterToggle');

    // 4️⃣ Saat salah satu filter diklik
    filterItems.forEach(item => {
        item.addEventListener('click', function () {

            const filterValue = this.getAttribute('data-value');

            // 🔵 Ubah tulisan tombol filter
            filterButton.innerHTML = this.innerHTML + ' <span class="arrow">▾</span>';

            // 🔵 Hapus status aktif dari semua filter
            filterItems.forEach(btn => btn.classList.remove('active'));

            // 🔵 Tandai filter yang sedang dipilih
            this.classList.add('active');

            // 🔵 Filter baris tabel
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');

                if (filterValue === 'tampilkansemua') {
                    row.style.display = '';
                } else if (rowStatus === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

        });
    });

});
