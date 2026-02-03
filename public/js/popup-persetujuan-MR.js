document.addEventListener("DOMContentLoaded", function () {

    // =====================================================
    // EARLY EXIT → BUKAN HALAMAN PEMINJAMAN
    // =====================================================
    const detailModal = document.getElementById("detailModal");
    const confirmModal = document.getElementById("confirmModal");

    if (!detailModal || !confirmModal) {
        return;
    }

    // =====================================================
    // ELEMEN DASAR
    // =====================================================
    const openButtons = document.querySelectorAll(".btn-open-modal");
    const closeButton = detailModal.querySelector(".modal-close");

    let currentRow = null;
    let actionType = null;

    // =====================================================
    // OPEN MODAL DETAIL
    // =====================================================
    if (openButtons.length) {
        openButtons.forEach(btn => {
            btn.addEventListener("click", function () {
                currentRow = this.closest("tr");
                detailModal.style.display = "flex";
            });
        });
    }

    // =====================================================
    // CLOSE MODAL DETAIL (X)
    // =====================================================
    if (closeButton) {
        closeButton.addEventListener("click", function () {
            detailModal.style.display = "none";
            currentRow = null;
        });
    }

    // Klik background modal detail
    detailModal.addEventListener("click", function (e) {
        if (e.target === detailModal) {
            detailModal.style.display = "none";
            currentRow = null;
        }
    });

    // =====================================================
    // MODAL KONFIRMASI
    // =====================================================
    const btnSetujui = document.querySelector(".btn-approve");
    const btnTolak = document.querySelector(".btn-reject");
    const btnConfirmYes = document.querySelector(".btn-confirm-yes");
    const btnConfirmNo = document.querySelector(".btn-confirm-no");

    // Klik SETUJUI
    if (btnSetujui) {
        btnSetujui.addEventListener("click", function () {
            actionType = "setujui";
            confirmModal.style.display = "flex";
        });
    }

    // Klik TOLAK
    if (btnTolak) {
        btnTolak.addEventListener("click", function () {
            actionType = "tolak";
            confirmModal.style.display = "flex";
        });
    }

    // Klik BATAL
    if (btnConfirmNo) {
        btnConfirmNo.addEventListener("click", function () {
            confirmModal.style.display = "none";
            actionType = null;
        });
    }

    // Klik BENAR (CONFIRM)
    if (btnConfirmYes) {
        btnConfirmYes.addEventListener("click", function () {

            if (!currentRow || !actionType) return;

            const statusBadge = currentRow.querySelector(".badge-status");
            const actionButton = currentRow.querySelector(".btn-edit");

            if (statusBadge) {
                if (actionType === "setujui") {
                    statusBadge.textContent = "Disetujui";
                    statusBadge.className = "badge-status disetujui";
                }

                if (actionType === "tolak") {
                    statusBadge.textContent = "Ditolak";
                    statusBadge.className = "badge-status ditolak";
                }
            }

            if (actionButton) {
                actionButton.classList.add("disabled");
                actionButton.setAttribute("disabled", true);
                actionButton.classList.remove("btn-open-modal");
            }

            confirmModal.style.display = "none";
            detailModal.style.display = "none";

            currentRow = null;
            actionType = null;
        });
    }

    // Klik background modal konfirmasi
    confirmModal.addEventListener("click", function (e) {
        if (e.target === confirmModal) {
            confirmModal.style.display = "none";
            actionType = null;
        }
    });

});
