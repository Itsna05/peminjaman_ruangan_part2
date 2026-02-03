document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('loanChart');

    if (!ctx) {
        console.error('Canvas loanChart tidak ditemukan');
        return;
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets: [
                {
                    label: 'Total Peminjaman',
                    data: [3, 5, 2, 6, 4, 7, 9, 6, 5, 4, 2, 3],
                    borderColor: '#15468A',
                    backgroundColor: 'rgba(37,99,235,0.15)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });
});
