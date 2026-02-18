document.addEventListener("DOMContentLoaded", function () {

  const btnKelola = document.getElementById("btnKelolaFaq");
  const viewMode = document.getElementById("faqViewMode");
  const editMode = document.getElementById("faqEditMode");

  let faqData = [
    {
      question: "Bagaimana cara membatalkan pesanan ruangan?",
      answer: "Pembatalan peminjaman dapat dilakukan melalui sistem sebelum jadwal penggunaan ruangan berlangsung."
    },
    {
      question: "Bagaimana jika terjadi masalah saat rapat?",
      answer: "Silakan menghubungi petugas atau pengelola ruangan yang bertugas."
    },
    {
      question: "Apakah ada layanan konsumsi?",
      answer: "Layanan konsumsi tersedia sesuai kebijakan instansi dan permohonan peminjaman."
    }
  ];

  function renderView() {
    viewMode.innerHTML = "";

    faqData.forEach((faq, index) => {
      viewMode.innerHTML += `
            <details class="faq-item">
                <summary>${faq.question}</summary>
                <p>${faq.answer}</p>
            </details>
        `;
    });

    // Batasi tinggi jika lebih dari 3
    if (faqData.length > 3) {
      viewMode.classList.add("faq-scroll");
    } else {
      viewMode.classList.remove("faq-scroll");
    }
  }

  function renderEdit() {
    editMode.innerHTML = `
            <div class="d-flex justify-content-end mb-3 gap-2">
                <button id="btnTambahFaq" class="btn-tambah">+ Tambah FAQ</button>
                <button id="btnSimpanFaq" class="btn-simpan">Simpan</button>
                <button id="btnBatalFaq" class="btn-batal">Batal</button>
            </div>
        `;

    faqData.forEach((faq, index) => {
      editMode.innerHTML += `
                <div class="faq-edit-item border p-3 mb-3 rounded position-relative">
                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>

                    <label>Pertanyaan</label>
                    <input type="text" class="form-control mb-2" value="${faq.question}" data-field="question" data-index="${index}">

                    <label>Jawaban</label>
                    <textarea class="form-control" rows="3" data-field="answer" data-index="${index}">${faq.answer}</textarea>
                </div>
            `;
    });

    attachEditEvents();
  }

  function attachEditEvents() {

    // Update data saat diketik
    document.querySelectorAll("[data-field]").forEach(el => {
      el.addEventListener("input", function () {
        const index = this.dataset.index;
        const field = this.dataset.field;
        faqData[index][field] = this.value;
      });
    });

    // Tambah
    document.getElementById("btnTambahFaq").addEventListener("click", function () {
      faqData.push({ question: "", answer: "" });
      renderEdit();
    });

    // Hapus
    document.querySelectorAll(".btn-danger").forEach(btn => {
      btn.addEventListener("click", function () {
        if (!confirm("Yakin ingin menghapus FAQ ini?")) return;
        const index = this.dataset.index;
        faqData.splice(index, 1);
        renderEdit();
      });
    });

    // Simpan
    document.getElementById("btnSimpanFaq").addEventListener("click", function () {
      if (!confirm("Simpan perubahan FAQ?")) return;

      renderView();
      editMode.style.display = "none";
      viewMode.style.display = "block";
      btnKelola.style.display = "inline-block";
    });

    // Batal
    document.getElementById("btnBatalFaq").addEventListener("click", function () {
      if (!confirm("Batalkan perubahan?")) return;

      editMode.style.display = "none";
      viewMode.style.display = "block";
      btnKelola.style.display = "inline-block";
    });
  }

  btnKelola?.addEventListener("click", function () {
    viewMode.style.display = "none";
    editMode.style.display = "block";
    btnKelola.style.display = "none";
    renderEdit();
  });

  renderView();
});