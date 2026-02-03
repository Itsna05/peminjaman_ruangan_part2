document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formEditPeminjaman");

    const fields = form.querySelectorAll(".edit-field");

    const editBidang = document.getElementById("edit_bidang");
    const editSubBidang = document.getElementById("edit_sub_bidang");

    const footerView = document.getElementById("footerView");
    const footerEdit = document.getElementById("footerEdit");

    const btnEdit = document.getElementById("btnEdit");
    const btnBatal = document.getElementById("btnBatal");
    const btnSimpan = document.getElementById("btnSimpan");
    const modal = document.getElementById("modalEditPeminjaman");
    const btnBatalkanPeminjaman = document.getElementById(
        "btnBatalkanPeminjaman",
    );

    modal.addEventListener("shown.bs.modal", function () {
        setViewMode(); // PAKSA VIEW MODE SAAT MODAL MUNCUL
    });

    modal.addEventListener("hidden.bs.modal", function () {
        setViewMode(); // reset state saat modal ditutup
    });

    // ======================
    // VIEW MODE
    function setViewMode() {
        fields.forEach((el) => {
            el.classList.add("readonly-view");

            // 🔥 JANGAN disable
            el.readOnly = true;
        });

        footerView.classList.remove("d-none");
        footerEdit.classList.add("d-none");
    }

    // ======================
    // EDIT MODE
    // ======================
    function setEditMode() {
        fields.forEach((el) => {
            el.classList.remove("readonly-view");
            el.readOnly = false;
        });

        footerView.classList.add("d-none");
        footerEdit.classList.remove("d-none");
    }

    // ======================
    // LOAD SUB BIDANG
    // ======================
    function loadSubBidang(bidang, selected = null) {
        fetch(`/get-sub-bidang?bidang=${encodeURIComponent(bidang)}`)
            .then((res) => res.json())
            .then((data) => {
                editSubBidang.innerHTML = "";
                data.forEach((item) => {
                    const opt = document.createElement("option");
                    opt.value = item.sub_bidang;
                    opt.textContent = item.sub_bidang;
                    editSubBidang.appendChild(opt);
                });
                if (selected) editSubBidang.value = selected;
            });
    }

    // ======================
    // KLIK ICON ✎
    // ======================
    document.querySelectorAll(".btn-edit").forEach((btn) => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            document.getElementById("edit_id").value = id;

            fetch(`/peminjaman-ruangan/${id}`)
                .then((res) => res.json())
                .then((data) => {
                    originalData = JSON.parse(JSON.stringify(data));
                    form.acara.value = data.acara;
                    form.jumlah_peserta.value = data.jumlah_peserta;
                    form.no_wa.value = data.no_wa;
                    form.catatan.value = data.catatan ?? "";

                    if (data.waktu_mulai) {
                        const [tm, jm] = data.waktu_mulai.split(" ");
                        edit_tgl_mulai.value = tm;
                        edit_jam_mulai.value = jm.substring(0, 5);
                    }

                    if (data.waktu_selesai) {
                        const [ts, js] = data.waktu_selesai.split(" ");
                        edit_tgl_selesai.value = ts;
                        edit_jam_selesai.value = js.substring(0, 5);
                    }

                    editBidang.value = data.bidang;
                    loadSubBidang(data.bidang, data.sub_bidang);

                    edit_ruangan.value = data.id_ruangan;
                });
        });
    });

    function restoreOriginalData() {
        if (!originalData) return;

        form.acara.value = originalData.acara;
        form.jumlah_peserta.value = originalData.jumlah_peserta;
        form.no_wa.value = originalData.no_wa;
        form.catatan.value = originalData.catatan ?? "";

        if (originalData.waktu_mulai) {
            const [tm, jm] = originalData.waktu_mulai.split(" ");
            edit_tgl_mulai.value = tm;
            edit_jam_mulai.value = jm.substring(0, 5);
        }

        if (originalData.waktu_selesai) {
            const [ts, js] = originalData.waktu_selesai.split(" ");
            edit_tgl_selesai.value = ts;
            edit_jam_selesai.value = js.substring(0, 5);
        }

        editBidang.value = originalData.bidang;
        loadSubBidang(originalData.bidang, originalData.sub_bidang);

        edit_ruangan.value = originalData.id_ruangan;
    }

    btnBatalkanPeminjaman.onclick = function () {
        const id = document.getElementById("edit_id").value;

        if (!id) return;

        const confirmCancel = confirm(
            "Apakah Anda yakin akan membatalkan peminjaman ini?\n\nTindakan ini tidak dapat dibatalkan.",
        );

        if (!confirmCancel) return;

        // 🔥 LANJUTKAN PEMBATALAN
        fetch(`/peminjaman-ruangan/${id}/batalkan`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
        })
            .then((res) => res.json())
            .then((res) => {
                if (res.success) {
                    alert("Peminjaman berhasil dibatalkan.");
                    location.reload();
                } else {
                    alert("Gagal membatalkan peminjaman.");
                }
            });
    };

    // ======================
    // EVENT
    // ======================
    editBidang.onchange = () => loadSubBidang(editBidang.value);
    btnEdit.onclick = setEditMode;
    btnBatal.onclick = function () {
        restoreOriginalData(); // 🔁 KEMBALIKAN DATA
        setViewMode(); // 🔒 KUNCI FORM
    };

    btnSimpan.onclick = function (e) {
        console.log("BTN SIMPAN:", btnSimpan);

        e.preventDefault();

        edit_waktu_mulai.value =
            edit_tgl_mulai.value + " " + edit_jam_mulai.value + ":00";

        edit_waktu_selesai.value =
            edit_tgl_selesai.value + " " + edit_jam_selesai.value + ":00";

        const id = edit_id.value;

        fetch(`/peminjaman-ruangan/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({
                acara: form.acara.value,
                jumlah_peserta: form.jumlah_peserta.value,
                waktu_mulai: edit_waktu_mulai.value,
                waktu_selesai: edit_waktu_selesai.value,
                bidang: editBidang.value,
                sub_bidang: editSubBidang.value,
                id_ruangan: edit_ruangan.value,
                no_wa: form.no_wa.value,
                catatan: form.catatan.value,
            }),
        })
            .then(async (res) => {
                const contentType = res.headers.get("content-type");

                if (contentType && contentType.includes("application/json")) {
                    return res.json();
                }

                // kalau bukan JSON → reload saja
                location.reload();
            })
            .then((res) => {
                if (res?.success) location.reload();
            })
            .catch((err) => console.error("Update error:", err));
    };
});
