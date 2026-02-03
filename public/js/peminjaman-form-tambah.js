document.addEventListener("DOMContentLoaded", function () {
    const bidang = document.getElementById("bidang");
    const subBidang = document.getElementById("sub_bidang");

    if (!bidang || !subBidang) return;

    bidang.addEventListener("change", function () {
        const selectedBidang = this.value;

        subBidang.innerHTML =
            '<option value="" disabled selected hidden>Pilih Sub Bidang</option>';

        if (!selectedBidang) return;

        fetch(`/get-sub-bidang?bidang=` + encodeURIComponent(selectedBidang))
            .then((res) => res.json())
            .then((data) => {
                data.forEach((item) => {
                    const opt = document.createElement("option");
                    opt.value = item.sub_bidang;
                    opt.textContent = item.sub_bidang;
                    subBidang.appendChild(opt);
                });
            })
            .catch((err) => console.error("Gagal load sub bidang:", err));
    });
});
