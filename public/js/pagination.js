document.addEventListener("DOMContentLoaded", () => {
    // ===============================
    // GUARD: JIKA BUKAN HALAMAN TABEL
    // ===============================
    const tableBody = document.getElementById("tableBody");
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const pagination = document.getElementById("pagination");

    // ⛔ kalau salah satu tidak ada, STOP JS ini
    if (!tableBody || !rowsPerPageSelect || !pagination) {
        return;
    }

    // ===============================
    // KODE LAMA (TIDAK DIUBAH)
    // ===============================

    let currentPage = 1;

    window.paginate = function () {
        const visibleRows = Array.from(
            tableBody.querySelectorAll("tr:not(.filtered-out)"),
        );

        const rowsPerPage = parseInt(rowsPerPageSelect.value);
        const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;

        // hapus dummy lama
        tableBody.querySelectorAll(".empty-row").forEach((row) => row.remove());

        // hide semua row asli
        tableBody
            .querySelectorAll("tr")
            .forEach((row) => (row.style.display = "none"));

        // =====================
        // KALAU DATA KOSONG
        // =====================
        if (visibleRows.length === 0) {
            // hapus dummy lama
            tableBody.querySelectorAll(".empty-row").forEach((r) => r.remove());

            const tr = document.createElement("tr");
            tr.className = "empty-row";

            tr.innerHTML = `
        <td colspan="7" style="text-align:center;padding:25px;color:#888">
            Tidak ada data untuk filter ini
        </td>
    `;

            tableBody.appendChild(tr);

            renderPagination(1);
            return;
        }

        // =====================
        // DATA ADA
        // =====================
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        visibleRows
            .slice(start, end)
            .forEach((row) => (row.style.display = ""));

        renderPagination(totalPages);
    };

    function renderPagination(totalPages) {
        pagination.innerHTML = "";

        // prev
        const prev = document.createElement("button");
        prev.innerHTML = "‹";
        prev.disabled = currentPage === 1;

        prev.onclick = () => {
            currentPage--;
            paginate();
        };

        pagination.appendChild(prev);

        // pages
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.innerText = i;

            if (i === currentPage) {
                btn.classList.add("active");
            }

            btn.onclick = () => {
                currentPage = i;
                paginate();
            };

            pagination.appendChild(btn);
        }

        // next
        const next = document.createElement("button");
        next.innerHTML = "›";
        next.disabled = currentPage === totalPages;

        next.onclick = () => {
            currentPage++;
            paginate();
        };

        pagination.appendChild(next);
    }

    rowsPerPageSelect.addEventListener("change", () => {
        currentPage = 1;
        paginate();
    });

    paginate();
});
