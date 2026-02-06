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