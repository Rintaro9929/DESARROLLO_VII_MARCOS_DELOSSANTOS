<?php
// index.php

require_once __DIR__ . '/includes/funciones.php';
include_once __DIR__ . '/includes/header.php';

$libros = obtenerLibros();

// Ordenar libros por título (puedes cambiar a 'autor' si lo prefieres)
usort($libros, function($a, $b) {
    return strcmp($a['titulo'], $b['titulo']);
});
?>

<div class="catalogo">
    <h2>Catálogo de Libros</h2>
    <?php foreach ($libros as $libro): ?>
        <div class="libro">
            <?php echo mostrarDetallesLibro($libro); ?>
        </div>
    <?php endforeach; ?>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>