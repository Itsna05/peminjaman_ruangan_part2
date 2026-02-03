document.addEventListener("DOMContentLoaded", function () {

    // 1. Ambil elemen modal
    const modal = document.getElementById("detailModal");

    // 2. Ambil semua tombol edit (pensil)
    const openButtons = document.querySelectorAll(".btn-open-modal");

    // 3. Tombol close (X)
    const closeButton = modal.querySelector(".modal-close");

    // 4. Saat tombol edit diklik → tampilkan modal
    let currentRow = null;
    let actionType = null;

    openButtons.forEach(function (btn) {
        btn.addEventListener("click", function () {
            currentRow = this.closest("tr"); // ⬅️ SIMPAN BARIS
            modal.style.display = "flex";
        });
    });

    // 5. Saat tombol X diklik → tutup modal
    closeButton.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // 6. Klik area gelap → tutup modal
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

        // ===== MODAL KONFIRMASI =====
    const detailModal = document.getElementById("detailModal");
    const confirmModal = document.getElementById("confirmModal");

    const btnSetujui = document.querySelector(".btn-approve");
    const btnTolak = document.querySelector(".btn-reject");
    const btnConfirmYes = document.querySelector(".btn-confirm-yes");
    const btnConfirmNo = document.querySelector(".btn-confirm-no");

    // Klik SETUJUI → buka popup konfirmasi
    btnSetujui.addEventListener("click", function () {
        actionType = "setujui";
        confirmModal.style.display = "flex";
    });

    // Klik TOLAK
    btnTolak.addEventListener("click", function () {
        actionType = "tolak";
        confirmModal.style.display = "flex";
    });

    // Klik BATAL → tutup popup konfirmasi
    btnConfirmNo.addEventListener("click", function () {
        confirmModal.style.display = "none";
    });

    // Klik BENAR → contoh aksi (sementara)
    btnConfirmYes.addEventListener("click", function () {

    if (!currentRow) return;

    const statusBadge = currentRow.querySelector(".badge-status");
    const actionButton = currentRow.querySelector(".btn-edit");

    if (actionType === "setujui") {
        statusBadge.textContent = "Disetujui";
        statusBadge.className = "badge-status disetujui";
    }

    if (actionType === "tolak") {
        statusBadge.textContent = "Ditolak";
        statusBadge.className = "badge-status ditolak";
    }

    // Disable tombol aksi
    actionButton.classList.add("disabled");
        actionButton.setAttribute("disabled", true);
        actionButton.classList.remove("btn-open-modal");

        // Tutup modal
        confirmModal.style.display = "none";
        detailModal.style.display = "none";

        // Reset
        currentRow = null;
        actionType = null;
    });


    confirmModal.addEventListener("click", function (e) {
    if (e.target === confirmModal) {
        confirmModal.style.display = "none";
    }
});

});

