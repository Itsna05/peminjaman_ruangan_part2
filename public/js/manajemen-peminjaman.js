document.addEventListener("DOMContentLoaded", function () {
    let currentPeminjamanId = null;

    const modal = document.getElementById("detailModal");
    const modalContent = document.getElementById("modalDetailContent");

    function openModal() {
        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closeModal() {
        modal.classList.remove("active");
        document.body.style.overflow = "";
    }

    document
        .querySelector(".modal-close")
        .addEventListener("click", closeModal);

    // ====== OPEN MODAL & LOAD DATA ======
    document.querySelectorAll(".btn-open-modal").forEach((btn) => {
        btn.addEventListener("click", function () {
            currentPeminjamanId = this.dataset.id;
            modalContent.innerHTML = "Loading...";
            openModal();

            fetch(`/superadmin/peminjaman/${currentPeminjamanId}`)
                .then((res) => res.json())
                .then((data) => {
                    modalContent.innerHTML = `
                        <div class="modal-row">
                            <label>Nama Acara</label><span>:</span>
                            <input type="text" value="${data.acara}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Jumlah Peserta</label><span>:</span>
                            <input type="text" value="${data.jumlah_peserta} orang" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Tanggal</label><span>:</span>
                            <input type="text" value="${data.tanggal}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Waktu</label><span>:</span>
                            <input type="text" value="${data.waktu_mulai} - ${data.waktu_selesai}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Bidang</label><span>:</span>
                            <input type="text" value="${data.bidang}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Sub Bidang</label><span>:</span>
                            <input type="text" value="${data.sub_bidang}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Ruangan</label><span>:</span>
                            <input type="text" value="${data.ruangan}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>No WhatsApp</label><span>:</span>
                            <input type="text" value="${data.no_wa}" readonly>
                        </div>

                        <div class="modal-row textarea">
                            <label>Catatan</label><span>:</span>
                            <textarea readonly>${data.catatan}</textarea>
                        </div>
                    `;
                });
        });
    });

    // =========================
    // SETUJUI
    // =========================
    document
        .querySelector(".btn-approve")
        .addEventListener("click", function () {
            openConfirm("approve");
        });

    // =========================
    // TOLAK
    // =========================
    document
        .querySelector(".btn-reject")
        .addEventListener("click", function () {
            openConfirm("reject");
        });

    // =========================
    // MODAL KONFIRMASI
    // =========================
    const confirmModal = document.getElementById("confirmModal");
    let confirmAction = null;

    function openConfirm(action) {
        confirmAction = action;
        confirmModal.classList.add("active");
    }

    document.querySelector(".btn-confirm-no").addEventListener("click", () => {
        confirmModal.classList.remove("active");
    });

    document.querySelector(".btn-confirm-yes").addEventListener("click", () => {
        fetch(
            `/superadmin/peminjaman/${currentPeminjamanId}/${confirmAction}`,
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            },
        ).then(() => location.reload());
    });
});
