document.addEventListener("DOMContentLoaded", function () {
    /* ======================
       DROPDOWN SYSTEM
    ====================== */

    const dropdownButtons = document.querySelectorAll("[data-dropdown-button]");

    const dropdownMenus = document.querySelectorAll("[data-dropdown-menu]");

    const filterMode = document.getElementById("filterMode");

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
    let isYearOnly = false;

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
            updateDownloadLinks();
        });
    });

    /* ======================
       TIME FILTER
    ====================== */

    const timeInput = document.getElementById("timeFilter");
    const timeClear = document.getElementById("timeFilterClear");

    let picker = null;

    if (timeInput) {
        picker = flatpickr(timeInput, {
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "Y-m",
                    altFormat: "F Y",
                    altInput: true,
                }),
            ],

            clickOpens: true,

            onChange: function (selectedDates, dateStr) {
                if (!dateStr) return;

                const parts = dateStr.split("-");
                selectedYear = parts[0];
                selectedMonth = parts[1];
                isYearOnly = false;

                applyFilter();
                updateDownloadLinks();
            },

            onYearChange: function (selectedDates, dateStr, instance) {
                selectedYear = instance.currentYear.toString();
                selectedMonth = "";
                isYearOnly = true;

                timeInput.value = selectedYear;

                applyFilter();
                updateDownloadLinks();
            },
        });
    }


    // === SET NILAI DARI URL SAAT PAGE LOAD ===
    const urlParams = new URLSearchParams(window.location.search);

    const urlYear = urlParams.get("tahun");
    const urlMonth = urlParams.get("bulan");

    if (urlYear && urlMonth) {
        // mode bulan + tahun
        const dateStr = urlYear + "-" + urlMonth + "-01";

        picker.setDate(dateStr, true);

        selectedYear = urlYear;
        selectedMonth = urlMonth;
    } else if (urlYear) {
        // mode tahun saja
        picker.setDate(urlYear + "-01-01", true);

        selectedYear = urlYear;
        selectedMonth = "";
    }

    // Reset
    timeClear?.addEventListener("click", function () {
        selectedMonth = "";
        selectedYear = "";
        isYearOnly = false;

        if (picker) {
            picker.clear();
        }

        applyFilter();
        closeAllDropdowns();
        updateDownloadLinks();
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

            let matchTime = true;

            // Mode: filter per tahun
            if (isYearOnly && selectedYear) {
                matchTime = year === selectedYear;
            }

            // Mode: filter per bulan
            if (!isYearOnly && selectedYear && selectedMonth) {
                matchTime = year === selectedYear && month === selectedMonth;
            }

            row.classList.toggle("filtered-out", !(matchStatus && matchTime));
        });

        // reset page
        currentPage = 1;

        if (window.paginate) {
            window.paginate();
        }

        updateBrowserUrl();
    }

    function updateBrowserUrl() {
        const params = new URLSearchParams();

        if (selectedStatus) params.set("status", selectedStatus);
        if (selectedMonth) params.set("bulan", selectedMonth);
        if (selectedYear) params.set("tahun", selectedYear);

        const newUrl =
            window.location.pathname +
            (params.toString() ? "?" + params.toString() : "");

        window.history.replaceState({}, "", newUrl);
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

    function updateDownloadLinks() {
        const pdfBtn = document.getElementById("downloadPdf");
        const excelBtn = document.getElementById("downloadExcel");

        if (!pdfBtn || !excelBtn) return;

        // AMBIL LANGSUNG DARI URL BROWSER
        const params = new URLSearchParams(window.location.search);

        const query = params.toString();

        pdfBtn.href = window.exportPdfUrl + (query ? "?" + query : "");

        excelBtn.href = window.exportExcelUrl + (query ? "?" + query : "");
    }
    updateDownloadLinks();
});
