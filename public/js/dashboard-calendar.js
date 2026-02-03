document.addEventListener('DOMContentLoaded', function () {

    document.body.addEventListener('click', function (e) {
        const eventBox = e.target.closest('.event-clickable');
        if (!eventBox) return;

        const id = eventBox.dataset.id;
        console.log('CLICKED ID:', id);

        fetch(`/petugas/transaksi/${id}`)
            .then(res => res.json())
            .then(data => {

                document.getElementById('modalDetailContent').innerHTML = `
                    <p><strong>Nama Acara</strong><br>${data.acara}</p>
                    <p><strong>Jumlah Peserta</strong><br>${data.jumlah_peserta} orang</p>
                    <p><strong>Waktu</strong><br>
                        ${data.waktu_mulai.substring(11,16)} -
                        ${data.waktu_selesai.substring(11,16)}
                    </p>
                    <p><strong>Bidang</strong><br>${data.bidang?.bidang ?? '-'}</p>
                    <p><strong>Sub Bidang</strong><br>${data.bidang?.sub_bidang ?? '-'}</p>
                    <p><strong>Ruangan</strong><br>${data.ruangan?.nama_ruangan ?? '-'}</p>
                    <p><strong>Catatan</strong><br>${data.catatan ?? '-'}</p>
                `;

                const modal = new bootstrap.Modal(
                    document.getElementById('modalDetailPeminjaman')
                );
                modal.show();
            })
            .catch(err => {
                console.error('ERROR FETCH:', err);
            });
    });

});
