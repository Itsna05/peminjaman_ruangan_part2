document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.unduh-btn');
    const dropdown = document.querySelector('.unduh-dropdown');

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', () => {
        dropdown.classList.remove('show');
    });
});