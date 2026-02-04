document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // SEARCH BIDANG PEGAWAI
    // =========================
    const searchBidang = document.getElementById('searchBidang');
    const bidangRows  = document.querySelectorAll('.user-bidang-section tbody tr');

    if (searchBidang) {
        searchBidang.addEventListener('keyup', function () {
            const keyword = this.value.toLowerCase();

            bidangRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    }

    // =========================
    // SEARCH USER
    // =========================
    const searchUser = document.getElementById('searchUser');
    const userRows  = document.querySelectorAll('.user-section tbody tr');

    if (searchUser) {
        searchUser.addEventListener('keyup', function () {
            const keyword = this.value.toLowerCase();

            userRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    }

    // =========================
    // EDIT BIDANG
    // =========================
    document.querySelectorAll('.btn-edit-bidang').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('editIdBidang').value = this.dataset.id;
            document.getElementById('editBidang').value = this.dataset.bidang;
            document.getElementById('editSubBidang').value = this.dataset.sub;
        });
    });

    // =========================
    // EDIT USER  🔥 INI YANG PENTING
    // =========================
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('editUserId').value = this.dataset.id;
            document.getElementById('editUserNama').value = this.dataset.nama;
            document.getElementById('editUserUsername').value = this.dataset.username;
            document.getElementById('editUserRole').value = this.dataset.role;
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {

    function initPagination(wrapperSelector) {
        const wrapper = document.querySelector(wrapperSelector);
        if (!wrapper) return;

        const tableBody = wrapper.querySelector('tbody');
        const rowsPerPageSelect = wrapper.querySelector('#rowsPerPage');
        const pagination = wrapper.querySelector('#pagination');

        if (!tableBody || !rowsPerPageSelect || !pagination) return;

        let currentPage = 1;

        function paginate() {
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            const rowsPerPage = parseInt(rowsPerPageSelect.value);
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            rows.forEach(row => row.style.display = 'none');

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.slice(start, end).forEach(row => {
                row.style.display = '';
            });

            renderPagination(totalPages);
        }

        function renderPagination(totalPages) {
            pagination.innerHTML = '';

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
    }

    // 🔥 PAKE UNTUK KEDUANYA
    initPagination('.user-bidang-section');
    initPagination('.user-section');

});
