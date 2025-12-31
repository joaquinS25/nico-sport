window.addEventListener('load', () => {

    const table = document.getElementById('datatablesSimple');
    if (!table) return;

    const dataTable = new simpleDatatables.DataTable(table);

    function calcularTotal() {
        let total = 0;

        table.querySelectorAll('tbody tr').forEach(tr => {

            if (tr.getAttribute('aria-hidden') !== 'true') {

                // columna PAGO
                let estadoPago = tr.cells[6].innerText.trim();

                if (estadoPago === 'Pagado') return;

                // columna PRECIO
                let textoPrecio = tr.cells[4].innerText;
                let precio = parseFloat(textoPrecio.replace(/[^0-9.-]/g, ''));

                if (!isNaN(precio)) total += precio;
            }
        });

        const totalEl = document.getElementById('totalFiltrado');
        if (totalEl) {
            totalEl.innerText = 'S/ ' + total.toFixed(2);
        }
    }

    // ✅ eventos PROPIOS del DataTable
    dataTable.on('datatable.page', calcularTotal);
    dataTable.on('datatable.search', calcularTotal);
    dataTable.on('datatable.sort', calcularTotal);

    // 📱 respaldo móvil (teclado / autocompletado)
    document.addEventListener('keyup', () => {
        setTimeout(calcularTotal, 150);
    });

    // 🧠 fuerza recálculo al cargar (hosting lento)
    let intentos = 0;
    const intervalo = setInterval(() => {
        calcularTotal();
        intentos++;

        if (intentos > 10) clearInterval(intervalo);
    }, 300);
});
