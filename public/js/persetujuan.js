console.log('persetujuan.js aktif');

document.addEventListener('DOMContentLoaded', function () {

    let idPeminjaman = null;

    // 1️⃣ Tangkap ID saat klik tombol edit (✏️)
    document.querySelectorAll('.btn-open-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            idPeminjaman = this.dataset.id;
            console.log('ID peminjaman dipilih:', idPeminjaman);
        });
    });

    // 2️⃣ Tombol SETUJUI kirim ke Laravel
    const btnApprove = document.querySelector('.btn-approve');

    if (btnApprove) {
        btnApprove.addEventListener('click', function () {

            if (!idPeminjaman) {
                alert('ID peminjaman tidak ditemukan');
                return;
            }

            console.log('Mengirim persetujuan untuk ID:', idPeminjaman);

            fetch(`/superadmin/peminjaman/${idPeminjaman}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                }
            })
            .then(res => res.json())
            .then(data => {
                alert('Peminjaman berhasil disetujui');
                location.reload();
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan');
            });

        });
    }

});
