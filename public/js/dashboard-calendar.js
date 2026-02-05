document.addEventListener('DOMContentLoaded', function () {

    document.body.addEventListener('click', function (e) {
        const eventBox = e.target.closest('.event-clickable');
        if (!eventBox) return;

        const id = eventBox.dataset.id;

        fetch(`/petugas/transaksi/${id}`)
            .then(res => {
                if (!res.ok) throw new Error('Data tidak valid');
                return res.json();
            })
            .then(data => {

                const statusLabel = data.status_peminjaman === 'disetujui'
                    ? 'Disetujui'
                    : 'Menunggu Persetujuan';

                const statusClass = data.status_peminjaman === 'disetujui'
                    ? 'text-success'
                    : 'text-warning';

                document.getElementById('modalDetailContent').innerHTML = `
                    <p><strong>Nama Acara</strong><br>${data.acara}</p>

                    <p><strong>Status</strong><br>
                        <span class="${statusClass} fw-bold">
                            ${statusLabel}
                        </span>
                    </p>

                    <p><strong>Jumlah Peserta</strong><br>
                        ${data.jumlah_peserta} orang
                    </p>

                    <p><strong>Waktu</strong><br>
                        ${data.waktu_mulai.substring(11,16)} -
                        ${data.waktu_selesai.substring(11,16)}
                    </p>

                    <p><strong>Bidang</strong><br>
                        ${data.bidang?.bidang ?? '-'}
                    </p>

                    <p><strong>Sub Bidang</strong><br>
                        ${data.bidang?.sub_bidang ?? '-'}
                    </p>

                    <p><strong>Ruangan</strong><br>
                        ${data.ruangan?.nama_ruangan ?? '-'}
                    </p>

                    <p><strong>Catatan</strong><br>
                        ${data.catatan ?? '-'}
                    </p>
                `;

                new bootstrap.Modal(
                    document.getElementById('modalDetailPeminjaman')
                ).show();
            })
            .catch(() => {
                console.warn('Event tidak valid / dibatalkan');
            });

    });

});
