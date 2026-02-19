document.addEventListener("DOMContentLoaded", () => {
    const btnKelola = document.getElementById("btnKelolaFaq");
    const btnTambah = document.getElementById("btnTambahFaq");
    const btnBatal = document.getElementById("btnBatalFaq");

    const view = document.getElementById("faqViewMode");
    const edit = document.getElementById("faqEditMode");
    const form = document.getElementById("formTambahFaq");

    // Masuk edit
    btnKelola?.addEventListener("click", () => {
        view.style.display = "none";
        edit.style.display = "block";
        btnKelola.style.display = "none";
    });

    // Show form tambah
    btnTambah?.addEventListener("click", () => {
        form.style.display = "block";
    });

    // Batal
    btnBatal?.addEventListener("click", () => {
        edit.style.display = "none";
        view.style.display = "block";
        btnKelola.style.display = "inline-block";

        form.style.display = "none";
    });
});
