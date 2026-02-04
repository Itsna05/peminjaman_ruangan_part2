(function () {
    let attempts = 0;
    const maxAttempts = 50; // ~5 detik

    const waitForChart = setInterval(() => {
        attempts++;

        const canvas = document.getElementById('loanChart');

        if (
            typeof Chart !== 'undefined' &&
            canvas &&
            Array.isArray(window.dataBulanan)
        ) {
            clearInterval(waitForChart);

            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        'Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember'
                    ],
                    datasets: [{
                        label: 'Total Peminjaman',
                        data: window.dataBulanan,
                        borderColor: '#15468A',
                        backgroundColor: 'rgba(37,99,235,0.15)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            console.log('Chart berhasil dirender');
        }

        if (attempts >= maxAttempts) {
            clearInterval(waitForChart);
            console.warn('Chart gagal dirender: dependensi tidak lengkap');
        }
    }, 100);
})();
