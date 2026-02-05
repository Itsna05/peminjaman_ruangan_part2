document.addEventListener("DOMContentLoaded", function () {
    console.log("FILTER + PAGINATION LOADED");

    /* =========================
       ELEMENT
    ========================= */
    const tableBody = document.getElementById("tableBody");
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const pagination = document.getElementById("pagination");

    const rows = Array.from(tableBody.querySelectorAll("tr"));

    const dropdownButtons = document.querySelectorAll("[data-dropdown-button]");
    const dropdownMenus = document.querySelectorAll("[data-dropdown-menu]");

    const statusItems = document.querySelectorAll(".status-filter__item");

    const fromInput = document.getElementById("timeFilterFrom");
    const toInput = document.getElementById("timeFilterTo");
    const timeClear = document.getElementById("timeFilterClear");

    /* =========================
       STATE
    ========================= */
    let selectedStatus = "";
    let selectedFrom = "";
    let selectedTo = "";

    window.currentPage = 1;
    window.filteredRows = [];

    /* =========================
       DROPDOWN
    ========================= */
    function closeAllDropdowns() {
        dropdownMenus.forEach((menu) => {
            menu.classList.remove("is-open");
        });
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
        menu.addEventListener("click", (e) => {
            e.stopPropagation();
        });
    });

    document.addEventListener("click", closeAllDropdowns);

    /* =========================
       FILTER STATUS
    ========================= */
    statusItems.forEach((item) => {
        item.addEventListener("click", function () {
            statusItems.forEach((i) => i.classList.remove("is-active"));

            this.classList.add("is-active");

            selectedStatus = this.dataset.status || "";

            applyFilter();

            closeAllDropdowns();
        });
    });

    /* =========================
       FILTER WAKTU
    ========================= */
    if (fromInput) {
        fromInput.addEventListener("change", function () {
            selectedFrom = this.value;
            applyFilter();
        });
    }

    if (toInput) {
        toInput.addEventListener("change", function () {
            selectedTo = this.value;
            applyFilter();
        });
    }

    if (timeClear) {
        timeClear.addEventListener("click", function () {
            selectedFrom = "";
            selectedTo = "";

            fromInput.value = "";
            toInput.value = "";

            applyFilter();
        });
    }

    /* =========================
       APPLY FILTER
    ========================= */
    function applyFilter() {
        window.filteredRows = [];

        rows.forEach((row) => {
            const rowStatus = row.dataset.status || "";

            const dateCell = row.querySelector("[data-date]");
            const date = dateCell ? dateCell.dataset.date : "";

            const matchStatus = !selectedStatus || rowStatus === selectedStatus;

            const matchTime =
                (!selectedFrom || date >= selectedFrom) &&
                (!selectedTo || date <= selectedTo);

            if (matchStatus && matchTime) {
                window.filteredRows.push(row);
            }
        });

        currentPage = 1;

        updateURL();

        if (typeof window.paginate === "function") {
            window.paginate();
        }
    }
});
