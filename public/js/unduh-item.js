document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.querySelector('.unduh-stack');
    const dropdown = document.querySelector('.unduh-dropdown');

    // ❗ Jika elemen tidak ada di halaman ini → STOP
    if (!toggle || !dropdown) return;

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', function () {
        dropdown.classList.remove('show');
    });

});
