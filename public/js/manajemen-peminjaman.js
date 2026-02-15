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

                    // 🔍 DEBUG FULL DATA
                    console.log("ISI DATA FULL:", data);

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

                    const footer = document.getElementById("modalFooterAction");
                    if (!footer) return;

                    // 🔍 DEBUG STATUS
                    const rawStatus = data.status_peminjaman || data.status || "";
                    const status = rawStatus.toLowerCase();

                    console.log("STATUS TERBACA:", status);

                    if (status.includes("menunggu")) {

                        footer.innerHTML = `
                            <button class="btn-approve">Setujui</button>
                            <button class="btn-reject">Tolak</button>
                        `;

                        footer.querySelector(".btn-approve")
                            .addEventListener("click", () => openConfirm("approve"));

                        footer.querySelector(".btn-reject")
                            .addEventListener("click", () => openConfirm("reject"));

                    } else if (status.includes("disetujui")) {

                        footer.innerHTML = `
                            <div class="upload-section">
                                <label style="display:block;margin-bottom:6px;font-weight:600;">
                                    Upload Foto Setelah Kegiatan
                                </label>

                                <input type="file" 
                                    id="fotoKegiatan" 
                                    accept="image/*"
                                    class="form-control"
                                    style="margin-bottom:12px;">

                                <button class="btn-simpan-foto">
                                    Simpan Foto
                                </button>
                            </div>
                        `;

                        const inputFile = document.getElementById("fotoKegiatan");
                        const btnSimpanFoto = footer.querySelector(".btn-simpan-foto");

                        btnSimpanFoto.addEventListener("click", function () {

                            if (!inputFile.files.length) {
                                alert("Silakan pilih foto terlebih dahulu.");
                                return;
                            }

                            const formData = new FormData();
                            formData.append("foto", inputFile.files[0]);

                            fetch(`/superadmin/peminjaman/${currentPeminjamanId}/upload-foto`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document
                                        .querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute("content")
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.status) {
                                    alert("Foto berhasil disimpan ✅");
                                    location.reload();
                                } else {
                                    alert("Gagal upload foto");
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert("Terjadi kesalahan server");
                            });
                        });
                    } else {

                        footer.innerHTML = `
                            <button class="btn-disabled" disabled>
                                Tidak ada aksi
                            </button>
                        `;
                    }

                })


                .catch(() => {
                    modalContent.innerHTML = "Gagal memuat data.";
                });
        });
    });


    // =====================
    // EVENT DELEGATION UNTUK APPROVE / REJECT
    // =====================
    document.addEventListener("click", function (e) {

        if (e.target.closest(".btn-approve")) {
            openConfirm("approve");
        }

        if (e.target.closest(".btn-reject")) {
            openConfirm("reject");
        }

    });

    
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
