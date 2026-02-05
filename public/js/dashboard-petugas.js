document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById("modalDetailPeminjaman");
    const modal = new bootstrap.Modal(modalElement);

    // PAKSA BERSIH SAAT MODAL DITUTUP
    modalElement.addEventListener("hidden.bs.modal", function () {
        document.body.classList.remove("modal-open");

        document.querySelectorAll(".modal-backdrop").forEach((el) => {
            el.remove();
        });
    });

    let eventsOfDay = [];
    let currentIndex = 0;

    document.body.addEventListener('click', function (e) {
        const box = e.target.closest('.event-clickable');
        if (!box) return;

        const clickedDate = box.dataset.date;

        eventsOfDay = [...document.querySelectorAll(`.event-clickable[data-date="${clickedDate}"]`)]
            .map(el => el.dataset.id);

        currentIndex = eventsOfDay.indexOf(box.dataset.id);

        loadEvent(currentIndex);
        modal.show(); 
    });

    function loadEvent(index) {
        const id = eventsOfDay[index];
        const data = ALL_EVENTS[id]; 
        renderModal(data, index);
    }

    function renderModal(data, index) {
        document.getElementById('modalDetailContent').innerHTML = `
        <div class="modal-nav">
            <button class="nav-btn" onclick="prevEvent()" ${index === 0 ? 'disabled' : ''}>‹</button>
            <span class="nav-count">${index + 1} / ${eventsOfDay.length}</span>
            <button class="nav-btn" onclick="nextEvent()" ${index === eventsOfDay.length - 1 ? 'disabled' : ''}>›</button>
        </div>
        <p><strong>Nama Acara</strong><br>${data.acara}</p>
        <p><strong>Jumlah Peserta</strong><br>${data.jumlah_peserta} orang</p>
        <p><strong>Waktu</strong><br>${data.waktu_mulai} - ${data.waktu_selesai}</p>
        <p><strong>Bidang</strong><br>${data.bidang}</p>
        <p><strong>Sub Bidang</strong><br>${data.sub_bidang}</p>
        <p><strong>Ruangan</strong><br>${data.ruangan}</p>
        <p><strong>Catatan</strong><br>${data.catatan}</p>
    `;
    }

    window.nextEvent = function () {
        if (currentIndex < eventsOfDay.length - 1) {
            currentIndex++;
            loadEvent(currentIndex);
        }
    }

    window.prevEvent = function () {
        if (currentIndex > 0) {
            currentIndex--;
            loadEvent(currentIndex);
        }
    }
});