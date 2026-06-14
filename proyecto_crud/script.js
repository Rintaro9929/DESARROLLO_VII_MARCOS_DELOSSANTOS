// script.js
const form = document.getElementById('productoForm');
const btnGuardar = document.getElementById('btnGuardar');
const btnLimpiar = document.getElementById('btnLimpiar');
const btnBuscar = document.getElementById('btnBuscar');
const buscarInput = document.getElementById('buscarInput');

function mostrarAlerta(titulo, texto, icono) {
    Swal.fire({ title: titulo, text: texto, icon: icono });
}

// Función para obtener badge de stock
function getStockBadge(cantidad) {
    if (cantidad === 0) {
        return '<span style="background:#ff4757; padding:4px 12px; border-radius:20px; color:white; font-size:0.75rem; font-weight:600;">⚠️ AGOTADO</span>';
    } else if (cantidad <= 5) {
        return '<span style="background:#ffa502; padding:4px 12px; border-radius:20px; color:white; font-size:0.75rem; font-weight:600;">🔴 STOCK BAJO (' + cantidad + ')</span>';
    } else if (cantidad <= 15) {
        return '<span style="background:#2ed573; padding:4px 12px; border-radius:20px; color:white; font-size:0.75rem; font-weight:600;">🟡 STOCK MEDIO (' + cantidad + ')</span>';
    } else {
        return '<span style="background:#00b894; padding:4px 12px; border-radius:20px; color:white; font-size:0.75rem; font-weight:600;">✅ STOCK ALTO (' + cantidad + ')</span>';
    }
}

// Función para formatear precio
function formatPrice(precio) {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2
    }).format(precio);
}

async function enviarFormulario(accion) {
    const formData = new FormData(form);
    formData.append('accion', accion);

    try {
        const response = await fetch('registrar.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        console.log('Respuesta:', data);

        if (data.success) {
            mostrarAlerta('Éxito', data.message, 'success');
            listarProductos();
            limpiarFormulario();
        } else {
            let errores = data.message;
            if (data.errors) {
                errores = Object.values(data.errors).filter(e => e).join('\n');
            }
            mostrarAlerta('Error', errores, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error', 'Error de conexión: ' + error.message, 'error');
    }
}

async function listarProductos(termino = '') {
    const formData = new FormData();
    formData.append('accion', 'Buscar');
    formData.append('termino', termino);

    try {
        const response = await fetch('registrar.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        console.log('Productos recibidos:', data);

        const tbody = document.getElementById('tablaProductos');
        
        if (data.success && data.data && data.data.length > 0) {
            tbody.innerHTML = '';
            data.data.forEach(prod => {
                tbody.innerHTML += `
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 16px; font-weight: 600;">${prod.id}</td>
                        <td style="padding: 12px 16px;"><code style="background:#f1f5f9; padding:4px 8px; border-radius:6px;">${prod.codigo}</code></td>
                        <td style="padding: 12px 16px; font-weight: 500;">${prod.producto}</td>
                        <td style="padding: 12px 16px; color: #4361ee; font-weight: 600;">${formatPrice(prod.precio)}</td>
                        <td style="padding: 12px 16px;">${prod.cantidad} und.</td>
                        <td style="padding: 12px 16px;">${getStockBadge(prod.cantidad)}</td>
                        <td style="padding: 12px 16px;">
                            <button onclick='editarProducto(${JSON.stringify(prod)})' style="background:#ffc107; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-weight:600;">
                                ✏️ Editar
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px;">📭 No hay productos registrados</td></tr>';
        }
    } catch (error) {
        console.error('Error en listarProductos:', error);
        document.getElementById('tablaProductos').innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px; color:#dc3545;">❌ Error al cargar: ' + error.message + '</td></tr>';
    }
}

function editarProducto(producto) {
    document.getElementById('productoId').value = producto.id;
    document.getElementById('codigo').value = producto.codigo;
    document.getElementById('producto').value = producto.producto;
    document.getElementById('precio').value = producto.precio;
    document.getElementById('cantidad').value = producto.cantidad;
    
    btnGuardar.innerHTML = '✏️ Modificar';
    btnGuardar.onclick = () => enviarFormulario('Modificar');
}

function limpiarFormulario() {
    form.reset();
    document.getElementById('productoId').value = '';
    btnGuardar.innerHTML = '💾 Guardar';
    btnGuardar.onclick = () => enviarFormulario('Guardar');
}

function buscarProductos() {
    listarProductos(buscarInput.value);
}

// Event Listeners
btnGuardar.onclick = () => enviarFormulario('Guardar');
btnLimpiar.onclick = limpiarFormulario;
btnBuscar.onclick = buscarProductos;

if (buscarInput) {
    buscarInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') buscarProductos();
    });
}

// Cargar productos al iniciar
document.addEventListener('DOMContentLoaded', () => {
    console.log('Página cargada, cargando productos...');
    listarProductos();
});