document.addEventListener("DOMContentLoaded", function () {
    // ================= ACTIVE CARD =================
    document.addEventListener("click", function (e) {
        const card = e.target.closest(".detail-card");
        if (!card) return;

        // JANGAN aktif kalau klik tombol di dalam card
        if (e.target.closest(".btn-lihat-detail")) return;
        if (e.target.closest("#tambahToggle")) return;

        document
            .querySelectorAll(".detail-card")
            .forEach((c) => c.classList.remove("is-active"));
        card.classList.add("is-active");
    });

    // ================= GLOBAL CLICK HANDLER =================
    document.addEventListener("click", function (e) {
        // ===== LIHAT DETAIL ======
        if (e.target.closest(".btn-lihat-detail")) {
            e.stopImmediatePropagation();
            const card = e.target.closest(".detail-card");

            const rawImages = JSON.parse(card.dataset.images || "[]");

            window._popupImages = rawImages.length
                ? rawImages.map((img) =>
                      typeof img === "string"
                          ? { src: img, posX: 50, posY: 50 }
                          : img,
                  )
                : [
                      {
                          src: "/img/ruangan/default.jpg",
                          posX: 50,
                          posY: 50,
                      },
                  ];

            window._popupIndex = 0;
            window._currentCard = card;

            const first = window._popupImages[0];
            const popupImage = document.getElementById("popupImage");

            popupImage.src = first.src;
            popupImage.style.objectPosition = `${first.posX}% ${first.posY}%`;

            document.getElementById("popupNama").value = card.dataset.nama;

            renderTable(JSON.parse(card.dataset.elektronik), "popupElektronik");
            renderTable(
                JSON.parse(card.dataset.nonelektronik),
                "popupNonElektronik",
            );

            document.getElementById("popupDetail").style.display = "flex";
        }

        // ===== CLOSE POPUP =====
        if (e.target.id === "closepopup") {
            if (
                document.querySelector(".mode-edit").style.display === "block"
            ) {
                kembaliKeView();
            } else {
                document.getElementById("popupDetail").style.display = "none";
            }
        }

        // ===== NEXT IMAGE =====
        if (e.target.closest(".popup-nav.next")) {
            window._popupIndex++;
            showImage();
        }

        // ===== PREV IMAGE =====
        if (e.target.closest(".popup-nav.prev")) {
            window._popupIndex--;
            showImage();
        }
    });

    // ================= EDIT MODE =================
    const btnEditMode = document.getElementById("btnEditMode");
    const btnSimpan = document.getElementById("btnSimpan");
    const btnBatal = document.getElementById("btnBatal");
    const btnHapus = document.querySelector(".popup-action .btn-delete");

    if (btnEditMode) {
        btnEditMode.addEventListener("click", function () {
            document.querySelector(".mode-view").style.display = "none";
            document.querySelector(".mode-edit").style.display = "block";

            document.querySelector(".popup-header h5").innerText =
                "EDIT RUANGAN";

            btnEditMode.style.display = "none";
            btnHapus.style.display = "none";
            btnSimpan.style.display = "inline-flex";
            btnBatal.style.display = "inline-flex";

            const editImg = document.getElementById("editPopupImage");
            if (editImg && window._popupImages) {
                const data = window._popupImages[window._popupIndex];
                showImage();
                editImg.style.objectPosition = `${data.posX || 50}% ${data.posY || 50}%`;
            }

            isiFormEdit();
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener("click", kembaliKeView);
    }

    if (btnSimpan) {
        btnSimpan.addEventListener("click", function () {
            const card = window._currentCard;
            if (!card) return;

            // ================= SIMPAN NAMA =================
            const namaBaru = document.getElementById("editNama").value;
            card.dataset.nama = namaBaru;
            card.querySelector(".detail-card-header").innerText = namaBaru;
            document.getElementById("popupNama").value = namaBaru;

            // ================= SIMPAN ELEKTRONIK =================
            const dataElektronik = ambilDataTabel("editElektronik");
            card.dataset.elektronik = JSON.stringify(dataElektronik);

            // ================= SIMPAN NON ELEKTRONIK =================
            const dataNon = ambilDataTabel("editNonElektronik");
            card.dataset.nonelektronik = JSON.stringify(dataNon);

            // ================= SIMPAN FOTO =================
            card.dataset.images = JSON.stringify(window._popupImages);

            const carouselInner = card.querySelector(".carousel-inner");

            carouselInner.innerHTML = window._popupImages
                .map((img, i) => {
                    const src = img.src || img; // support format lama & baru
                    const posX = img.posX || 50;
                    const posY = img.posY || 50;

                    return `
    <div class="carousel-item ${i === 0 ? "active" : ""}">
      <img src="${src}" style="object-position:${posX}% ${posY}%;">
    </div>
  `;
                })
                .join("");

            // render ulang tabel view
            renderTable(dataElektronik, "popupElektronik");
            renderTable(dataNon, "popupNonElektronik");

            alert("Perubahan berhasil disimpan ✅");

            // ================= SIMPAN KE DATABASE =================
            fetch(`/superadmin/manajemen-ruangan/${card.dataset.id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({
                    nama: namaBaru,
                    elektronik: dataElektronik,
                    non: dataNon,
                    images: window._popupImages,
                }),
            })
                .then((res) => res.json())
                .then((res) => {
                    console.log("DB UPDATED:", res);
                    location.reload();
                })
                .catch((err) => {
                    console.error("GAGAL UPDATE DB:", err);
                });

            kembaliKeView();
        });
    }

    // =====================================================
    // FITUR POPUP TAMBAH FASILITAS
    // =====================================================

    let targetTabel = null;

    document.addEventListener("click", function (e) {
        const btnTambah = e.target.closest(".mode-edit .btn-tambah-item");
        if (btnTambah) {
            const tipe = btnTambah.dataset.target;

            const popup = document.getElementById("popupTambahFasilitas");
            const title = document.getElementById("popupTambahTitle");

            popup.style.display = "flex";

            if (tipe === "elektronik") {
                title.innerText = "Fasilitas Elektronik";
                targetTabel = "editElektronik";
            } else {
                title.innerText = "Fasilitas Non Elektronik";
                targetTabel = "editNonElektronik";
            }

            document.getElementById("tambahNama").value = "";
            document.getElementById("tambahJumlah").value = "";
        }

        if (
            e.target.id === "closeTambahPopup" ||
            e.target.id === "btnBatalFasilitas"
        ) {
            document.getElementById("popupTambahFasilitas").style.display =
                "none";
            targetTabel = null;
        }
    });

    // TOMBOL SIMPAN
    document
        .getElementById("btnSimpanFasilitas")
        .addEventListener("click", function () {
            const nama = document.getElementById("tambahNama").value.trim();
            const jumlah = document.getElementById("tambahJumlah").value.trim();
            if (!nama || !jumlah) return;

            const tbody = document.getElementById(targetTabel);
            const no = tbody.children.length + 1;

            tbody.innerHTML += `
      <tr>
        <td>${no}</td>
        <td><input class="form-control" value="${nama}"></td>
        <td><input type="number" class="form-control" value="${jumlah}"></td>
        <td>
          <button class="btn-hapus-item" title="Hapus">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;

            document.getElementById("popupTambahFasilitas").style.display =
                "none";
        });

    // ================= UPLOAD FOTO MODE EDIT =================
    const btnTambahFotoEdit = document.querySelector(
        ".mode-edit .btn-tambah-foto",
    );
    const inputFotoEdit = document.getElementById("inputFoto");

    if (btnTambahFotoEdit && inputFotoEdit) {
        btnTambahFotoEdit.addEventListener("click", () =>
            inputFotoEdit.click(),
        );

        inputFotoEdit.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                window._popupImages.push({
                    src: e.target.result,
                    posX: 50,
                    posY: 50,
                });
                window._popupIndex = window._popupImages.length - 1;
                showImage();
            };
            reader.readAsDataURL(file);

            this.value = "";
        });
    }

    // Hapus Foto
    document.addEventListener("click", function (e) {
        if (e.target.closest(".btn-hapus-foto")) {
            if (!window._popupImages || window._popupImages.length === 0)
                return;

            const yakin = confirm("Yakin mau hapus foto ini?");
            if (!yakin) return;

            // hapus foto dari array
            window._popupImages.splice(window._popupIndex, 1);

            // kalau foto habis
            if (window._popupImages.length === 0) {
                document.getElementById("editPopupImage").src = "";
                return;
            }

            // atur index biar gak error
            if (window._popupIndex >= window._popupImages.length) {
                window._popupIndex = window._popupImages.length - 1;
            }

            // tampilkan foto selanjutnya
            showImage();
        }
    });

    // Hapus Sarpras
    document.addEventListener("click", function (e) {
        if (e.target.closest(".btn-hapus-item")) {
            const row = e.target.closest("tr");
            const tbody = row.parentElement;

            const namaInput = row.querySelector(
                "input[type='text'], input:not([type])",
            );
            const namaItem = namaInput ? namaInput.value : "";

            const yakin = confirm(`Yakin mau hapus fasilitas "${namaItem}" ?`);
            if (!yakin) return;

            row.remove();

            rapikanNomor(tbody);
        }
    });

    // ================= HAPUS RUANGAN =================
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".btn-hapus-ruangan")) return;

        const card = window._currentCard;
        if (!card) {
            alert("Data ruangan tidak ditemukan");
            return;
        }

        const nama = card.dataset.nama;

        const konfirmasi = confirm(
            "Yakin mau menghapus ruangan '" +
                nama +
                "'?\n\nSemua data fasilitas & foto akan ikut terhapus.",
        );

        if (!konfirmasi) return;

        const id = card.dataset.id;

        fetch(`/superadmin/manajemen-ruangan/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
        })
            .then((res) => res.json())
            .then((res) => {
                if (!res.status) {
                    alert("Gagal menghapus ruangan");
                    return;
                }

                // ✅ HAPUS UI SETELAH SERVER BERHASIL
                card.remove();
                document.getElementById("popupDetail").style.display = "none";
                window._currentCard = null;

                alert("Ruangan berhasil dihapus 🗑️");
            })
            .catch((err) => {
                console.error("GAGAL HAPUS:", err);
                alert("Terjadi kesalahan server");
            });
    });

    // ================= TAMBAH RUANGAN =================
    const popupTambah = document.getElementById("popupTambahRuangan");
    const btnTambahRuangan = document.getElementById("tambahToggle");
    const btnCloseTambah = document.getElementById("closeTambahRuangan");
    const btnBatalTambah = document.getElementById("batalRuanganBaru");

    if (btnTambahRuangan) {
        btnTambahRuangan.addEventListener("click", () => {
            popupTambah.style.display = "flex";
        });
    }

    if (btnCloseTambah) {
        btnCloseTambah.addEventListener("click", () => {
            popupTambah.style.display = "none";
        });
    }

    if (btnBatalTambah) {
        btnBatalTambah.addEventListener("click", () => {
            popupTambah.style.display = "none";
        });
    }

    let fotoBaru = [];
    let fotoBaruIndex = 0;

    const btnTambahFotoBaru = document.getElementById("btnTambahFotoBaru");
    const inputFotoBaru = document.getElementById("inputFotoBaru");
    const previewFotoBaru = document.getElementById("previewFotoBaru");

    if (btnTambahFotoBaru) {
        btnTambahFotoBaru.addEventListener("click", () =>
            inputFotoBaru.click(),
        );
    }

    if (inputFotoBaru) {
        inputFotoBaru.addEventListener("change", function () {
            const files = Array.from(this.files);

            files.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    fotoBaru.push({
                        src: e.target.result,
                        posX: 50,
                        posY: 50,
                    });
                    fotoBaruIndex = fotoBaru.length - 1;
                    previewFotoBaru.src = fotoBaru[fotoBaruIndex].src;
                };
                reader.readAsDataURL(file);
            });
        });
    }

    document.addEventListener("click", function (e) {
        if (e.target.closest("#popupTambahRuangan .popup-nav.next")) {
            fotoBaruIndex++;
            tampilFotoBaru();
        }
        if (e.target.closest("#popupTambahRuangan .popup-nav.prev")) {
            fotoBaruIndex--;
            tampilFotoBaru();
        }
        if (e.target.id === "hapusFotoBaru") {
            if (!fotoBaru.length) return;
            fotoBaru.splice(fotoBaruIndex, 1);
            if (fotoBaruIndex >= fotoBaru.length)
                fotoBaruIndex = fotoBaru.length - 1;
            tampilFotoBaru();
        }
    });

    function tampilFotoBaru() {
        if (!fotoBaru.length) {
            previewFotoBaru.src = "";
            return;
        }
        fotoBaruIndex = (fotoBaruIndex + fotoBaru.length) % fotoBaru.length;
        previewFotoBaru.src = fotoBaru[fotoBaruIndex].src;
        previewFotoBaru.style.objectPosition = `${fotoBaru[fotoBaruIndex].posX}% ${fotoBaru[fotoBaruIndex].posY}%`;
    }

    document
        .getElementById("tambahElektronikBaru")
        .addEventListener("click", () => {
            tambahBaris("elektronikBaru");
        });

    document.getElementById("tambahNonBaru").addEventListener("click", () => {
        tambahBaris("nonBaru");
    });

    function tambahBaris(id) {
        const tbody = document.getElementById(id);
        const no = tbody.children.length + 1;

        const tr = document.createElement("tr");

        tr.innerHTML = `
    <td>${no}</td>
    <td><input class="form-control"></td>
    <td><input type="number" class="form-control"></td>
    <td>
      <button class="btn-hapus-item"><i class="bi bi-trash"></i></button>
    </td>
  `;

        tbody.appendChild(tr);
    }

    //SIMPAN TAMBAH RUANGAN
    const btnSimpanRuanganBaru = document.getElementById("simpanRuanganBaru");

    if (btnSimpanRuanganBaru) {
        btnSimpanRuanganBaru.addEventListener("click", simpanRuanganBaru);
    }

    //SIMPAN RUANGAN BARU
    function simpanRuanganBaru() {
        const nama = document.getElementById("namaRuanganBaru").value.trim();
        if (!nama) {
            alert("Nama ruangan wajib diisi!");
            return;
        }

        const elektronik = ambilDataDariTabelBaru("elektronikBaru");
        const non = ambilDataDariTabelBaru("nonBaru");

        if (!fotoBaru.length) {
            alert("Minimal 1 foto harus ditambahkan!");
            return;
        }

        fetch("/superadmin/manajemen-ruangan", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({
                nama: nama,
                elektronik: elektronik,
                non: non,
                images: fotoBaru,
            }),
        })
            .then(async (res) => {
                if (!res.ok) {
                    const text = await res.text(); // baca HTML error Laravel
                    console.error("SERVER ERROR:", text);
                    alert("Server error (cek Laravel log)");
                    throw new Error("Server error");
                }
                return res.json(); // HANYA SEKALI
            })
            .then((data) => {
                if (!data.status) {
                    alert("Gagal menyimpan ruangan");
                    return;
                }

                alert("Ruangan berhasil ditambahkan 🎉");
                location.reload();
            })
            .catch((err) => {
                console.error("FETCH ERROR:", err);
            });
    }
    // AMBIL DATA BARU CARD BARU
    function ambilDataDariTabelBaru(id) {
        const rows = document.querySelectorAll(`#${id} tr`);
        let data = [];

        rows.forEach((row) => {
            const nama = row.children[1].querySelector("input").value.trim();
            const jumlah = row.children[2].querySelector("input").value;

            if (nama && jumlah) {
                data.push({ nama, jumlah: parseInt(jumlah) });
            }
        });

        return data;
    }

    //RESET FROM TAMBAH RUANGAN
    function resetFormTambah() {
        document.getElementById("namaRuanganBaru").value = "";
        document.getElementById("elektronikBaru").innerHTML = "";
        document.getElementById("nonBaru").innerHTML = "";
        fotoBaru = [];
        fotoBaruIndex = 0;
        document.getElementById("previewFotoBaru").src = "";
    }

    // DARG POSISI FOTO
    document.querySelectorAll(".draggable-frame").forEach((frame) => {
        const img = frame.querySelector("img");

        let dragging = false;
        let posX = 50;
        let posY = 50;

        frame.addEventListener("mousedown", () => {
            dragging = true;
            frame.style.cursor = "grabbing";
        });

        document.addEventListener("mouseup", () => {
            dragging = false;
            frame.style.cursor = "grab";
        });

        frame.addEventListener("mousemove", (e) => {
            if (!dragging) return;

            const rect = frame.getBoundingClientRect();

            let x = ((e.clientX - rect.left) / rect.width) * 100;
            let y = ((e.clientY - rect.top) / rect.height) * 100;

            posX = Math.max(0, Math.min(100, x));
            posY = Math.max(0, Math.min(100, y));

            img.style.objectPosition = `${posX}% ${posY}%`;

            // simpan posisi ke dataset biar bisa disimpan ke card
            img.dataset.posX = posX;
            img.dataset.posY = posY;
        });
    });
});

