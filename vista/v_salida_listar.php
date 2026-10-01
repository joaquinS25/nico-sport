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
                        $n = 0;
                        foreach ($salida as $key => $value) 
                        {
                            $n++;
                            $total_pagado = floatval($value['total_pagado'] ?? 0);
                            $esta_pagado  = (($value['pago'] ?? 'NO') !== 'NO');
                            ?>
                            <tr
                                data-id-salida="<?= htmlspecialchars($value['id_salida'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
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

                                <!-- COLUMNA ESTADO -->
                                <td>
                                    <?php if ($esta_pagado): ?>
                                        <span class="badge bg-success">Pagado</span>
                                    <?php elseif ($total_pagado > 0): ?>
                                        <span class="badge bg-info text-dark">
                                            Abonó S/ <?= number_format($total_pagado, 2) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Sin pagos</span>
                                    <?php endif; ?>
                                </td>

                                <!-- BOTÓN -->
                                <td>
                                    <?php if (!$esta_pagado): ?>
                                        <button 
                                            type="button"
                                            class="btn btn-success btn-sm btn-pagar"
                                            data-id="<?= htmlspecialchars($value['id_salida'] ?? '') ?>"
                                            data-id-cliente="<?= htmlspecialchars($value['id_cliente'] ?? '') ?>"
                                            data-nombre="<?= htmlspecialchars($value['nom_cliente'] ?? '') ?>"
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formRegistrarPago">

                    <input type="hidden" id="id_cliente_pago" name="id_cliente">

                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <input type="text" id="nombre_cliente_pago" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Productos de la cuenta</label>
                        <div id="listaProductosCuenta" class="list-group"
                             style="max-height:220px;overflow:auto;"></div>
                    </div>

                    <div id="informacionDeuda" class="alert alert-info"></div>

                    <div class="mb-3">
                        <label class="form-label">Monto que paga</label>
                        <div class="input-group">
                            <span class="input-group-text">S/</span>
                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                id="monto_pago"
                                name="monto"
                                class="form-control"
                                required
                            >
                            <button type="button" class="btn btn-outline-secondary" id="btnPagarTodo">
                                Pagar todo
                            </button>
                        </div>
                        <small class="text-muted">
                            La lista se limpia solo cuando el saldo pendiente llega a S/ 0.00
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha del pago</label>
                        <input
                            type="date"
                            id="fecha_pago"
                            name="fecha_pago"
                            class="form-control"
                            required
                        >
                    </div>

                    <div id="resumenNuevoSaldo" class="text-end fw-bold mb-3"></div>

                    <button type="submit" class="btn btn-success w-100">
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

// =====================================================
// DATOS COMPLETOS (todas las salidas, sin depender de la
// paginación ni del filtro de DataTables)
// =====================================================
const SALIDAS = <?= json_encode(
    array_map(function ($v) {
        return [
            'id_salida'      => $v['id_salida']      ?? '',
            'id_cliente'     => $v['id_cliente']     ?? '',
            'nom_cliente'    => $v['nom_cliente']    ?? '',
            'cel_cliente'    => $v['cel_cliente']    ?? '',
            'cantidad'       => $v['cantidad']       ?? '',
            'producto'       => $v['producto']       ?? '',
            'precio'         => $v['precio']         ?? 0,
            'fecha_registro' => $v['fecha_registro'] ?? '',
            'total_pagado'   => $v['total_pagado']   ?? 0,
            'pago'           => $v['pago']           ?? 'NO',
        ];
    }, array_values($salida)),
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
) ?>;


// =====================================================
// UTILIDADES
// =====================================================

function num(valor) {
    return parseFloat(
        String(valor ?? '0').replace('S/', '').replace(/,/g, '').trim()
    ) || 0;
}

function esc(texto) {
    return String(texto ?? '').replace(/[&<>"']/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
}

function fechaHoyLocal() {
    const d = new Date();
    d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
    return d.toISOString().split('T')[0];
}

function alerta(icon, title, text) {
    Swal.fire({ icon: icon, title: title, text: text, confirmButtonText: 'Aceptar' });
}

function obtenerBuscador() {
    return document.querySelector('.dataTable-input') ||
           document.querySelector('#datatablesSimple_wrapper input[type="search"]') ||
           document.querySelector('input[type="search"]');
}


// =====================================================
// CLIENTE BUSCADO EN EL BUSCADOR DE LA TABLA
// Devuelve { idCliente, nombre, celular, registros } o null
// =====================================================

function obtenerClienteBuscado() {

    const buscador = obtenerBuscador();

    const texto = buscador ? buscador.value.trim().toLowerCase() : '';

    if (!texto) {
        alerta('warning', 'Seleccione un cliente',
               'Primero escriba el nombre del cliente en el buscador.');
        return null;
    }

    const coincidencias = SALIDAS.filter(function (s) {
        return String(s.nom_cliente).toLowerCase().includes(texto);
    });

    if (coincidencias.length === 0) {
        alerta('warning', 'Cliente no encontrado',
               'No se encontraron registros para: ' + texto);
        return null;
    }

    // Usar el primer cliente encontrado (por id, para no mezclar Karin con Karina)
    const primero = coincidencias[0];

    const registros = SALIDAS.filter(function (s) {
        return String(s.id_cliente) === String(primero.id_cliente);
    });

    return {
        idCliente: primero.id_cliente,
        nombre:    String(primero.nom_cliente).trim(),
        celular:   String(primero.cel_cliente || '').trim(),
        registros: registros
    };
}


// =====================================================
// ESTADO DE CUENTA
// Solo cuenta los productos con pago = 'NO' (cuenta abierta).
// Los pagos NO se descuentan de ningún producto en particular:
// solo se suman al "pagado" de la cuenta.
//   total     = suma de precios de la cuenta abierta
//   pagado    = pagos acumulados de la cuenta abierta
//   pendiente = total - pagado
// =====================================================

function obtenerCuenta(registros) {

    const abiertos = registros.filter(function (r) {
        return String(r.pago || 'NO') === 'NO';
    });

    // Más antiguo primero (fecha y luego id)
    abiertos.sort(function (a, b) {

        const fa = String(a.fecha_registro);
        const fb = String(b.fecha_registro);

        if (fa !== fb) {
            return fa.localeCompare(fb);
        }

        return (parseInt(a.id_salida) || 0) - (parseInt(b.id_salida) || 0);
    });

    // total_pagado viene repetido en cada fila del cliente
    let totalPagado = 0;

    abiertos.forEach(function (r) {
        const v = num(r.total_pagado);
        if (v > totalPagado) totalPagado = v;
    });

    let total = 0;

    const productos = abiertos.map(function (r) {
        const precio = num(r.precio);
        total += precio;

        return {
            id_salida: r.id_salida,
            cantidad:  r.cantidad,
            producto:  r.producto,
            fecha:     r.fecha_registro,
            precio:    precio
        };
    });

    total       = Number(total.toFixed(2));
    totalPagado = Number(totalPagado.toFixed(2));

    return {
        productos:   productos,
        total:       total,
        totalPagado: totalPagado,
        saldo:       Math.max(Number((total - totalPagado).toFixed(2)), 0)
    };
}


// =====================================================
// CONSTRUIR LA CAPTURA (nota / estado de cuenta)
// Muestra todos los productos y al final: total, pagado, pendiente
// =====================================================

function construirCaptura(titulo, cliente, datos) {

    let filasHTML = '';

    datos.productos.forEach(function (p) {
        filasHTML += `
            <tr>
                <td style="padding:12px;border-bottom:1px solid #ddd;">${esc(p.producto)}</td>
                <td style="padding:12px;border-bottom:1px solid #ddd;text-align:center;">${esc(p.cantidad)}</td>
                <td style="padding:12px;border-bottom:1px solid #ddd;text-align:right;">S/ ${p.precio.toFixed(2)}</td>
                <td style="padding:12px;border-bottom:1px solid #ddd;text-align:center;">${esc(p.fecha)}</td>
            </tr>
        `;
    });

    const captura = document.createElement('div');

    captura.style.position = 'absolute';
    captura.style.left = '-99999px';
    captura.style.top = '0';
    captura.style.width = '700px';
    captura.style.background = '#ffffff';
    captura.style.padding = '30px';
    captura.style.fontFamily = 'Arial, sans-serif';
    captura.style.boxSizing = 'border-box';

    captura.innerHTML = `
        <div style="border:2px solid #ddd;border-radius:15px;padding:30px;background:white;">

            <div style="text-align:center;margin-bottom:25px;">
                <h1 style="margin:0;font-size:32px;color:#222;">NICO SPORT</h1>
                <p style="margin:8px 0;font-size:16px;color:#555;">
                    Equipamiento Deportivo de Alto Rendimiento
                </p>
                <h2 style="margin:15px 0 0;font-size:22px;">${esc(titulo)}</h2>
            </div>

            <div style="background:#f5f5f5;padding:18px;border-radius:10px;margin-bottom:25px;font-size:17px;line-height:1.8;">
                <strong>Cliente:</strong> ${esc(cliente.nombre)}
                <br>
                <strong>Celular:</strong> ${esc(cliente.celular)}
            </div>

            <table style="width:100%;border-collapse:collapse;font-size:15px;">
                <thead>
                    <tr style="background:#eeeeee;">
                        <th style="padding:12px;text-align:left;">Producto</th>
                        <th style="padding:12px;text-align:center;">Cantidad</th>
                        <th style="padding:12px;text-align:right;">Precio</th>
                        <th style="padding:12px;text-align:center;">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    ${filasHTML}
                </tbody>
            </table>

            <div style="margin-top:30px;padding:18px;background:#f5f5f5;border-radius:10px;font-size:20px;">
                <div style="display:flex;justify-content:space-between;padding:6px 0;">
                    <span>Saldo total:</span>
                    <span>S/ ${datos.total.toFixed(2)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:6px 0;color:#2e7d32;">
                    <span>Saldo pagado:</span>
                    <span>S/ ${datos.totalPagado.toFixed(2)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px 0 0;margin-top:8px;
                            border-top:2px solid #ccc;font-size:28px;font-weight:bold;color:#e53935;">
                    <span>SALDO PENDIENTE:</span>
                    <span>S/ ${datos.saldo.toFixed(2)}</span>
                </div>
            </div>

            <div style="text-align:center;margin-top:25px;color:#666;font-size:14px;">
                Gracias por su preferencia
                <br>
                NICO SPORT
            </div>

        </div>
    `;

    return captura;
}


// =====================================================
// PREPARAR CLIENTE + DEUDA (compartido por WhatsApp e Imagen)
// =====================================================

function prepararNota() {

    const cliente = obtenerClienteBuscado();

    if (!cliente) return null;

    const datos = obtenerCuenta(cliente.registros);

    console.log('==============================');
    console.log('CLIENTE:', cliente.nombre);
    console.log('TOTAL:', datos.total);
    console.log('PAGADO:', datos.totalPagado);
    console.log('PENDIENTE:', datos.saldo);
    console.log('PRODUCTOS:', datos.productos.length);
    console.log('==============================');

    if (datos.productos.length === 0 || datos.saldo <= 0) {
        alerta('info', 'Sin deuda pendiente',
               cliente.nombre + ' no tiene pagos pendientes.');
        return null;
    }

    return { cliente: cliente, datos: datos };
}


// =====================================================
// BOTÓN ENVIAR POR WHATSAPP
// =====================================================

document.getElementById('btnWhatsApp').addEventListener('click', function () {

    const nota = prepararNota();

    if (!nota) return;

    const cliente = nota.cliente;

    if (!cliente.celular) {
        alerta('error', 'Sin número de celular',
               'El cliente ' + cliente.nombre + ' no tiene un número de celular registrado.');
        return;
    }

    if (typeof html2canvas === 'undefined') {
        alerta('error', 'Falta html2canvas', 'La librería html2canvas no está cargada.');
        return;
    }

    const captura = construirCaptura('NOTA DE VENTA', cliente, nota.datos);

    document.body.appendChild(captura);

    html2canvas(captura, {
        scale: 2,
        backgroundColor: '#ffffff',
        useCORS: true
    }).then(function (canvas) {

        document.body.removeChild(captura);

        canvas.toBlob(function (blob) {

            if (!blob) {
                alerta('error', 'Error', 'No se pudo generar la captura.');
                return;
            }

            // Descargar imagen
            const url = URL.createObjectURL(blob);
            const enlace = document.createElement('a');

            enlace.href = url;
            enlace.download = 'deuda_' + cliente.nombre + '.png';

            document.body.appendChild(enlace);
            enlace.click();
            document.body.removeChild(enlace);

            // Número de WhatsApp (Perú)
            let numero = cliente.celular.replace(/\D/g, '');

            if (numero.length === 9 && numero.startsWith('9')) {
                numero = '51' + numero;
            }

            const mensaje =
                'Hola ' + cliente.nombre +
                ', le enviamos el detalle de su deuda pendiente de NICO SPORT.';

            window.open(
                'https://wa.me/' + numero + '?text=' + encodeURIComponent(mensaje),
                '_blank'
            );

            Swal.fire({
                icon: 'success',
                title: '¡Listo!',
                html:
                    'Se generó la captura de <b>' + esc(cliente.nombre) + '</b>.<br><br>' +
                    'WhatsApp se abrió para el número:<br>' +
                    '<b>' + esc(cliente.celular) + '</b><br><br>' +
                    'Adjunta la imagen descargada en la conversación.',
                confirmButtonText: 'Aceptar'
            });

            setTimeout(function () {
                URL.revokeObjectURL(url);
            }, 2000);

        }, 'image/png');

    }).catch(function (error) {

        console.error(error);

        if (document.body.contains(captura)) {
            document.body.removeChild(captura);
        }

        alerta('error', 'Error', 'Ocurrió un error al generar la captura.');
    });

});


// =====================================================
// BOTÓN GENERAR IMAGEN
// =====================================================

document.addEventListener('click', function (e) {

    if (!e.target.closest('#btnGenerarImagen')) {
        return;
    }

    const nota = prepararNota();

    if (!nota) return;

    const cliente = nota.cliente;

    if (typeof html2canvas === 'undefined') {
        alerta('error', 'Falta html2canvas', 'La librería html2canvas no está cargada.');
        return;
    }

    const captura = construirCaptura('ESTADO DE CUENTA', cliente, nota.datos);

    document.body.appendChild(captura);

    html2canvas(captura, {
        scale: 2,
        backgroundColor: '#ffffff',
        useCORS: true
    })
    .then(function (canvas) {

        if (document.body.contains(captura)) {
            document.body.removeChild(captura);
        }

        const imagen = canvas.toDataURL('image/png');

        Swal.fire({
            title: 'Estado de cuenta',
            html: `
                <div style="max-height:70vh;overflow:auto;padding:5px;">
                    <img src="${imagen}"
                         style="width:100%;max-width:700px;height:auto;border-radius:8px;">
                </div>
            `,
            width: '800px',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-download"></i> Descargar imagen',
            cancelButtonText: 'Cerrar',
            showCloseButton: true
        })
        .then(function (result) {

            if (result.isConfirmed) {

                const enlace = document.createElement('a');

                enlace.href = imagen;
                enlace.download = 'estado_cuenta_' + cliente.nombre + '.png';

                document.body.appendChild(enlace);
                enlace.click();
                document.body.removeChild(enlace);

                alerta('success', 'Imagen descargada',
                       'El estado de cuenta de ' + cliente.nombre +
                       ' fue descargado correctamente.');
            }

        });

    })
    .catch(function (error) {

        console.error('ERROR AL GENERAR IMAGEN:', error);

        if (document.body.contains(captura)) {
            document.body.removeChild(captura);
        }

        alerta('error', 'Error', 'No se pudo generar la imagen. Revise la consola.');
    });

});


// =====================================================
// MODAL REGISTRAR PAGO (compartido)
// =====================================================

let SALDO_MODAL = 0;

function actualizarResumenNuevoSaldo() {

    const monto = parseFloat(document.getElementById('monto_pago').value) || 0;
    const nuevo = Math.max(Number((SALDO_MODAL - monto).toFixed(2)), 0);
    const cont  = document.getElementById('resumenNuevoSaldo');

    if (monto <= 0) {
        cont.innerHTML = '';
        return;
    }

    cont.innerHTML = nuevo === 0
        ? '<span class="text-success">Con este pago la cuenta queda totalmente pagada</span>'
        : 'Saldo pendiente después del pago: <span class="text-danger">S/ ' + nuevo.toFixed(2) + '</span>';
}

function abrirModalPago(idCliente, nombreCliente) {

    if (!idCliente || idCliente === '0' || idCliente === 'null' || idCliente === 'undefined') {
        alerta('error', 'ID de cliente no encontrado', 'El cliente no tiene un ID válido.');
        return;
    }

    const registros = SALIDAS.filter(function (s) {
        return String(s.id_cliente) === String(idCliente);
    });

    const datos = obtenerCuenta(registros);

    console.log('PAGO -> cliente:', idCliente,
                'total:', datos.total,
                'pagado:', datos.totalPagado,
                'saldo:', datos.saldo);

    if (datos.productos.length === 0 || datos.saldo <= 0) {
        alerta('success', 'Cuenta pagada',
               nombreCliente + ' ya no tiene saldo pendiente.');
        return;
    }

    SALDO_MODAL = datos.saldo;

    document.getElementById('id_cliente_pago').value = idCliente;
    document.getElementById('nombre_cliente_pago').value = nombreCliente;
    document.getElementById('monto_pago').value = '';
    document.getElementById('monto_pago').max = datos.saldo.toFixed(2);
    document.getElementById('fecha_pago').value = fechaHoyLocal();
    document.getElementById('resumenNuevoSaldo').innerHTML = '';

    // Lista de todos los productos de la cuenta (solo informativa)
    document.getElementById('listaProductosCuenta').innerHTML = datos.productos.map(function (p) {
        return `
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <div><strong>${esc(p.producto)}</strong> x ${esc(p.cantidad)}</div>
                    <small class="text-muted">${esc(p.fecha)}</small>
                </div>
                <span>S/ ${p.precio.toFixed(2)}</span>
            </div>`;
    }).join('');

    document.getElementById('informacionDeuda').innerHTML = `
        <div class="d-flex justify-content-between"><span>Saldo total:</span><strong>S/ ${datos.total.toFixed(2)}</strong></div>
        <div class="d-flex justify-content-between"><span>Saldo pagado:</span><strong>S/ ${datos.totalPagado.toFixed(2)}</strong></div>
        <hr class="my-2">
        <div class="d-flex justify-content-between"><span>Saldo pendiente:</span><strong class="text-danger">S/ ${datos.saldo.toFixed(2)}</strong></div>
    `;

    bootstrap.Modal
        .getOrCreateInstance(document.getElementById('modalRegistrarPago'))
        .show();
}


// Botón "Pagar todo": llena el monto con el saldo pendiente
document.getElementById('btnPagarTodo').addEventListener('click', function () {
    document.getElementById('monto_pago').value = SALDO_MODAL.toFixed(2);
    actualizarResumenNuevoSaldo();
});

document.getElementById('monto_pago').addEventListener('input', actualizarResumenNuevoSaldo);


// Botón general "Registrar pago" (usa el cliente del buscador)
document.getElementById('btnRegistrarPago').addEventListener('click', function () {

    const cliente = obtenerClienteBuscado();

    if (!cliente) return;

    abrirModalPago(String(cliente.idCliente), cliente.nombre);
});


// Botón "Pagar" de cada fila
document.addEventListener('click', function (e) {

    const boton = e.target.closest('.btn-pagar');

    if (!boton) return;

    abrirModalPago(
        String(boton.dataset.idCliente || ''),
        String(boton.dataset.nombre || '').trim()
    );
});


// =====================================================
// ENVIAR EL FORMULARIO DE PAGO
// =====================================================

document.getElementById('formRegistrarPago').addEventListener('submit', function (e) {

    e.preventDefault();

    const datos = new FormData(this);

    const monto = parseFloat(document.getElementById('monto_pago').value);

    if (!monto || monto <= 0) {
        alerta('warning', 'Monto inválido', 'Ingrese un monto válido.');
        return;
    }

    if (monto > SALDO_MODAL + 0.005) {
        alerta('warning', 'Monto excedido',
               'El monto supera el saldo pendiente (S/ ' + SALDO_MODAL.toFixed(2) + ').');
        return;
    }

    fetch('pago_registrar.php', {
        method: 'POST',
        body: datos
    })
    .then(function (response) { return response.text(); })
    .then(function (resultado) {

        resultado = resultado.trim();

        console.log('RESPUESTA PHP:', resultado);

        if (resultado === 'SI') {

            const quedaPagado = monto >= SALDO_MODAL - 0.005;

            Swal.fire({
                icon: 'success',
                title: '¡Pago registrado!',
                text: quedaPagado
                    ? 'La cuenta quedó totalmente pagada.'
                    : 'El pago fue registrado correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                location.reload();
            });

        } else {

            Swal.fire({
                icon: 'error',
                title: 'Error al registrar pago',
                html:
                    '<b>El servidor respondió:</b><br><br>' +
                    '<code>' + esc(resultado) + '</code>',
                confirmButtonText: 'Aceptar'
            });
        }
    })
    .catch(function (error) {

        console.error(error);

        alerta('error', 'Error', 'Ocurrió un error al registrar el pago.');
    });

});

</script>