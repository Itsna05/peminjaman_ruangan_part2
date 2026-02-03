document.addEventListener("DOMContentLoaded", function () {

    // =====================================================
    // EARLY EXIT → BUKAN HALAMAN EDIT PEMINJAMAN
    // =====================================================
    const form = document.getElementById("formEditPeminjaman");
    const modal = document.getElementById("modalEditPeminjaman");

    if (!form || !modal) {
        return;
    }

    let originalData = null;

    // =====================================================
    // ELEMENT
    // =====================================================
    const fields = form.querySelectorAll(".edit-field");

    const editBidang = document.getElementById("edit_bidang");
    const editSubBidang = document.getElementById("edit_sub_bidang");

    const footerView = document.getElementById("footerView");
    const footerEdit = document.getElementById("footerEdit");

    const btnEdit = document.getElementById("btnEdit");
    const btnBatal = document.getElementById("btnBatal");
    const btnSimpan = document.getElementById("btnSimpan");
    const btnBatalkanPeminjaman =
        document.getElementById("btnBatalkanPeminjaman");

    // =====================================================
    // SAFETY GUARD
    // =====================================================
    if (!editBidang || !editSubBidang || !footerView || !footerEdit) {
        return;
    }

    // =====================================================
    // MODAL STATE
    // =====================================================
    modal.addEventListener("shown.bs.modal", setViewMode);
    modal.addEventListener("hidden.bs.modal", setViewMode);

    // ======================
    // VIEW MODE
    function setViewMode() {
        fields.forEach(el => {
            el.classList.add("readonly-view");
            el.readOnly = true;
        });

        footerView.classList.remove("d-none");
        footerEdit.classList.add("d-none");
    }

    // ======================
    // EDIT MODE
    function setEditMode() {
        fields.forEach(el => {
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
        if (!bidang) return;

        fetch(`/get-sub-bidang?bidang=${encodeURIComponent(bidang)}`)
            .then(res => res.json())
            .then(data => {
                editSubBidang.innerHTML = "";
                data.forEach(item => {
                    const opt = document.createElement("option");
                    opt.value = item.sub_bidang;
                    opt.textContent = item.sub_bidang;
                    editSubBidang.appendChild(opt);
                });

                if (selected) editSubBidang.value = selected;
            });
    }

    // ======================
    // OPEN EDIT (ICON ✎)
    // ======================
    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            if (!id) return;

            document.getElementById("edit_id").value = id;

            fetch(`/peminjaman-ruangan/${id}`)
                .then(res => res.json())
                .then(data => {
                    originalData = JSON.parse(JSON.stringify(data));

                    form.acara.value = data.acara;
                    form.jumlah_peserta.value = data.jumlah_peserta;
                    form.no_wa.value = data.no_wa;
                    form.catatan.value = data.catatan ?? "";

                    if (data.waktu_mulai) {
                        const [tgl, jam] = data.waktu_mulai.split(" ");
                        edit_tgl_mulai.value = tgl;
                        edit_jam_mulai.value = jam.substring(0, 5);
                    }

                    if (data.waktu_selesai) {
                        const [tgl, jam] = data.waktu_selesai.split(" ");
                        edit_tgl_selesai.value = tgl;
                        edit_jam_selesai.value = jam.substring(0, 5);
                    }

                    editBidang.value = data.bidang;
                    loadSubBidang(data.bidang, data.sub_bidang);

                    edit_ruangan.value = data.id_ruangan;
                });
        });
    });

    // ======================
    // RESTORE DATA
    // ======================
    function restoreOriginalData() {
        if (!originalData) return;

        form.acara.value = originalData.acara;
        form.jumlah_peserta.value = originalData.jumlah_peserta;
        form.no_wa.value = originalData.no_wa;
        form.catatan.value = originalData.catatan ?? "";

        if (originalData.waktu_mulai) {
            const [tgl, jam] = originalData.waktu_mulai.split(" ");
            edit_tgl_mulai.value = tgl;
            edit_jam_mulai.value = jam.substring(0, 5);
        }

        if (originalData.waktu_selesai) {
            const [tgl, jam] = originalData.waktu_selesai.split(" ");
            edit_tgl_selesai.value = tgl;
            edit_jam_selesai.value = jam.substring(0, 5);
        }

        editBidang.value = originalData.bidang;
        loadSubBidang(originalData.bidang, originalData.sub_bidang);

        edit_ruangan.value = originalData.id_ruangan;
    }

    // ======================
    // BATALKAN PEMINJAMAN
    // ======================
    if (btnBatalkanPeminjaman) {
        btnBatalkanPeminjaman.addEventListener("click", function () {
            const id = document.getElementById("edit_id").value;
            if (!id) return;

            if (!confirm(
                "Apakah Anda yakin akan membatalkan peminjaman ini?\n\nTindakan ini tidak dapat dibatalkan."
            )) return;

            fetch(`/peminjaman-ruangan/${id}/batalkan`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document.querySelector('meta[name="csrf-token"]')?.content
                },
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert("Peminjaman berhasil dibatalkan.");
                        location.reload();
                    } else {
                        alert("Gagal membatalkan peminjaman.");
                    }
                });
        });
    }

    // ======================
    // EVENT
    // ======================
    editBidang.addEventListener("change", () =>
        loadSubBidang(editBidang.value)
    );

    if (btnEdit) btnEdit.addEventListener("click", setEditMode);

    if (btnBatal) {
        btnBatal.addEventListener("click", function () {
            restoreOriginalData();
            setViewMode();
        });
    }

    if (btnSimpan) {
        btnSimpan.addEventListener("click", function (e) {
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
                    "X-CSRF-TOKEN":
                        document.querySelector('meta[name="csrf-token"]')?.content
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
                .then(res => {
                    if (res.headers
                        .get("content-type")
                        ?.includes("application/json")) {
                        return res.json();
                    }
                    location.reload();
                })
                .then(res => {
                    if (res?.success) location.reload();
                })
                .catch(err => console.error("Update error:", err));
        });
    }

});
