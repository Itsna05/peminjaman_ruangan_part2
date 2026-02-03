document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById("modalDetailPeminjaman");
    const modal = new bootstrap.Modal(modalElement);

    // 🔥 PAKSA BERSIH SAAT MODAL DITUTUP
    modalElement.addEventListener("hidden.bs.modal", function () {
        document.body.classList.remove("modal-open");

        document.querySelectorAll(".modal-backdrop").forEach((el) => {
            el.remove();
        });
    });

    document.querySelectorAll(".event-clickable").forEach((item) => {
        item.addEventListener("click", function () {
            const id = this.dataset.id;

            fetch(`/petugas/peminjaman/${id}`)
                .then((res) => res.json())
                .then((data) => {
                    document.getElementById("modalDetailContent").innerHTML = `
                        <p><b>Nama Acara</b><br>${data.acara}</p>

                        <p><b>Waktu</b><br>
                            ${data.waktu_mulai} - ${data.waktu_selesai}
                        </p>

                        <p><b>Ruangan</b><br>${data.ruangan}</p>

                        <p><b>Jumlah Peserta</b><br>
                            ${data.jumlah_peserta} orang
                        </p>

                        <p><b>Bidang</b><br>
                            ${data.bidang}
                        </p>

                        <p><b>Sub Bidang</b><br>
                            ${data.sub_bidang}
                        </p>

                        <p><b>No WhatsApp</b><br>${data.no_wa}</p>

                        <p><b>Catatan</b><br>${data.catatan?.trim() ? data.catatan : "-"}</p>

                    `;

                    modal.show();
                });
        });
    });
});
