document.addEventListener('DOMContentLoaded', function () {
    // Автоматический расчёт стоимости проживания.
    const form = document.getElementById('booking-form');
    if (form) {
        const price = Number(form.dataset.price || 0);
        const from = document.getElementById('check_in');
        const to = document.getElementById('check_out');
        const nightsOutput = document.getElementById('nights-value');
        const totalOutput = document.getElementById('total-value');
        const formatter = new Intl.NumberFormat('ru-RU');
        function updatePrice() {
            if (!from.value || !to.value) return;
            const start = new Date(from.value + 'T00:00:00');
            const end = new Date(to.value + 'T00:00:00');
            const nights = Math.round((end - start) / 86400000);
            if (nights > 0) {
                nightsOutput.textContent = nights;
                totalOutput.textContent = formatter.format(nights * price) + ' ₽';
            } else {
                nightsOutput.textContent = '—';
                totalOutput.textContent = '0 ₽';
            }
        }
        from.addEventListener('change', function () {
            if (from.value) {
                const next = new Date(from.value + 'T00:00:00');
                next.setDate(next.getDate() + 1);
                const year = next.getFullYear();
                const month = String(next.getMonth() + 1).padStart(2, '0');
                const day = String(next.getDate()).padStart(2, '0');
                to.min = year + '-' + month + '-' + day;
            }
            updatePrice();
        });
        to.addEventListener('change', updatePrice);
        updatePrice();
    }
});
