<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Salida de Mercaderia de la tienda</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Salida de Mercaderia
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha Registro</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha Registro</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($salida as $key => $value) 
                        {
                            $n++;
                            ?>
                            <tr
                             data-id-cliente="<?= htmlspecialchars($value['id_cliente'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                             data-celular="<?= htmlspecialchars($value['cel_cliente'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                             data-total-pagado="<?= htmlspecialchars($value['total_pagado'] ?? '0', ENT_QUOTES, 'UTF-8') ?>"
                            >
                                <td><?= $n ?></td>
                                <td><?= $value['nom_cliente'] ?></td>
                                <td><?= $value['cel_cliente'] ?></td>
                                <td><?= $value['cantidad'] ?></td>
                                <td><?= $value['producto'] ?></td>
                                <td><?= $value['precio'] ?></td>
                                <td><?= $value['fecha_registro'] ?></td>
                                <!-- COLUMNA PAGO -->
                                <td>

                                    <?php
                                        $total_pagado = floatval($value['total_pagado']);
                                    ?>

                                    <?php if ($total_pagado > 0): ?>

                                        <span class="badge bg-success">
                                            Pagó S/ <?= number_format($total_pagado, 2) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-warning">
                                            Sin pagos
                                        </span>

                                    <?php endif; ?>

                                </td>
                                <!-- BOTÓN -->
                                <td>
                                    <?php if ($value['pago'] == 'NO'): ?>
                                        <button 
                                            type="button"
                                            class="btn btn-success btn-sm btn-pagar"

                                            data-id="<?= htmlspecialchars($value['id_salida'] ?? '') ?>"

                                            data-id-cliente="<?= htmlspecialchars($value['id_cliente'] ?? '') ?>"

                                            data-nombre="<?= htmlspecialchars($value['nom_cliente'] ?? '') ?>"

                                            data-precio="<?= htmlspecialchars($value['precio'] ?? '0') ?>"

                                            data-total-pagado="<?= htmlspecialchars($value['total_pagado'] ?? '0') ?>"

                                        >
                                            Pagar
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Pagado
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php 
                        }
                    ?>
                </tbody>
            </table>
           <div class="text-end mt-3">
                
                <button type="button" id="btnRegistrarPago" class="btn btn-warning ms-2">
                    <i class="fas fa-money-bill-wave"></i>
                    Registrar pago
                </button>
                <button type="button" id="btnWhatsApp" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i>
                    Enviar por WhatsApp
                </button>

                <button type="button" id="btnGenerarImagen" class="btn btn-primary ms-2">
                    <i class="fas fa-image"></i>
                    Generar imagen
                </button>

            </div>                               
            <!-- 🔹 TOTAL DE SALIDA DE MERCADERÍA -->
            <!--h3 class="text-end mt-3" id="totalFiltrado">
                Total: 
                <b style="color:blue;">S/
                    <?php  
                        $total_salida = 0;
                        foreach ($salida as $item) {
                            $total_salida += floatval($item['precio']);
                        }
                        echo number_format($total_salida, 2);
                    ?>
                </b>
            </h3-->
            <!--h3 class="text-end mt-3">
                Total: 
                <b style="color:blue;">
                    <span id="totalFiltrado">S/ 0.00</span>
                </b>
            </h3-->

        </div>
    </div>
</div>
<!-- =====================================================
     MODAL REGISTRAR PAGO
===================================================== -->

<div class="modal fade" id="modalRegistrarPago" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Registrar pago
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <form id="formRegistrarPago">

                    <input
                        type="hidden"
                        id="id_cliente_pago"
                        name="id_cliente"
                    >
                    <input
                        type="hidden"
                        id="id_salida_pago"
                        name="id_salida"
                    >                            

                    <div class="mb-3">

                        <label class="form-label">
                            Cliente
                        </label>

                        <input
                            type="text"
                            id="nombre_cliente_pago"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Monto a pagar
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                S/
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                id="monto_pago"
                                name="monto"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Fecha del pago
                        </label>

                        <input
                            type="date"
                            id="fecha_pago"
                            name="fecha_pago"
                            class="form-control"
                            required
                        >

                    </div>


                    <div
                        id="informacionDeuda"
                        class="alert alert-info"
                    >
                        Seleccione un cliente.
                    </div>


                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >

                        <i class="fas fa-save"></i>

                        Registrar pago

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
document.addEventListener('DOMContentLoaded', function () {

    // Buscar el buscador de DataTables
    const searchInput =
        document.querySelector('.dataTable-input') ||
        document.querySelector('#datatablesSimple_wrapper input[type="search"]') ||
        document.querySelector('input[type="search"]');

    if (!searchInput) {
        console.log('No se encontró el buscador de DataTables');
        return;
    }


    // =====================================================
    // FUNCIÓN PARA ACTUALIZAR EL TOTAL
    // =====================================================

    function actualizarTotal() {

        let total = 0;

        // Obtener filas actualmente visibles
        const filas = Array.from(
            document.querySelectorAll('#datatablesSimple tbody tr')
        );


        filas.forEach(function (fila) {

            const celdas =
                fila.querySelectorAll('td');


            // Verificar que sea una fila válida
            if (celdas.length < 9) {
                return;
            }


            // Columna Pago
            const pago =
                celdas[7].innerText
                    .trim()
                    .toLowerCase();


            // Solo sumar pendientes
            if (pago.includes('pendiente')) {

                // Columna Precio
                let precioTexto =
                    celdas[5].innerText
                        .replace('S/', '')
                        .replace(',', '')
                        .trim();


                let precio =
                    parseFloat(precioTexto) || 0;


                total += precio;

            }

        });


        // Mostrar total
        document.getElementById('totalFiltrado').innerText =
            'S/ ' + total.toFixed(2);

    }


    // =====================================================
    // ACTUALIZAR CUANDO SE ESCRIBE
    // =====================================================

    searchInput.addEventListener('input', function () {

        // Dar tiempo a DataTables para actualizar la tabla
        setTimeout(function () {

            actualizarTotal();

        }, 100);

    });


    // =====================================================
    // TOTAL INICIAL
    // =====================================================

    setTimeout(function () {

        actualizarTotal();

    }, 300);

});
document.getElementById('btnWhatsApp').addEventListener('click', function () {

    // =====================================================
    // BUSCAR EL CAMPO DE BÚSQUEDA DE DATATABLES
    // =====================================================

    let searchInput =
        document.querySelector('.dataTable-input') ||
        document.querySelector('#datatablesSimple_wrapper input[type="search"]') ||
        document.querySelector('input[type="search"]');


    // =====================================================
    // OBTENER TEXTO ESCRITO EN EL BUSCADOR
    // =====================================================

    let nombreBuscado = '';

    if (searchInput) {
        nombreBuscado = searchInput.value.trim().toLowerCase();
    }


    // =====================================================
    // OBTENER TODAS LAS FILAS
    // =====================================================

    const todasLasFilas = Array.from(
        document.querySelectorAll('#datatablesSimple tbody tr')
    );


    // =====================================================
    // QUITAR FILAS VACÍAS
    // =====================================================

    const filas = todasLasFilas.filter(function(fila) {

        const celdas = fila.querySelectorAll('td');

        return celdas.length >= 9;

    });


    // =====================================================
    // SI NO ESCRIBIÓ NADA
    // =====================================================

    if (!nombreBuscado) {

        Swal.fire({
            icon: 'warning',
            title: 'Seleccione un cliente',
            text: 'Primero escriba el nombre del cliente en el buscador.',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // BUSCAR LAS FILAS DEL CLIENTE
    // =====================================================

    const filasCliente = filas.filter(function(fila) {

        const celdas = fila.querySelectorAll('td');

        // Columna Nombre
        const nombre =
            celdas[1].innerText.trim().toLowerCase();

        return nombre.includes(nombreBuscado);

    });


    // =====================================================
    // VERIFICAR SI ENCONTRÓ EL CLIENTE
    // =====================================================

    if (filasCliente.length === 0) {

        Swal.fire({
            icon: 'warning',
            title: 'Cliente no encontrado',
            text: 'No se encontraron registros para: ' + nombreBuscado,
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // OBTENER DATOS DEL CLIENTE
    // =====================================================

    const primeraFila = filasCliente[0];

    const celdas =
        primeraFila.querySelectorAll('td');


    // Nombre
    const nombreCliente =
        celdas[1].innerText.trim();


    // Celular
    let celular =
        primeraFila.getAttribute('data-celular');


    // Si no existe data-celular, tomar columna celular
    if (!celular || celular.trim() === '') {

        celular =
            celdas[2].innerText.trim();

    }


    console.log('==========================');
    console.log('CLIENTE:', nombreCliente);
    console.log('CELULAR:', celular);
    console.log('FILAS:', filasCliente.length);
    console.log('==========================');


    // =====================================================
    // VALIDAR CELULAR
    // =====================================================

    if (!celular || celular.trim() === '') {

        Swal.fire({
            icon: 'error',
            title: 'Sin número de celular',
            text: 'El cliente ' + nombreCliente +
                  ' no tiene un número de celular registrado.',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // CREAR CAPTURA
    // =====================================================

    const captura =
        document.createElement('div');


    captura.style.position = 'absolute';
    captura.style.left = '-99999px';
    captura.style.top = '0';
    captura.style.width = '700px';
    captura.style.background = '#ffffff';
    captura.style.padding = '30px';
    captura.style.fontFamily = 'Arial, sans-serif';
    captura.style.boxSizing = 'border-box';


    let total = 0;

    let filasHTML = '';


    // =====================================================
    // RECORRER LAS DEUDAS DEL CLIENTE
    // =====================================================

    


    // =====================================================
    // OBTENER TOTAL PAGADO DESDE EL BOTÓN
    // =====================================================

    const botonPago =
        primeraFila.querySelector('.btn-pagar');

    let totalPagado = 0;

    if (botonPago) {

        totalPagado =
            parseFloat(
                botonPago.getAttribute('data-total-pagado') || '0'
            );

    }


    // =====================================================
    // SUMAR TODAS LAS SALIDAS DEL CLIENTE
    // =====================================================

    filasCliente.forEach(function(fila) {

        const celdas =
            fila.querySelectorAll('td');

        const cantidad =
            celdas[3].innerText.trim();

        const producto =
            celdas[4].innerText.trim();

        const precioTexto =
            celdas[5].innerText
                .replace('S/', '')
                .replace(',', '')
                .trim();

        const precio =
            parseFloat(precioTexto) || 0;

        const fecha =
            celdas[6].innerText.trim();


        // Sumar el precio completo
        total += precio;


        // Agregar el producto a la imagen
        filasHTML += `

            <tr>

                <td style="
                    padding:10px;
                    border-bottom:1px solid #ddd;
                ">
                    ${producto}
                </td>

                <td style="
                    padding:10px;
                    border-bottom:1px solid #ddd;
                    text-align:center;
                ">
                    ${cantidad}
                </td>

                <td style="
                    padding:10px;
                    border-bottom:1px solid #ddd;
                    text-align:right;
                ">
                    S/ ${precio.toFixed(2)}
                </td>

                <td style="
                    padding:10px;
                    border-bottom:1px solid #ddd;
                    text-align:center;
                ">
                    ${fecha}
                </td>

            </tr>

        `;

    });


    // =====================================================
    // CALCULAR SALDO REAL
    // =====================================================

    const saldoPendiente =
        Math.max(total - totalPagado, 0);


        console.log('==============================');
        console.log('TOTAL SALIDAS:', total);
        console.log('TOTAL PAGADO:', totalPagado);
        console.log('SALDO PENDIENTE:', saldoPendiente);
        console.log('==============================');


        // =====================================================
        // VERIFICAR SI TIENE DEUDA
        // =====================================================

    if (saldoPendiente <= 0) {

        Swal.fire({

            icon: 'info',

            title: 'Sin deuda pendiente',

            text:
                nombreCliente +
                ' no tiene pagos pendientes.',

            confirmButtonText: 'Aceptar'

        });

        return;
    }




    // =====================================================
    // DISEÑO DE LA CAPTURA
    // =====================================================

    captura.innerHTML = `

        <div style="
            border:2px solid #ddd;
            border-radius:15px;
            padding:30px;
            background:white;
        ">

            <div style="
                text-align:center;
                margin-bottom:25px;
            ">

                <h1 style="
                    margin:0;
                    font-size:32px;
                    color:#222;
                ">
                    NICO SPORT
                </h1>

                <p style="
                    margin:8px 0;
                    font-size:16px;
                    color:#555;
                ">
                    Equipamiento Deportivo de Alto Rendimiento
                </p>

                <h2 style="
                    margin:15px 0 0;
                    font-size:22px;
                ">
                    NOTA DE VENTA
                </h2>

            </div>


            <div style="
                background:#f5f5f5;
                padding:18px;
                border-radius:10px;
                margin-bottom:25px;
                font-size:17px;
                line-height:1.8;
            ">

                <strong>Cliente:</strong>
                ${nombreCliente}

                <br>

                <strong>Celular:</strong>
                ${celular}

            </div>


            <table style="
                width:100%;
                border-collapse:collapse;
                font-size:15px;
            ">

                <thead>

                    <tr style="
                        background:#eeeeee;
                    ">

                        <th style="padding:12px;text-align:left;">
                            Producto
                        </th>

                        <th style="padding:12px;text-align:center;">
                            Cantidad
                        </th>

                        <th style="padding:12px;text-align:right;">
                            Precio
                        </th>

                        <th style="padding:12px;text-align:center;">
                            Fecha
                        </th>

                    </tr>

                </thead>

                <tbody>

                    ${filasHTML}

                </tbody>

            </table>


            <div style="
                margin-top:30px;
                padding:18px;
                background:#f5f5f5;
                border-radius:10px;
            ">

                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                    <strong>Total de deuda:</strong>
                    <span>S/ ${total.toFixed(2)}</span>
                </div>

                <div style="display:flex;justify-content:space-between;margin-bottom:15px;color:#198754;">
                    <strong>Total pagado:</strong>
                    <span>S/ ${totalPagado.toFixed(2)}</span>
                </div>

                <hr>

                <div style="display:flex;justify-content:space-between;
                            font-size:28px;
                            font-weight:bold;
                            color:#e53935;">

                    <span>SALDO PENDIENTE:</span>

                    <span>S/ ${saldoPendiente.toFixed(2)}</span>

                </div>

            </div>


            <div style="
                text-align:center;
                margin-top:25px;
                color:#666;
                font-size:14px;
            ">

                Gracias por su preferencia

                <br>

                NICO SPORT

            </div>

        </div>

    `;


    document.body.appendChild(captura);


    // =====================================================
    // GENERAR IMAGEN
    // =====================================================

    html2canvas(captura, {

        scale: 2,

        backgroundColor: '#ffffff',

        useCORS: true

    }).then(function(canvas) {

        document.body.removeChild(captura);


        canvas.toBlob(function(blob) {

            if (!blob) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo generar la captura.',
                    confirmButtonText: 'Aceptar'
                });

                return;
            }


            // =================================================
            // DESCARGAR IMAGEN
            // =================================================

            const url =
                URL.createObjectURL(blob);


            const enlace =
                document.createElement('a');


            enlace.href = url;

            enlace.download =
                'deuda_' +
                nombreCliente +
                '.png';


            document.body.appendChild(enlace);

            enlace.click();

            document.body.removeChild(enlace);


            // =================================================
            // PREPARAR NÚMERO DE WHATSAPP
            // =================================================

            let numero =
                celular.replace(/\D/g, '');


            // Perú
            if (
                numero.length === 9 &&
                numero.startsWith('9')
            ) {

                numero = '51' + numero;

            }


            // =================================================
            // ABRIR WHATSAPP
            // =================================================

            const mensaje =
                'Hola ' +
                nombreCliente +
                ', le enviamos el detalle de su deuda pendiente de NICO SPORT.';


            const whatsappURL =
                'https://wa.me/' +
                numero +
                '?text=' +
                encodeURIComponent(mensaje);


            window.open(
                whatsappURL,
                '_blank'
            );


            // =================================================
            // MENSAJE
            // =================================================

            Swal.fire({

                icon: 'success',

                title: '¡Listo!',

                html:
                    'Se generó la captura de <b>' +
                    nombreCliente +
                    '</b>.<br><br>' +

                    'WhatsApp se abrió para el número:<br>' +

                    '<b>' +
                    celular +
                    '</b><br><br>' +

                    'Adjunta la imagen descargada en la conversación.',

                confirmButtonText: 'Aceptar'

            });


            setTimeout(function() {

                URL.revokeObjectURL(url);

            }, 2000);


        }, 'image/png');


    }).catch(function(error) {

        console.error(error);


        if (document.body.contains(captura)) {

            document.body.removeChild(captura);

        }


        Swal.fire({

            icon: 'error',

            title: 'Error',

            text: 'Ocurrió un error al generar la captura.',

            confirmButtonText: 'Aceptar'

        });

    });

});
// =====================================================
// GENERAR IMAGEN - VERSIÓN CORREGIDA
// =====================================================

document.addEventListener('click', function (e) {

    // Verificar si se presionó el botón
    const boton = e.target.closest('#btnGenerarImagen');

    if (!boton) {
        return;
    }

    console.log('=================================');
    console.log('BOTÓN GENERAR IMAGEN PRESIONADO');
    console.log('=================================');


    // =====================================================
    // BUSCADOR DATATABLES
    // =====================================================

    const searchInput =
        document.querySelector('.dataTable-input') ||
        document.querySelector('#datatablesSimple_wrapper input[type="search"]') ||
        document.querySelector('input[type="search"]');


    if (!searchInput) {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se encontró el buscador de la tabla.'
        });

        console.error('No se encontró el buscador de DataTables');

        return;
    }


    // =====================================================
    // NOMBRE BUSCADO
    // =====================================================

    const nombreBuscado =
        searchInput.value.trim().toLowerCase();


    console.log('CLIENTE BUSCADO:', nombreBuscado);


    // =====================================================
    // VALIDAR CLIENTE
    // =====================================================

    if (!nombreBuscado) {

        Swal.fire({
            icon: 'warning',
            title: 'Seleccione un cliente',
            text: 'Primero escriba el nombre del cliente en el buscador.',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // OBTENER FILAS
    // =====================================================

    const todasLasFilas =
        Array.from(
            document.querySelectorAll(
                '#datatablesSimple tbody tr'
            )
        );


    const filas =
        todasLasFilas.filter(function (fila) {

            return fila.querySelectorAll('td').length >= 9;

        });


    // =====================================================
    // FILTRAR CLIENTE
    // =====================================================

    const filasCliente =
        filas.filter(function (fila) {

            const celdas =
                fila.querySelectorAll('td');


            const nombre =
                celdas[1]
                    .innerText
                    .trim()
                    .toLowerCase();


            return nombre.includes(nombreBuscado);

        });


    // =====================================================
    // VALIDAR RESULTADO
    // =====================================================

    if (filasCliente.length === 0) {

        Swal.fire({
            icon: 'warning',
            title: 'Cliente no encontrado',
            text: 'No se encontraron registros para ese cliente.',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // DATOS DEL CLIENTE
    // =====================================================

    const primeraFila =
        filasCliente[0];


    const celdasPrimeraFila =
        primeraFila.querySelectorAll('td');


    const nombreCliente =
        celdasPrimeraFila[1]
            .innerText
            .trim();


    let celular =
        primeraFila.dataset.celular || '';


    if (!celular.trim()) {

        celular =
            celdasPrimeraFila[2]
                .innerText
                .trim();

    }


    // =====================================================
    // TOTAL DE LA DEUDA
    // =====================================================

    let totalDeuda = 0;

    let filasHTML = '';


    filasCliente.forEach(function (fila) {

        const celdas =
            fila.querySelectorAll('td');


        const cantidad =
            celdas[3]
                .innerText
                .trim();


        const producto =
            celdas[4]
                .innerText
                .trim();


        const precioTexto =
            celdas[5]
                .innerText
                .replace('S/', '')
                .replace(/,/g, '')
                .trim();


        const precio =
            parseFloat(precioTexto) || 0;


        const fecha =
            celdas[6]
                .innerText
                .trim();


        // Sumar todas las ventas
        totalDeuda += precio;


        // Agregar producto
        filasHTML += `

            <tr>

                <td style="
                    padding:12px;
                    border-bottom:1px solid #ddd;
                ">
                    ${producto}
                </td>

                <td style="
                    padding:12px;
                    border-bottom:1px solid #ddd;
                    text-align:center;
                ">
                    ${cantidad}
                </td>

                <td style="
                    padding:12px;
                    border-bottom:1px solid #ddd;
                    text-align:right;
                ">
                    S/ ${precio.toFixed(2)}
                </td>

                <td style="
                    padding:12px;
                    border-bottom:1px solid #ddd;
                    text-align:center;
                ">
                    ${fecha}
                </td>

            </tr>

        `;

    });


    // =====================================================
    // TOTAL PAGADO DEL CLIENTE
    // =====================================================

    let totalPagado = 0;

    filasCliente.forEach(function(fila) {

        const valorPagado = parseFloat(
            fila.getAttribute('data-total-pagado') || '0'
        );

        if (!isNaN(valorPagado) && valorPagado > totalPagado) {
            totalPagado = valorPagado;
        }

    });

console.log("TOTAL PAGADO ENCONTRADO:", totalPagado);


    // =====================================================
    // SALDO PENDIENTE
    // =====================================================

    let saldoPendiente =
        totalDeuda - totalPagado;


    // Evitar negativos
    if (saldoPendiente < 0) {
        saldoPendiente = 0;
    }


    // Redondear
    totalDeuda =
        Number(totalDeuda.toFixed(2));

    totalPagado =
        Number(totalPagado.toFixed(2));

    saldoPendiente =
        Number(saldoPendiente.toFixed(2));


    console.log('=================================');
    console.log('CLIENTE:', nombreCliente);
    console.log('TOTAL DEUDA:', totalDeuda);
    console.log('TOTAL PAGADO:', totalPagado);
    console.log('SALDO PENDIENTE:', saldoPendiente);
    console.log('=================================');


    // =====================================================
    // VERIFICAR DEUDA
    // =====================================================

    if (saldoPendiente <= 0) {

        Swal.fire({
            icon: 'info',
            title: 'Sin deuda pendiente',
            html:
                '<b>' + nombreCliente + '</b><br><br>' +

                'Total de deuda: <b>S/ ' +
                totalDeuda.toFixed(2) +
                '</b><br>' +

                'Total pagado: <b>S/ ' +
                totalPagado.toFixed(2) +
                '</b>',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // CREAR CAPTURA
    // =====================================================

    const captura =
        document.createElement('div');


    captura.style.position = 'absolute';
    captura.style.left = '-99999px';
    captura.style.top = '0';
    captura.style.width = '700px';
    captura.style.background = '#ffffff';
    captura.style.padding = '30px';
    captura.style.fontFamily = 'Arial, sans-serif';
    captura.style.boxSizing = 'border-box';


    captura.innerHTML = `

        <div style="
            border:2px solid #ddd;
            border-radius:15px;
            padding:30px;
            background:white;
        ">

            <!-- ENCABEZADO -->

            <div style="
                text-align:center;
                margin-bottom:25px;
            ">

                <h1 style="
                    margin:0;
                    font-size:32px;
                    color:#222;
                ">
                    NICO SPORT
                </h1>

                <p style="
                    margin:8px 0;
                    font-size:16px;
                    color:#555;
                ">
                    Equipamiento Deportivo de Alto Rendimiento
                </p>

                <h2 style="
                    margin:15px 0 0;
                    font-size:22px;
                ">
                    ESTADO DE CUENTA
                </h2>

            </div>


            <!-- CLIENTE -->

            <div style="
                background:#f5f5f5;
                padding:18px;
                border-radius:10px;
                margin-bottom:25px;
                font-size:17px;
                line-height:1.8;
            ">

                <strong>Cliente:</strong>
                ${nombreCliente}

                <br>

                <strong>Celular:</strong>
                ${celular}

            </div>


            <!-- TABLA -->

            <table style="
                width:100%;
                border-collapse:collapse;
                font-size:15px;
            ">

                <thead>

                    <tr style="
                        background:#eeeeee;
                    ">

                        <th style="
                            padding:12px;
                            text-align:left;
                        ">
                            Producto
                        </th>

                        <th style="
                            padding:12px;
                            text-align:center;
                        ">
                            Cantidad
                        </th>

                        <th style="
                            padding:12px;
                            text-align:right;
                        ">
                            Precio
                        </th>

                        <th style="
                            padding:12px;
                            text-align:center;
                        ">
                            Fecha
                        </th>

                    </tr>

                </thead>


                <tbody>

                    ${filasHTML}

                </tbody>

            </table>


            <!-- RESUMEN -->

            <div style="
                margin-top:30px;
                padding:20px;
                background:#f5f5f5;
                border-radius:10px;
            ">

                <div style="
                    text-align:right;
                    font-size:17px;
                    margin-bottom:8px;
                ">

                    <strong>
                        Total de deuda:
                    </strong>

                    S/ ${totalDeuda.toFixed(2)}

                </div>


                <div style="
                    text-align:right;
                    font-size:17px;
                    margin-bottom:8px;
                    color:#198754;
                ">

                    <strong>
                        Total pagado:
                    </strong>

                    S/ ${totalPagado.toFixed(2)}

                </div>


                <div style="
                    border-top:2px solid #ccc;
                    margin-top:10px;
                    padding-top:12px;
                    text-align:right;
                ">

                    <span style="
                        font-size:20px;
                        font-weight:bold;
                    ">
                        SALDO PENDIENTE:
                    </span>

                    <span style="
                        margin-left:10px;
                        font-size:30px;
                        font-weight:bold;
                        color:#dc3545;
                    ">
                        S/ ${saldoPendiente.toFixed(2)}
                    </span>

                </div>

            </div>


            <!-- PIE -->

            <div style="
                text-align:center;
                margin-top:25px;
                color:#666;
                font-size:14px;
            ">

                Gracias por su preferencia

                <br>

                NICO SPORT

            </div>

        </div>

    `;


    document.body.appendChild(captura);


    // =====================================================
    // VERIFICAR HTML2CANVAS
    // =====================================================

    if (typeof html2canvas === 'undefined') {

        if (document.body.contains(captura)) {
            document.body.removeChild(captura);
        }

        Swal.fire({
            icon: 'error',
            title: 'Falta html2canvas',
            text: 'La librería html2canvas no está cargada.'
        });

        console.error(
            'ERROR: html2canvas no está definido.'
        );

        return;
    }


    // =====================================================
    // GENERAR IMAGEN
    // =====================================================

    html2canvas(captura, {

        scale: 2,

        backgroundColor: '#ffffff',

        useCORS: true

    })

    .then(function (canvas) {


        if (document.body.contains(captura)) {
            document.body.removeChild(captura);
        }


        const imagen =
            canvas.toDataURL('image/png');


        // =================================================
        // MOSTRAR IMAGEN
        // =================================================

        Swal.fire({

            title: 'Estado de cuenta',

            html: `

                <div style="
                    max-height:70vh;
                    overflow:auto;
                    padding:5px;
                ">

                    <img
                        src="${imagen}"
                        style="
                            width:100%;
                            max-width:700px;
                            height:auto;
                            border-radius:8px;
                        "
                    >

                </div>

            `,

            width: '800px',

            showCancelButton: true,

            confirmButtonText:
                '<i class="fas fa-download"></i> Descargar imagen',

            cancelButtonText:
                'Cerrar',

            showCloseButton: true

        })

        .then(function (result) {

            if (result.isConfirmed) {

                const enlace =
                    document.createElement('a');


                enlace.href =
                    imagen;


                enlace.download =
                    'estado_cuenta_' +
                    nombreCliente +
                    '.png';


                document.body.appendChild(enlace);

                enlace.click();

                document.body.removeChild(enlace);


                Swal.fire({

                    icon: 'success',

                    title: 'Imagen descargada',

                    text:
                        'El estado de cuenta de ' +
                        nombreCliente +
                        ' fue descargado correctamente.',

                    confirmButtonText: 'Aceptar'

                });

            }

        });

    })

    .catch(function (error) {


        console.error(
            'ERROR AL GENERAR IMAGEN:',
            error
        );


        if (document.body.contains(captura)) {
            document.body.removeChild(captura);
        }


        Swal.fire({

            icon: 'error',

            title: 'Error',

            text:
                'No se pudo generar la imagen. Revise la consola.',

            confirmButtonText: 'Aceptar'

        });

    });

});
    document.addEventListener('DOMContentLoaded', function () {


        // =====================================================
        // BOTÓN REGISTRAR PAGO
        // =====================================================

        const btnRegistrarPago =
            document.getElementById('btnRegistrarPago');


        if (btnRegistrarPago) {

            btnRegistrarPago.addEventListener('click', function () {


                // Buscar cliente mediante el buscador

                const searchInput =
                    document.querySelector('.dataTable-input') ||
                    document.querySelector(
                        '#datatablesSimple_wrapper input[type="search"]'
                    ) ||
                    document.querySelector(
                        'input[type="search"]'
                    );


                let nombreBuscado = '';


                if (searchInput) {

                    nombreBuscado =
                        searchInput.value.trim().toLowerCase();

                }


                // =================================================
                // VALIDAR CLIENTE
                // =================================================

                if (!nombreBuscado) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Seleccione un cliente',
                        text: 'Primero busque un cliente.',
                        confirmButtonText: 'Aceptar'
                    });

                    return;

                }


                // =================================================
                // BUSCAR FILAS
                // =================================================

                const filas =
                    Array.from(
                        document.querySelectorAll(
                            '#datatablesSimple tbody tr'
                        )
                    );


                const filasCliente =
                    filas.filter(function (fila) {

                        const celdas =
                            fila.querySelectorAll('td');


                        if (celdas.length < 9) {
                            return false;
                        }


                        const nombre =
                            celdas[1]
                                .innerText
                                .trim()
                                .toLowerCase();


                        return nombre.includes(nombreBuscado);

                    });


                // =================================================
                // CLIENTE NO ENCONTRADO
                // =================================================

                if (filasCliente.length === 0) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Cliente no encontrado',
                        text: 'No se encontró el cliente.',
                        confirmButtonText: 'Aceptar'
                    });

                    return;

                }


                // =================================================
                // DATOS
                // =================================================
                         
            const primeraFila = filasCliente[0];

                const celdas =
                    primeraFila.querySelectorAll('td');


                // =====================================================
                // OBTENER DATOS DEL CLIENTE DESDE EL BOTÓN
                // DataTables puede modificar el <tr>, pero mantiene
                // los atributos del botón.
                // =====================================================

                let botonPago = null;

                // Buscar un botón Pagar dentro de las filas del cliente
                for (const fila of filasCliente) {

                    const boton = fila.querySelector('.btn-pagar');

                    if (boton) {
                        botonPago = boton;
                        break;
                    }
                }


                // =====================================================
                // VALIDAR BOTÓN
                // =====================================================

                if (!botonPago) {

                    Swal.fire({
                        icon: 'error',
                        title: 'No se encontró el botón de pago',
                        text: 'No se pudo obtener el ID del cliente.',
                        confirmButtonText: 'Aceptar'
                    });

                    return;
                }


                // =====================================================
                // OBTENER ID CLIENTE
                // =====================================================

                const idCliente =
                    botonPago.getAttribute('data-id-cliente');


                // =====================================================
                // DEBUG
                // =====================================================

                console.log("=================================");
                console.log("ID CLIENTE OBTENIDO:", idCliente);
                console.log("BOTÓN:", botonPago);
                console.log("DATASET BOTÓN:", botonPago.dataset);
                console.log("=================================");


                // =====================================================
                // VALIDAR ID
                // =====================================================

                if (!idCliente || idCliente === 'null' || idCliente === 'undefined') {

                    Swal.fire({
                        icon: 'error',
                        title: 'ID de cliente no encontrado',
                        text: 'El cliente no tiene un ID válido.',
                        confirmButtonText: 'Aceptar'
                    });

                    return;
                }


                const nombreCliente =
                    celdas[1].innerText.trim();


                // =================================================
                // CALCULAR TOTAL
                // =================================================

                let total = 0;


                filasCliente.forEach(function (fila) {

                    const celdas =
                        fila.querySelectorAll('td');


                    const precio =
                        parseFloat(
                            celdas[5]
                                .innerText
                                .replace('S/', '')
                                .replace(',', '')
                                .trim()
                        ) || 0;


                    total += precio;

                });


                // =====================================================
                // TOTAL PAGADO DEL CLIENTE
                // =====================================================

                let totalPagado = 0;

                filasCliente.forEach(function(fila) {

                    const valor = parseFloat(
                        fila.getAttribute('data-total-pagado') || '0'
                    );

                    if (!isNaN(valor) && valor > totalPagado) {
                        totalPagado = valor;
                    }

                });

                console.log("TOTAL PAGADO DEL CLIENTE:", totalPagado);

                const saldo =
                total - totalPagado;


                // =================================================
                // SI YA PAGÓ TODO
                // =================================================

                if (saldo <= 0) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Cuenta pagada',
                        text:
                            nombreCliente +
                            ' ya no tiene saldo pendiente.',
                        confirmButtonText: 'Aceptar'
                    });

                    return;

                }


                // =================================================
                // LLENAR MODAL
                // =================================================

                document.getElementById(
                    'id_cliente_pago'
                ).value = idCliente;


                document.getElementById(
                    'nombre_cliente_pago'
                ).value = nombreCliente;


                document.getElementById(
                    'monto_pago'
                ).value = '';


                document.getElementById(
                    'monto_pago'
                ).max = saldo.toFixed(2);


                // Fecha actual

                const hoy =
                    new Date()
                        .toISOString()
                        .split('T')[0];


                document.getElementById(
                    'fecha_pago'
                ).value = hoy;


                document.getElementById(
                    'informacionDeuda'
                ).innerHTML = `

                    <strong>Total:</strong>
                    S/ ${total.toFixed(2)}

                    <br>

                    <strong>Pagado:</strong>
                    S/ ${totalPagado.toFixed(2)}

                    <br>

                    <strong>Saldo pendiente:</strong>
                    S/ ${saldo.toFixed(2)}

                `;


                // =================================================
                // MOSTRAR MODAL
                // =================================================

                const modal =
                    new bootstrap.Modal(
                        document.getElementById(
                            'modalRegistrarPago'
                        )
                    );


                modal.show();

            });

        }


    });
    document.getElementById('formRegistrarPago')
    .addEventListener('submit', function (e) {

        e.preventDefault();


        const formulario = this;


        const datos =
            new FormData(formulario);


        const monto =
            parseFloat(
                document.getElementById('monto_pago').value
            );


        if (!monto || monto <= 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Monto inválido',
                text: 'Ingrese un monto válido.',
                confirmButtonText: 'Aceptar'
            });

            return;

        }


        fetch('pago_registrar.php', {

            method: 'POST',

            body: datos

        })

        .then(response => response.text())

        .then(resultado => {

        resultado = resultado.trim();

        console.log("RESPUESTA PHP:", resultado);
    

        if (resultado === 'SI') {

        Swal.fire({

            icon: 'success',

            title: '¡Pago registrado!',

            text: 'El pago fue registrado correctamente.',

            confirmButtonText: 'Aceptar'

        }).then(() => {

            location.reload();

        });

        } else {

            Swal.fire({

                icon: 'error',

                title: 'Error al registrar pago',

                html:
                    '<b>El servidor respondió:</b><br><br>' +
                    '<code>' + resultado + '</code>',

                confirmButtonText: 'Aceptar'

            });

        }

    })

    .catch(error => {

        console.error(error);

        Swal.fire({

            icon: 'error',

            title: 'Error',

            text:
                'Ocurrió un error al registrar el pago.',

            confirmButtonText: 'Aceptar'

        });

    });

});
// =====================================================
// BOTÓN PAGAR DE CADA FILA
// =====================================================

document.addEventListener('click', function (e) {

    const boton = e.target.closest('.btn-pagar');

    if (!boton) {
        return;
    }

    console.log("=================================");
    console.log("BOTÓN PAGAR PRESIONADO");
    console.log("ID SALIDA:", boton.dataset.id);
    console.log("ID CLIENTE:", boton.dataset.idCliente);
    console.log("TOTAL PAGADO:", boton.dataset.totalPagado);
    console.log("=================================");


    const idSalida = boton.dataset.id;
    const idCliente = boton.dataset.idCliente;
    const totalPagado = parseFloat(
        boton.dataset.totalPagado || 0
    );


    // =====================================================
    // VALIDAR ID CLIENTE
    // =====================================================

    if (!idCliente || idCliente === '0') {

        Swal.fire({
            icon: 'error',
            title: 'Cliente inválido',
            text: 'El registro no tiene un ID de cliente válido.',
            confirmButtonText: 'Aceptar'
        });

        console.error(
            "ID CLIENTE INVÁLIDO:",
            idCliente
        );

        return;
    }


    // =====================================================
    // OBTENER FILA
    // =====================================================

    const fila = boton.closest('tr');

    const celdas = fila.querySelectorAll('td');


    if (celdas.length < 9) {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo obtener la información del registro.',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // DATOS DEL REGISTRO
    // =====================================================

    const nombreCliente =
        celdas[1].innerText.trim();


    const precio =
        parseFloat(
            celdas[5].innerText
                .replace('S/', '')
                .replace(',', '')
                .trim()
        ) || 0;


    // =====================================================
    // SALDO
    // =====================================================

    const saldo = precio - totalPagado;


    if (saldo <= 0) {

        Swal.fire({
            icon: 'success',
            title: 'Cuenta pagada',
            text:
                nombreCliente +
                ' ya no tiene saldo pendiente.',
            confirmButtonText: 'Aceptar'
        });

        return;
    }


    // =====================================================
    // LLENAR MODAL
    // =====================================================

    document.getElementById(
        'id_cliente_pago'
    ).value = idCliente;


    document.getElementById(
        'nombre_cliente_pago'
    ).value = nombreCliente;


    document.getElementById(
        'monto_pago'
    ).value = '';


    document.getElementById(
        'monto_pago'
    ).max = saldo.toFixed(2);


    // =====================================================
    // FECHA ACTUAL
    // =====================================================

    const hoy =
        new Date()
            .toISOString()
            .split('T')[0];


    document.getElementById(
        'fecha_pago'
    ).value = hoy;


    // =====================================================
    // INFORMACIÓN DEUDA
    // =====================================================

    document.getElementById(
        'informacionDeuda'
    ).innerHTML = `

        <strong>Total:</strong>
        S/ ${precio.toFixed(2)}

        <br>

        <strong>Pagado:</strong>
        S/ ${totalPagado.toFixed(2)}

        <br>

        <strong>Saldo pendiente:</strong>
        S/ ${saldo.toFixed(2)}

    `;


    // =====================================================
    // MOSTRAR MODAL
    // =====================================================

    const modal =
        new bootstrap.Modal(
            document.getElementById(
                'modalRegistrarPago'
            )
        );


    modal.show();

});
</script>
