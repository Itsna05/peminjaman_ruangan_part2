document.addEventListener("DOMContentLoaded", function () {
    // ================= ACTIVE CARD =================
    document.addEventListener("click", function (e) {
        const card = e.target.closest(".detail-card");
        if (!card) return;

        if (e.target.closest(".btn-lihat-detail")) return;
        if (e.target.closest("#tambahToggle")) return;

        document
            .querySelectorAll(".detail-card")
            .forEach((c) => c.classList.remove("is-active"));
        card.classList.add("is-active");
    });

    // ================= GLOBAL CLICK HANDLER =================
    document.addEventListener("click", function (e) {
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

        if (e.target.id === "closepopup") {
            if (
                document.querySelector(".mode-edit").style.display === "block"
            ) {
                kembaliKeView();
            } else {
                document.getElementById("popupDetail").style.display = "none";
            }
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

            btnEditMode.style.display = "none";
            btnHapus.style.display = "none";
            btnSimpan.style.display = "inline-flex";
            btnBatal.style.display = "inline-flex";

            isiFormEdit();
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener("click", kembaliKeView);
    }

    // =====================================================
    // 🔧 FIX ERROR DI SINI (TOMBOL SIMPAN FASILITAS)
    // =====================================================

    const btnSimpanFasilitas = document.getElementById("btnSimpanFasilitas");

    if (btnSimpanFasilitas) {
        btnSimpanFasilitas.addEventListener("click", function () {
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
    }
    // =====================================================
    // 🔧 END FIX
    // =====================================================

    // ================= TAMBAH RUANGAN =================
    const btnTambahRuangan = document.getElementById("tambahToggle");
    const popupTambah = document.getElementById("popupTambahRuangan");

    if (btnTambahRuangan) {
        btnTambahRuangan.addEventListener("click", () => {
            popupTambah.style.display = "flex";
        });
    }
});

// ================= FUNCTIONS =================
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

function isiFormEdit() {}
function kembaliKeView() {}
