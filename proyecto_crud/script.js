// Variables globales
const form = document.getElementById('productoForm');
const btnGuardar = document.getElementById('btnGuardar');
const btnLimpiar = document.getElementById('btnLimpiar');
const btnBuscar = document.getElementById('btnBuscar');
const buscarInput = document.getElementById('buscarInput');

// Función para mostrar alertas con SweetAlert2
function mostrarAlerta(titulo, texto, icono) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
}

// Función para enviar el formulario (Guardar o Modificar)
async function enviarFormulario(accion) {
    const formData = new FormData(form);
    formData.append('accion', accion);

    try {
        const response = await fetch('registrar.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            mostrarAlerta('Éxito', data.message, 'success');
            listarProductos(); // Recargar la tabla
            limpiarFormulario(); // Limpiar el formulario
        } else {
            // Mostrar errores de validación
            let errores = '';
            if (data.errors) {
                for (let campo in data.errors) {
                    errores += `• ${campo}: ${data.errors[campo]}\n`;
                }
            }
            mostrarAlerta('Error', errores || data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error', 'Error de conexión con el servidor', 'error');
    }
}

// Función para listar productos (con búsqueda opcional)
async function listarProductos(termino = '') {
    const formData = new FormData();
    formData.append('accion', 'Buscar');
    formData.append('termino', termino);

    try {
        const response = await fetch('registrar.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            const tbody = document.getElementById('tablaProductos');
            
            if (data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay productos registrados</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            data.data.forEach(prod => {
                const row = tbody.insertRow();
                row.innerHTML = `
                    <td>${prod.id}</td>
                    <td>${prod.codigo}</td>
                    <td>${prod.producto}</td>
                    <td>$${parseFloat(prod.precio).toFixed(2)}</td>
                    <td>${prod.cantidad}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick='editarProducto(${JSON.stringify(prod)})'>
                            ✏️ Editar
                        </button>
                    </td>
                `;
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error', 'Error al cargar los productos', 'error');
    }
}

// Función para editar producto
function editarProducto(producto) {
    document.getElementById('productoId').value = producto.id;
    document.getElementById('codigo').value = producto.codigo;
    document.getElementById('producto').value = producto.producto;
    document.getElementById('precio').value = producto.precio;
    document.getElementById('cantidad').value = producto.cantidad;
    
    // Cambiar el botón de Guardar a Modificar
    btnGuardar.innerHTML = '✏️ Modificar';
    btnGuardar.onclick = () => enviarFormulario('Modificar');
}

// Función para limpiar el formulario
function limpiarFormulario() {
    form.reset();
    document.getElementById('productoId').value = '';
    
    // Restaurar el botón a su estado original
    btnGuardar.innerHTML = '💾 Guardar';
    btnGuardar.onclick = () => enviarFormulario('Guardar');
}

// Función para buscar productos
function buscarProductos() {
    const termino = buscarInput.value.trim();
    listarProductos(termino);
}

// Event Listeners
btnGuardar.onclick = () => enviarFormulario('Guardar');
btnLimpiar.onclick = limpiarFormulario;
btnBuscar.onclick = buscarProductos;

// Permitir búsqueda al presionar Enter
buscarInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        buscarProductos();
    }
});

// Cargar la lista de productos al iniciar
listarProductos();