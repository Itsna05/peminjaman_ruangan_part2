document.addEventListener('DOMContentLoaded', function () {

    let eventsInDay = [];
    let currentIndex = 0;
    let startX = 0;
    let isOpening = false; // 🔒 guard biar nggak double trigger

    const modalEl = document.getElementById('modalDetailPeminjaman');
    const modalContent = document.getElementById('modalDetailContent');
    const counterEl = document.getElementById('eventCounter');
    const prevBtn = document.getElementById('prevEvent');
    const nextBtn = document.getElementById('nextEvent');

    // ✅ SATU INSTANCE MODAL SAJA
    const modalInstance = new bootstrap.Modal(modalEl);

    function renderEvent(index) {
        const data = eventsInDay[index];
        if (!data) return;

        const statusLabel =
            data.status_peminjaman === 'disetujui'
                ? 'Disetujui'
                : 'Menunggu Persetujuan';

        modalContent.innerHTML = `
            <p><strong>Nama Acara</strong><br>${data.acara}</p>
            <p><strong>Status</strong><br>${statusLabel}</p>
            <p><strong>Jumlah Peserta</strong><br>${data.jumlah_peserta} orang</p>
            <p><strong>Waktu</strong><br>
                ${data.waktu_mulai.substring(11,16)} -
                ${data.waktu_selesai.substring(11,16)}
            </p>
            <p><strong>Bidang</strong><br>${data.bidang?.bidang ?? '-'}</p>
            <p><strong>Sub Bidang</strong><br>${data.bidang?.sub_bidang ?? '-'}</p>
            <p><strong>Ruangan</strong><br>${data.ruangan?.nama_ruangan ?? '-'}</p>
            <p><strong>Catatan</strong><br>${data.catatan ?? '-'}</p>
        `;

        counterEl.textContent = `${index + 1} / ${eventsInDay.length}`;
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === eventsInDay.length - 1;
    }

    function openModal(events, startIndex = 0) {
        eventsInDay = events;
        currentIndex = startIndex;
        renderEvent(currentIndex);

        modalInstance.show();
    }

    // ===============================
    // KLIK EVENT KALENDER (FIXED)
    // ===============================
    document.body.addEventListener('click', function (e) {
        const eventBox = e.target.closest('.event-clickable');
        if (!eventBox) return;

        // 🔒 cegah trigger dobel
        if (isOpening) return;
        isOpening = true;

        e.preventDefault();
        e.stopPropagation();

        const date = eventBox.dataset.date;
        if (!date) {
            isOpening = false;
            return;
        }

        const requests = [];

        document
            .querySelectorAll(`.event-clickable[data-date="${date}"]`)
            .forEach(el => {
                const id = el.dataset.id;
                requests.push(
                    fetch(`/petugas/transaksi/${id}`).then(r => r.json())
                );
            });

        Promise.all(requests).then(results => {
            openModal(results, 0);
        }).finally(() => {
            // buka kunci setelah modal muncul
            setTimeout(() => {
                isOpening = false;
            }, 300);
        });
    });

    // ===============================
    // BUTTON NAV
    // ===============================
    prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentIndex > 0) {
            currentIndex--;
            renderEvent(currentIndex);
        }
    });

    nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentIndex < eventsInDay.length - 1) {
            currentIndex++;
            renderEvent(currentIndex);
        }
    });

    // ===============================
    // SWIPE SUPPORT (STABLE)
    // ===============================
    modalContent.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
    });

    modalContent.addEventListener('touchend', e => {
        const diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            if (diff > 0 && currentIndex < eventsInDay.length - 1) currentIndex++;
            if (diff < 0 && currentIndex > 0) currentIndex--;
            renderEvent(currentIndex);
        }
    });

});
