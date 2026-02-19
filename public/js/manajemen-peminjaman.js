document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("detailModal");
    if (!modal) return;

    let currentPeminjamanId = null;

    const btnUpload = document.getElementById("btnUploadFoto");
    const btnGanti = document.getElementById("btnGantiFoto");
    const btnHapus = document.getElementById("btnHapusFoto");
    const preview = document.getElementById("fotoPreviewBox");
    const inputFoto = document.getElementById("fotoKegiatan");
    const uploadArea = document.getElementById("uploadArea");

    /* ================= MODAL ================= */

    function openModal() {
        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closeModal() {
        modal.classList.remove("active");
        document.body.style.overflow = "";
        currentPeminjamanId = null;
    }

    modal.querySelector(".modal-close")?.addEventListener("click", closeModal);

    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    /* ================= FOTO UI ================= */

    function updateFotoUI(foto) {
        btnUpload.classList.add("hidden");
        btnGanti.classList.add("hidden");
        btnHapus.classList.add("hidden");

        preview.innerHTML = "";

        // upload card
        uploadArea.classList.add("hidden");

        if (foto) {
            // ADA FOTO
            preview.innerHTML = `
            <img 
                src="/storage/foto_kegiatan/${foto}"
                class="foto-preview-img"
            >
        `;

            btnGanti.classList.remove("hidden");
            btnHapus.classList.remove("hidden");
        } else {
            // BELUM ADA FOTO
            uploadArea.classList.remove("hidden");
        }
    }

    /* ================= UPLOAD CARD ================= */

    if (uploadArea) {
        // klik
        uploadArea.addEventListener("click", () => {
            inputFoto.click();
        });

        // drag masuk
        uploadArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            uploadArea.classList.add("dragover");
        });

        // drag keluar
        uploadArea.addEventListener("dragleave", () => {
            uploadArea.classList.remove("dragover");
        });

        // drop file
        uploadArea.addEventListener("drop", (e) => {
            e.preventDefault();

            uploadArea.classList.remove("dragover");

            const files = e.dataTransfer.files;

            if (files.length) {
                inputFoto.files = files;

                // trigger upload
                inputFoto.dispatchEvent(new Event("change"));
            }
        });
    }

    /* ================= OPEN MODAL ================= */

    document.querySelectorAll(".btn-open-modal").forEach((btn) => {
        btn.addEventListener("click", function () {
            currentPeminjamanId = this.dataset.id;
            if (!currentPeminjamanId) return;

            openModal();

            fetch(`/superadmin/peminjaman/${currentPeminjamanId}`)
                .then((r) => r.json())
                .then((data) => {
                    // isi data
                    document.getElementById("mAcara").value = data.acara ?? "-";
                    document.getElementById("mPeserta").value =
                        (data.jumlah_peserta ?? "-") + " orang";
                    document.getElementById("mTanggal").value =
                        data.tanggal ?? "-";
                    document.getElementById("mWaktu").value =
                        (data.waktu_mulai ?? "-") +
                        " - " +
                        (data.waktu_selesai ?? "-");
                    document.getElementById("mBidang").value =
                        data.bidang ?? "-";
                    document.getElementById("mSubBidang").value =
                        data.sub_bidang ?? "-";
                    document.getElementById("mRuangan").value =
                        data.ruangan ?? "-";
                    document.getElementById("mWa").value = data.no_wa ?? "-";
                    document.getElementById("mCatatan").value =
                        data.catatan ?? "-";

                    /* STATUS */

                    const status = (data.status_peminjaman || "").toLowerCase();

                    const approveBox = document.getElementById("actionApprove");
                    const uploadBox = document.getElementById("actionUpload");
                    const disabledBox =
                        document.getElementById("actionDisabled");

                    approveBox.classList.add("hidden");
                    uploadBox.classList.add("hidden");
                    disabledBox.classList.add("hidden");

                    if (status.includes("menunggu")) {
                        approveBox.classList.remove("hidden");
                    } else if (status.includes("disetujui")) {
                        uploadBox.classList.remove("hidden");
                    } else {
                        disabledBox.classList.remove("hidden");
                    }

                    /* FOTO */

                    const foto = (data.foto_kegiatan || "").trim();

                    updateFotoUI(foto);
                });
        });
    });

    /* ================= BUTTON FOTO ================= */

    document.addEventListener("click", (e) => {
        if (e.target.id === "btnUploadFoto" || e.target.id === "btnGantiFoto") {
            inputFoto.click();
        }
    });

    /* ================= UPLOAD ================= */

    inputFoto?.addEventListener("change", function () {
        if (!currentPeminjamanId) return;

        const file = this.files[0];
        if (!file) return;

        const form = new FormData();
        form.append("foto", file);

        fetch(`/superadmin/peminjaman/${currentPeminjamanId}/upload-foto`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: form,
        })
            .then((r) => r.json())
            .then((r) => {
                if (r.status) {
                    alert("Foto berhasil disimpan");
                    location.reload();
                }
            });
    });

    /* ================= HAPUS ================= */

    document.addEventListener("click", (e) => {
        if (e.target.id === "btnHapusFoto") {
            if (!confirm("Hapus foto ini?")) return;

            fetch(`/superadmin/peminjaman/${currentPeminjamanId}/hapus-foto`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            })
                .then((r) => r.json())
                .then((r) => {
                    if (r.status) {
                        alert("Foto dihapus");
                        location.reload();
                    }
                });
        }
    });
});
