document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('tableBody');
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const pagination = document.getElementById('pagination');

    let currentPage = 1;

    function paginate() {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const rowsPerPage = parseInt(rowsPerPageSelect.value);
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        // sembunyikan semua baris
        rows.forEach(row => row.style.display = 'none');

        // hitung range baris
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        pagination.innerHTML = '';

        // tombol sebelumnya
        const prev = document.createElement('button');
        prev.innerHTML = '‹';
        prev.disabled = currentPage === 1;
        prev.onclick = () => {
            currentPage--;
            paginate();
        };
        pagination.appendChild(prev);

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.innerText = i;

            if (i === currentPage) {
                btn.classList.add('active');
            }

            btn.onclick = () => {
                currentPage = i;
                paginate();
            };

            pagination.appendChild(btn);
        }

        // tombol berikutnya
        const next = document.createElement('button');
        next.innerHTML = '›';
        next.disabled = currentPage === totalPages;
        next.onclick = () => {
            currentPage++;
            paginate();
        };
        pagination.appendChild(next);
    }

    rowsPerPageSelect.addEventListener('change', () => {
        currentPage = 1;
        paginate();
    });

    paginate();
});