// ================= FUNCTIONS =================
function showImage() {
    if (!window._popupImages || !window._popupImages.length) return;

    const arr = window._popupImages;
    window._popupIndex = (window._popupIndex + arr.length) % arr.length;

    const data = arr[window._popupIndex]; // sekarang tiap foto punya src,posX,posY

    // ===== MODE EDIT =====
    if (document.querySelector(".mode-edit").style.display === "block") {
        const img = document.getElementById("editPopupImage");
        img.src = data.src || data; // fallback kalau foto lama
        img.style.objectPosition = `${data.posX || 50}% ${data.posY || 50}%`;
    }

    // ===== MODE VIEW =====
    else {
        const img = document.getElementById("popupImage");
        img.src = data.src || data;
        img.style.objectPosition = `${data.posX || 50}% ${data.posY || 50}%`;
    }
}

function renderTable(data, target) {
    const tbody = document.getElementById(target);
    tbody.innerHTML = "";
    data.forEach((item, i) => {
        tbody.innerHTML += `
      <tr>
        <td>${i + 1}</td>
        <td>${item.nama}</td>
        <td>${item.jumlah}</td>
      </tr>`;
    });
}

function isiFormEdit() {
    document.getElementById("editNama").value =
        document.getElementById("popupNama").value;

    const editEl = document.getElementById("editElektronik");
    editEl.innerHTML = "";

    document.querySelectorAll("#popupElektronik tr").forEach((row, i) => {
        editEl.innerHTML += `
      <tr>
        <td>${i + 1}</td>
        <td><input class="form-control" value="${row.children[1].innerText}"></td>
        <td><input type="number" class="form-control" value="${row.children[2].innerText}"></td>
        <td>
          <button class="btn-hapus-item" title="Hapus">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>`;
    });

    const editNon = document.getElementById("editNonElektronik");
    editNon.innerHTML = "";

    document.querySelectorAll("#popupNonElektronik tr").forEach((row, i) => {
        editNon.innerHTML += `
      <tr>
        <td>${i + 1}</td>
        <td><input class="form-control" value="${row.children[1].innerText}"></td>
        <td><input type="number" class="form-control" value="${row.children[2].innerText}"></td>
        <td>
          <button class="btn-hapus-item" title="Hapus">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>`;
    });
}

function kembaliKeView() {
    document.querySelector(".mode-view").style.display = "block";
    document.querySelector(".mode-edit").style.display = "none";

    document.querySelector(".popup-header h5").innerText = "DETAIL RUANGAN";

    document.getElementById("btnEditMode").style.display = "inline-flex";
    document.querySelector(".popup-action .btn-delete").style.display =
        "inline-flex";
    document.getElementById("btnSimpan").style.display = "none";
    document.getElementById("btnBatal").style.display = "none";

    //KEMBALIKAN FOTO VIEW
    showImage();
}

// Simpan edit
function ambilDataTabel(idTabel) {
    const rows = document.querySelectorAll(`#${idTabel} tr`);
    let data = [];

    rows.forEach((row) => {
        const nama = row.querySelector(
            "input[type='text'], input:not([type])",
        ).value;
        const jumlah = row.querySelector("input[type='number']").value;

        data.push({
            nama: nama,
            jumlah: parseInt(jumlah),
        });
    });

    return data;
}

//RAPIHIN NOMOR
function rapikanNomor(tbody) {
    const rows = tbody.querySelectorAll("tr");
    rows.forEach((row, i) => {
        row.children[0].innerText = i + 1;
    });
}