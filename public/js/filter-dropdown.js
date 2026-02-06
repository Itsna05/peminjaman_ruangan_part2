document.addEventListener("DOMContentLoaded", function () {
    /* ======================
       DROPDOWN SYSTEM
    ====================== */

    const dropdownButtons = document.querySelectorAll("[data-dropdown-button]");

    const dropdownMenus = document.querySelectorAll("[data-dropdown-menu]");

    function closeAllDropdowns() {
        dropdownMenus.forEach((menu) => menu.classList.remove("is-open"));
    }

    dropdownButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const targetId = this.dataset.dropdownButton;

            const menu = document.getElementById(targetId);

            if (!menu) return;

            const isOpen = menu.classList.contains("is-open");

            closeAllDropdowns();

            if (!isOpen) {
                menu.classList.add("is-open");
            }
        });
    });

    dropdownMenus.forEach((menu) => {
        menu.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    });

    document.addEventListener("click", closeAllDropdowns);

    /* ======================
       FILTER STATE
    ====================== */

    let selectedStatus = "";
    let selectedMonth = "";
    let selectedYear = "";

    window.currentPage = 1;

    /* ======================
       STATUS FILTER
    ====================== */

    document.querySelectorAll(".status-filter__item").forEach((item) => {
        item.addEventListener("click", function () {
            document
                .querySelectorAll(".status-filter__item")
                .forEach((i) => i.classList.remove("is-active"));

            this.classList.add("is-active");

            selectedStatus = this.dataset.status || "";

            applyFilter();

            closeAllDropdowns();
        });
    });

    /* ======================
       TIME FILTER
    ====================== */

    const timeInput = document.getElementById("timeFilter");
    const timeClear = document.getElementById("timeFilterClear");

    let picker = null;

    // Init Flatpickr
    if (timeInput) {
        picker = flatpickr("#timeFilter", {
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "Y-m",
                    altFormat: "F Y",
                    altInput: true,
                }),
            ],

            onChange: function (selectedDates, dateStr) {
                if (dateStr) {
                    const parts = dateStr.split("-");

                    selectedYear = parts[0];
                    selectedMonth = parts[1];

                    applyFilter();
                }
            },
        });
    }

    // Reset
    timeClear?.addEventListener("click", function () {
        selectedMonth = "";
        selectedYear = "";

        if (picker) {
            picker.clear();
        }

        applyFilter();
        closeAllDropdowns();
    });

    /* ======================
       APPLY FILTER
    ====================== */

    function applyFilter() {
        const rows = document.querySelectorAll("#tableBody tr");

        rows.forEach((row) => {
            const status = row.dataset.status || "";

            const date = row.querySelector("[data-date]")?.dataset.date || "";

            const year = date.substring(0, 4);
            const month = date.substring(5, 7);

            const matchStatus = !selectedStatus || status === selectedStatus;

            const matchTime =
                (!selectedMonth || month === selectedMonth) &&
                (!selectedYear || year === selectedYear);

            row.classList.toggle("filtered-out", !(matchStatus && matchTime));
        });

        // reset page
        currentPage = 1;

        if (window.paginate) {
            window.paginate();
        }
    }

    /* ======================
   FIX POSITION DROPDOWN (FLOATING)
====================== */

    function positionDropdown(button, menu) {
        const rect = button.getBoundingClientRect();

        menu.style.position = "fixed";
        menu.style.top = rect.bottom + 8 + "px";
        menu.style.left = rect.left + "px";
        menu.style.zIndex = "99999";
    }

    dropdownButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const targetId = this.dataset.dropdownButton;
            const menu = document.getElementById(targetId);

            if (!menu) return;

            if (menu.classList.contains("is-open")) {
                positionDropdown(this, menu);
            }
        });
    });
});
