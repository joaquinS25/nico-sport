window.addEventListener('DOMContentLoaded', () => {

    const table = document.getElementById('datatablesSimple');
    if (!table) return;

    const dataTable = new simpleDatatables.DataTable(table);

    function calcularTotal() {
        let total = 0;

        // 🔥 recorrer TODAS las filas
        table.querySelectorAll('tbody tr').forEach(tr => {

            // Simple-DataTables marca visibles con este atributo
            if (tr.getAttribute('aria-hidden') !== 'true') {

                let texto = tr.cells[4].textContent;

                let precio = parseFloat(
                    texto.replace(/[^0-9.-]/g, '')
                );

                if (!isNaN(precio)) total += precio;
            }
        });

        document.getElementById('totalFiltrado').innerText =
            'S/ ' + total.toFixed(2);
    }

    // 🔍 buscar (PC + móvil)
    document.addEventListener('input', () => {
        setTimeout(calcularTotal, 150);
    });

    // ▶ carga inicial
    setTimeout(calcularTotal, 400);
});
