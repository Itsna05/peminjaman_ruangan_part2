document.addEventListener("DOMContentLoaded", function () {

    const tglMulai = document.getElementById("tgl_mulai");
    const tglSelesai = document.getElementById("tgl_selesai");
    const jamMulai = document.getElementById("jam_mulai");
    const jamSelesai = document.getElementById("jam_selesai");

    if (!tglMulai || !tglSelesai) return;

    const today = new Date().toISOString().split("T")[0];
    tglMulai.min = today;
    tglSelesai.min = today;

    tglMulai.addEventListener("change", function () {
        if (this.value === today && jamMulai) {
            const now = new Date();
            jamMulai.min =
                String(now.getHours()).padStart(2, "0") + ":" +
                String(now.getMinutes()).padStart(2, "0");
        } else if (jamMulai) {
            jamMulai.removeAttribute("min");
        }
    });

    jamMulai?.addEventListener("change", function () {
        if (jamSelesai) jamSelesai.min = this.value;
    });

});

function gabungWaktu() {
    const tglMulai = document.getElementById("tgl_mulai")?.value;
    const jamMulai = document.getElementById("jam_mulai")?.value;
    const tglSelesai = document.getElementById("tgl_selesai")?.value;
    const jamSelesai = document.getElementById("jam_selesai")?.value;

    if (tglMulai && jamMulai)
        document.getElementById("waktu_mulai").value = `${tglMulai} ${jamMulai}:00`;

    if (tglSelesai && jamSelesai)
        document.getElementById("waktu_selesai").value = `${tglSelesai} ${jamSelesai}:00`;
}
