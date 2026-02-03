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
