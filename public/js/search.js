document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchInput');
    const icon = document.querySelector('.search-box i');

    function doSearch() {
        const keyword = input.value.toLowerCase();

        // CONTOH: filter card / table / list
        document.querySelectorAll('.search-item').forEach(item => {
            const text = item.innerText.toLowerCase();
            item.style.display = text.includes(keyword) ? '' : 'none';
        });
    }

    
    input.addEventListener('input', doSearch);
    input.addEventListener('keyup', doSearch);
    icon.addEventListener('click', doSearch);
});
