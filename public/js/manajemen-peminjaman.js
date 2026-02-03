document.addEventListener("DOMContentLoaded", function () {

    // =====================================================
    // EARLY EXIT → BUKAN HALAMAN MANAJEMEN PEMINJAMAN
    // =====================================================
    const modal = document.getElementById("detailModal");
    const modalContent = document.getElementById("modalDetailContent");

    if (!modal || !modalContent) {
        return;
    }

    let currentPeminjamanId = null;
    let confirmAction = null;

    // =====================================================
    // HELPER MODAL
    // =====================================================
    function openModal() {
        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closeModal() {
        modal.classList.remove("active");
        document.body.style.overflow = "";
        currentPeminjamanId = null;
    }

    // =====================================================
    // CLOSE MODAL
    // =====================================================
    const closeBtn = modal.querySelector(".modal-close");
    if (closeBtn) {
        closeBtn.addEventListener("click", closeModal);
    }

    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // =====================================================
    // OPEN MODAL & LOAD DATA
    // =====================================================
    document.querySelectorAll(".btn-open-modal").forEach((btn) => {
        btn.addEventListener("click", function () {

            currentPeminjamanId = this.dataset.id;
            if (!currentPeminjamanId) return;

            modalContent.innerHTML = "Loading...";
            openModal();

            fetch(`/superadmin/peminjaman/${currentPeminjamanId}`)
                .then(res => res.json())
                .then(data => {
                    modalContent.innerHTML = `
                        <div class="modal-row">
                            <label>Nama Acara</label><span>:</span>
                            <input type="text" value="${data.acara ?? '-'}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Jumlah Peserta</label><span>:</span>
                            <input type="text" value="${data.jumlah_peserta ?? '-'} orang" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Tanggal</label><span>:</span>
                            <input type="text" value="${data.tanggal ?? '-'}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Waktu</label><span>:</span>
                            <input type="text" value="${data.waktu_mulai ?? '-'} - ${data.waktu_selesai ?? '-'}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Bidang</label><span>:</span>
                            <input type="text" value="${data.bidang ?? '-'}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Sub Bidang</label><span>:</span>
                            <input type="text" value="${data.sub_bidang ?? '-'}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>Ruangan</label><span>:</span>
                            <input type="text" value="${data.ruangan ?? '-'}" readonly>
                        </div>

                        <div class="modal-row">
                            <label>No WhatsApp</label><span>:</span>
                            <input type="text" value="${data.no_wa ?? '-'}" readonly>
                        </div>

                        <div class="modal-row textarea">
                            <label>Catatan</label><span>:</span>
                            <textarea readonly>${data.catatan ?? '-'}</textarea>
                        </div>
                    `;
                })
                .catch(() => {
                    modalContent.innerHTML = "Gagal memuat data.";
                });
        });
    });

    // =====================================================
    // APPROVE / REJECT
    // =====================================================
    const btnApprove = document.querySelector(".btn-approve");
    const btnReject = document.querySelector(".btn-reject");

    if (btnApprove) {
        btnApprove.addEventListener("click", function () {
            openConfirm("approve");
        });
    }

    if (btnReject) {
        btnReject.addEventListener("click", function () {
            openConfirm("reject");
        });
    }

    // =====================================================
    // MODAL KONFIRMASI
    // =====================================================
    const confirmModal = document.getElementById("confirmModal");
    if (!confirmModal) return;

    function openConfirm(action) {
        confirmAction = action;
        confirmModal.classList.add("active");
    }

    const btnConfirmNo = confirmModal.querySelector(".btn-confirm-no");
    const btnConfirmYes = confirmModal.querySelector(".btn-confirm-yes");

    if (btnConfirmNo) {
        btnConfirmNo.addEventListener("click", function () {
            confirmModal.classList.remove("active");
            confirmAction = null;
        });
    }

    if (btnConfirmYes) {
        btnConfirmYes.addEventListener("click", function () {

            if (!currentPeminjamanId || !confirmAction) return;

            fetch(`/superadmin/peminjaman/${currentPeminjamanId}/${confirmAction}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content")
                }
            }).then(() => location.reload());
        });
    }

});
