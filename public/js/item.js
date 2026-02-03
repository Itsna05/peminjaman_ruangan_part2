document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // FILTER STATUS (LEGACY / OPTIONAL)
    // =========================

    const filterToggle  = document.getElementById("filterToggle");
    const filterDropdown = document.getElementById("filterDropdown");

    // ❗ Jika elemen TIDAK ADA di halaman ini → STOP BAGIAN INI
    if (filterToggle && filterDropdown) {

        const rows = document.querySelectorAll(".status-table tbody tr");

        filterToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            filterDropdown.classList.toggle("show");
        });

        document.querySelectorAll(".filter-item").forEach((item) => {
            item.addEventListener("click", function () {
                const selectedStatus = this.dataset.value;

                rows.forEach((row) => {
                    const badge = row.querySelector(".badge-status");
                    if (!badge) return;

                    if (!selectedStatus || badge.classList.contains(selectedStatus)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });

                filterDropdown.classList.remove("show");
            });
        });

        document.addEventListener("click", function () {
            filterDropdown.classList.remove("show");
        });
    }

    // =========================
    // JUMLAH BARIS (ROWS PER PAGE)
    // =========================

    const rowsSelect = document.getElementById("rowsPerPage");
    const tableBody = document.getElementById("tableBody");

    // ❗ Jika bukan halaman yang punya tabel → STOP
    if (!rowsSelect || !tableBody) return;

    const rows = Array.from(tableBody.querySelectorAll("tr"));

    function updateRows() {
        const limit = parseInt(rowsSelect.value, 10);

        rows.forEach((row, index) => {
            row.style.display = index < limit ? "" : "none";
        });
    }

    updateRows();
    rowsSelect.addEventListener("change", updateRows);

});
