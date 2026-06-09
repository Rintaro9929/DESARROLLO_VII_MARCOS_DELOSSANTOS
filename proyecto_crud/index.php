<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD con Fetch + PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="container mt-4">
    <h2>Gestión de Productos</h2>

    <form id="productoForm">
        <input type="hidden" name="id" id="productoId">
        <div class="row mb-3">
            <div class="col">
                <label>Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" required>
            </div>
            <div class="col">
                <label>Producto</label>
                <input type="text" name="producto" id="producto" class="form-control" required>
            </div>
            <div class="col">
                <label>Precio</label>
                <input type="number" step="0.01" min="0" name="precio" id="precio" class="form-control" required>
            </div>
            <div class="col">
                <label>Cantidad</label>
                <input type="number" step="1" min="1" name="cantidad" id="cantidad" class="form-control" required>
            </div>
            <div class="col align-self-end">
                <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                <button type="button" class="btn btn-secondary" id="btnLimpiar">Limpiar</button>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="buscarInput" class="form-control" placeholder="Buscar por código o nombre...">
        </div>
        <div class="col-md-2">
            <button type="button" id="btnBuscar" class="btn btn-info">Buscar</button>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Código</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Acciones</th></tr>
        </thead>
        <tbody id="tablaProductos"></tbody>
    </table>

    <script src="script.js"></script>
</body>
</html>