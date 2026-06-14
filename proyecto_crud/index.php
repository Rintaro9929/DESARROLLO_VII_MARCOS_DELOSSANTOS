<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con Fetch + PHP OOP + MySQL</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ========== VARIABLES GLOBALES ========== */
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #6c8cff;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --dark: #1e293b;
            --light: #f8fafc;
            --white: #ffffff;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --radius: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            min-height: 100vh;
            padding: 40px 24px;
        }

        /* ========== CONTAINER PRINCIPAL ========== */
        .app-container {
            max-width: 1440px;
            margin: 0 auto;
        }

        /* ========== TARJETA PRINCIPAL ========== */
        .main-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            backdrop-filter: blur(10px);
            animation: slideUpFade 0.5s ease-out;
        }

        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== HEADER ========== */
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 32px 40px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .header p {
            opacity: 0.9;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        /* ========== FORMULARIO ========== */
        .form-section {
            padding: 32px 40px;
            background: var(--light);
            border-bottom: 1px solid var(--gray-light);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .input-group-custom {
            display: flex;
            flex-direction: column;
        }

        .input-group-custom label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-custom label i {
            margin-right: 6px;
            color: var(--primary);
        }

        .input-group-custom input {
            padding: 12px 16px;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius-sm);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
            font-family: inherit;
        }

        .input-group-custom input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .input-group-custom input:hover {
            border-color: var(--primary-light);
        }

        /* ========== BOTONES ========== */
        .btn-custom {
            padding: 12px 28px;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-custom:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-custom span {
            position: relative;
            z-index: 1;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-secondary-custom {
            background: var(--secondary);
            color: var(--white);
        }

        .btn-secondary-custom:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-info-custom {
            background: linear-gradient(135deg, var(--info) 0%, #0f8a9c 100%);
            color: var(--white);
        }

        .btn-info-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, var(--warning) 0%, #e0a800 100%);
            color: var(--dark);
        }

        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .button-group {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        /* ========== BUSCADOR ========== */
        .search-section {
            padding: 24px 40px;
            background: var(--white);
            border-bottom: 1px solid var(--gray-light);
        }

        .search-container {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search-container input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius-sm);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .search-container input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        /* ========== TABLA ========== */
        .table-section {
            padding: 0 40px 40px 40px;
            overflow-x: auto;
        }

        .product-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
        }

        .product-table thead tr {
            background: linear-gradient(135deg, var(--dark) 0%, #2d3748 100%);
        }

        .product-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--white);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .product-table th:first-child {
            border-top-left-radius: var(--radius-md);
        }

        .product-table th:last-child {
            border-top-right-radius: var(--radius-md);
        }

        .product-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--gray-light);
            color: var(--dark);
        }

        .product-table tbody tr {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-table tbody tr:hover {
            background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
            transform: scale(1.01);
        }

        .product-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ========== BADGES DE STOCK ========== */
        .badge-stock {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-stock i {
            font-size: 0.8rem;
        }

        .badge-critical {
            background: linear-gradient(135deg, #ff4757 0%, #c0392b 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
        }

        .badge-low {
            background: linear-gradient(135deg, #ffa502 0%, #e67e22 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 165, 2, 0.3);
        }

        .badge-medium {
            background: linear-gradient(135deg, #2ed573 0%, #26a65b 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(46, 213, 115, 0.3);
        }

        .badge-high {
            background: linear-gradient(135deg, #00b894 0%, #009432 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 184, 148, 0.3);
        }

        /* ========== ANIMACIONES ========== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        /* ========== SCROLLBAR PERSONALIZADA ========== */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-light);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            body {
                padding: 20px 16px;
            }

            .header, .form-section, .search-section, .table-section {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                grid-column: span 1;
            }

            .search-container {
                flex-direction: column;
            }

            .search-container input, .search-container button {
                width: 100%;
            }

            .product-table {
                font-size: 0.8rem;
            }

            .product-table th, .product-table td {
                padding: 10px 12px;
            }

            .btn-custom {
                padding: 10px 20px;
                font-size: 0.85rem;
            }
        }

        /* ========== LOADING SPINNER ========== */
        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 3px solid var(--gray-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .text-center {
            text-align: center;
        }

        /* ========== ICONOS (emojis como fallback) ========== */
        .icon {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="main-card">
            <!-- HEADER -->
            <div class="header">
                <h1>
                    <span class="icon">📦</span> 
                    Gestión de Productos
                </h1>
                <p>Sistema de inventario con CRUD, Fetch API y PHP OOP</p>
            </div>

            <!-- FORMULARIO -->
            <div class="form-section">
                <form id="productoForm">
                    <input type="hidden" name="id" id="productoId">
                    <div class="form-grid">
                        <div class="input-group-custom">
                            <label><i>🔖</i> Código</label>
                            <input type="text" name="codigo" id="codigo" placeholder="Ej: P001" required>
                        </div>
                        <div class="input-group-custom">
                            <label><i>📝</i> Producto</label>
                            <input type="text" name="producto" id="producto" placeholder="Nombre del producto" required>
                        </div>
                        <div class="input-group-custom">
                            <label><i>💰</i> Precio</label>
                            <input type="number" step="0.01" min="0" name="precio" id="precio" placeholder="0.00" required>
                        </div>
                        <div class="input-group-custom">
                            <label><i>📊</i> Cantidad</label>
                            <input type="number" step="1" min="1" name="cantidad" id="cantidad" placeholder="Mínimo 1" required>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="btn-custom btn-primary-custom" id="btnGuardar">
                                <span>💾</span> Guardar
                            </button>
                            <button type="button" class="btn-custom btn-secondary-custom" id="btnLimpiar">
                                <span>🗑️</span> Limpiar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- BUSCADOR -->
            <div class="search-section">
                <div class="search-container">
                    <input type="text" id="buscarInput" placeholder="🔍 Buscar por código o nombre del producto...">
                    <button type="button" class="btn-custom btn-info-custom" id="btnBuscar">
                        <span>🔎</span> Buscar
                    </button>
                </div>
            </div>

            <!-- TABLA DE PRODUCTOS -->
            <div class="table-section">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductos">
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="spinner"></div>
                                <br>Cargando productos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>