document.addEventListener("DOMContentLoaded", function () {
    console.log("FILTER DROPDOWN + STATUS + WAKTU LOADED");

    // =========================
    // ELEMENT TABLE
    // =========================
    const rows = document.querySelectorAll("#tableBody tr");

    // =========================
    // DROPDOWN (GLOBAL)
    // =========================
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

    document.addEventListener("click", function () {
        closeAllDropdowns();
    });

    // =========================
    // FILTER STATE
    // =========================
    let selectedStatus = "";
    let selectedFrom = "";
    let selectedTo = "";

    // =========================
    // FILTER STATUS (✔ DENGAN CENTANG)
    // =========================
    const statusItems = document.querySelectorAll(".status-filter__item");

    statusItems.forEach((item) => {
        item.addEventListener("click", function () {
            // 🔥 HAPUS ACTIVE SEMUA
            statusItems.forEach((i) => i.classList.remove("is-active"));

            // 🔥 SET ACTIVE ITEM TERPILIH
            this.classList.add("is-active");

            selectedStatus = this.dataset.status || "";
            applyFilter();
            closeAllDropdowns();
        });
    });

    // =========================
    // FILTER WAKTU (TANPA CENTANG)
    // =========================
    const fromInput = document.getElementById("timeFilterFrom");
    const toInput = document.getElementById("timeFilterTo");
    const timeClear = document.getElementById("timeFilterClear");

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

    if (monthInput) {
        monthInput.addEventListener("change", function () {
            selectedMonth = this.value;
            applyFilter();
        });
    }

    if (yearInput) {
        yearInput.addEventListener("change", function () {
            selectedYear = this.value;
            applyFilter();
        });
    }

    if (timeClear) {
        timeClear.addEventListener("click", function () {
            selectedMonth = "";
            selectedYear = "";
            monthInput.value = "";
            yearInput.value = "";
            applyFilter();
        });
    }

    // =========================
    // APPLY FILTER (FINAL)
    // =========================
    function applyFilter() {
        rows.forEach((row) => {
            // STATUS
            const rowStatus = row.dataset.status || "";

            // WAKTU
            const dateCell = row.querySelector("[data-date]");
            const date = dateCell ? dateCell.dataset.date : "";

            const matchStatus = !selectedStatus || rowStatus === selectedStatus;
            const matchTime =
                (!selectedFrom || date >= selectedFrom) &&
                (!selectedTo || date <= selectedTo);

            row.style.display = matchStatus && matchTime ? "" : "none";
        });

        // =========================
        // UPDATE URL (EXPORT AMAN)
        // =========================
        const params = new URLSearchParams(window.location.search);

        if (selectedStatus) {
            params.set("status", selectedStatus);
        } else {
            params.delete("status");
        }

        if (selectedFrom) {
            params.set("from", selectedFrom);
        } else {
            params.delete("from");
        }

        if (selectedTo) {
            params.set("to", selectedTo);
        } else {
            params.delete("to");
        }

        const newUrl = window.location.pathname + "?" + params.toString();

        window.history.replaceState({}, "", newUrl);
    }
});
