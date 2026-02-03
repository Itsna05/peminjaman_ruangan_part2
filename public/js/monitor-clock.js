function updateClock() {
    const now = new Date();

    const time = now.toLocaleTimeString('id-ID', {
        hour12: false,
        timeZone: 'Asia/Jakarta'
    });

    const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        timeZone: 'Asia/Jakarta'
    });

    document.getElementById('clock').innerText = time;
    document.getElementById('date').innerText = date;
}

setInterval(updateClock, 1000);
updateClock();
