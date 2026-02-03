document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("filterToggle");
    const dropdown = document.getElementById("filterDropdown");
    const rows = document.querySelectorAll(".status-table tbody tr");

    // buka tutup dropdown
    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    });

    // klik item filter
    document.querySelectorAll(".filter-item").forEach((item) => {
        item.addEventListener("click", function () {
            const selectedStatus = this.dataset.value;
            // contoh: "menunggu"

            rows.forEach((row) => {
                const badge = row.querySelector(".badge-status");

                if (!badge) return;

                // cek apakah baris punya status yang dipilih
                if (badge.classList.contains(selectedStatus)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });

            dropdown.classList.remove("show");
        });
    });

    // klik di luar → dropdown nutup
    document.addEventListener("click", function () {
        dropdown.classList.remove("show");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const rowsSelect = document.getElementById("rowsSelect");
    const tableBody = document.getElementById("tableBody");

    // 🚨 JIKA ELEMEN TIDAK ADA → STOP SCRIPT INI
    if (!rowsSelect || !tableBody) return;

    const rows = tableBody.querySelectorAll("tr");

    function updateRows() {
        const limit = parseInt(rowsSelect.value);

        rows.forEach((row, index) => {
            row.style.display = index < limit ? "" : "none";
        });
    }

    updateRows();
    rowsSelect.addEventListener("change", updateRows);
});
