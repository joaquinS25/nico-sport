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
                        <th>Pago</th>
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
                        <th>Pago</th>
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
                             data-celular="<?= htmlspecialchars($value['cel_cliente']) ?>"
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
                                    <?php if ($value['pago'] == 'SI'): ?>
                                        <span class="badge bg-success">Pagado</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Pendiente</span>
                                    <?php endif; ?>
                                </td>
                                <!-- BOTÓN -->
                                <td>
                                    <?php if ($value['pago'] == 'NO'): ?>
                                        <button 
                                            class="btn btn-success btn-sm btn-pagar"
                                            data-id="<?= $value['id_salida'] ?>">
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

    filasCliente.forEach(function(fila) {

        const celdas =
            fila.querySelectorAll('td');


        // ================================================
        // COLUMNAS ACTUALES
        // ================================================
        //
        // 0 = #
        // 1 = Nombre
        // 2 = Celular
        // 3 = Cantidad
        // 4 = Producto
        // 5 = Precio
        // 6 = Fecha
        // 7 = Pago
        // 8 = Acción
        //
        // ================================================


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


        const pago =
            celdas[7].innerText
                .trim()
                .toLowerCase();


        // ================================================
        // SOLO PENDIENTES
        // ================================================

        if (pago.includes('pendiente')) {

            total += precio;


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

        }

    });


    // =====================================================
    // VERIFICAR SI TIENE DEUDA
    // =====================================================

    if (total <= 0) {

        Swal.fire({
            icon: 'info',
            title: 'Sin deuda pendiente',
            text: nombreCliente +
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
                text-align:right;
            ">

                <span style="
                    font-size:18px;
                    font-weight:bold;
                ">
                    TOTAL PENDIENTE:
                </span>

                <span style="
                    margin-left:10px;
                    font-size:28px;
                    font-weight:bold;
                    color:#003cff;
                ">
                    S/ ${total.toFixed(2)}
                </span>

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
document.getElementById('btnGenerarImagen').addEventListener('click', function () {

    // =====================================================
    // OBTENER BUSCADOR
    // =====================================================

    let searchInput =
        document.querySelector('.dataTable-input') ||
        document.querySelector('#datatablesSimple_wrapper input[type="search"]') ||
        document.querySelector('input[type="search"]');

    let nombreBuscado = '';

    if (searchInput) {
        nombreBuscado = searchInput.value.trim().toLowerCase();
    }


    // =====================================================
    // VERIFICAR QUE HAYA UN CLIENTE SELECCIONADO
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

    const todasLasFilas = Array.from(
        document.querySelectorAll('#datatablesSimple tbody tr')
    );


    const filas = todasLasFilas.filter(function (fila) {

        const celdas = fila.querySelectorAll('td');

        return celdas.length >= 9;

    });


    // =====================================================
    // FILTRAR CLIENTE
    // =====================================================

    const filasCliente = filas.filter(function (fila) {

        const celdas = fila.querySelectorAll('td');

        const nombre =
            celdas[1].innerText.trim().toLowerCase();

        return nombre.includes(nombreBuscado);

    });


    // =====================================================
    // CLIENTE NO ENCONTRADO
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

    const primeraFila = filasCliente[0];

    const celdasPrimeraFila =
        primeraFila.querySelectorAll('td');


    const nombreCliente =
        celdasPrimeraFila[1].innerText.trim();


    let celular =
        primeraFila.getAttribute('data-celular');


    if (!celular || celular.trim() === '') {

        celular =
            celdasPrimeraFila[2].innerText.trim();

    }


    // =====================================================
    // CREAR TABLA DE LA CAPTURA
    // =====================================================

    let total = 0;

    let filasHTML = '';


    filasCliente.forEach(function (fila) {

        const celdas =
            fila.querySelectorAll('td');


        // ================================================
        // COLUMNAS
        // 0 = #
        // 1 = Nombre
        // 2 = Celular
        // 3 = Cantidad
        // 4 = Producto
        // 5 = Precio
        // 6 = Fecha
        // 7 = Pago
        // 8 = Acción
        // ================================================


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


        const pago =
            celdas[7].innerText
                .trim()
                .toLowerCase();


        // SOLO PENDIENTES

        if (pago.includes('pendiente')) {

            total += precio;


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

        }

    });


    // =====================================================
    // VERIFICAR DEUDA
    // =====================================================

    if (total <= 0) {

        Swal.fire({
            icon: 'info',
            title: 'Sin deuda pendiente',
            text: nombreCliente + ' no tiene pagos pendientes.',
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


            <div style="
                margin-top:30px;
                padding:18px;
                background:#f5f5f5;
                border-radius:10px;
                text-align:right;
            ">

                <span style="
                    font-size:18px;
                    font-weight:bold;
                ">
                    TOTAL PENDIENTE:
                </span>

                <span style="
                    margin-left:10px;
                    font-size:28px;
                    font-weight:bold;
                    color:#003cff;
                ">
                    S/ ${total.toFixed(2)}
                </span>

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

    }).then(function (canvas) {


        document.body.removeChild(captura);


        const imagen =
            canvas.toDataURL('image/png');


        // =================================================
        // MOSTRAR IMAGEN EN SWEET ALERT
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

        }).then(function (result) {

            // =================================================
            // DESCARGAR IMAGEN
            // =================================================

            if (result.isConfirmed) {

                const enlace =
                    document.createElement('a');


                enlace.href = imagen;


                enlace.download =
                    'deuda_' +
                    nombreCliente +
                    '.png';


                document.body.appendChild(enlace);

                enlace.click();

                document.body.removeChild(enlace);


                Swal.fire({

                    icon: 'success',

                    title: 'Imagen descargada',

                    text:
                        'La imagen de ' +
                        nombreCliente +
                        ' fue descargada correctamente.',

                    confirmButtonText: 'Aceptar'

                });

            }

        });

    }).catch(function (error) {

        console.error(error);


        if (document.body.contains(captura)) {

            document.body.removeChild(captura);

        }


        Swal.fire({

            icon: 'error',

            title: 'Error',

            text:
                'No se pudo generar la imagen.',

            confirmButtonText: 'Aceptar'

        });

    });

});
</script>
