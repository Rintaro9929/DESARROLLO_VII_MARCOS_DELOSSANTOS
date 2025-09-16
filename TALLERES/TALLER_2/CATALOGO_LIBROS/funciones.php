<?php
// CATALOGO_LIBROS/includes/funciones.php

/**
 * Retorna un array de libros simulando una base de datos.
 * @return array
 */
function obtenerLibros() {
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio_publicacion' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'anio_publicacion' => 1967,
            'genero' => 'Realismo mágico',
            'descripcion' => 'La saga de la familia Buendía en Macondo.'
        ],
        [
            'titulo' => 'Rayuela',
            'autor' => 'Julio Cortázar',
            'anio_publicacion' => 1963,
            'genero' => 'Novela',
            'descripcion' => 'Una novela experimental sobre la vida y el amor en París y Buenos Aires.'
        ],
        [
            'titulo' => 'Pedro Páramo',
            'autor' => 'Juan Rulfo',
            'anio_publicacion' => 1955,
            'genero' => 'Novela',
            'descripcion' => 'Un hombre viaja a Comala en busca de su padre.'
        ],
        [
            'titulo' => 'La sombra del viento',
            'autor' => 'Carlos Ruiz Zafón',
            'anio_publicacion' => 2001,
            'genero' => 'Misterio',
            'descripcion' => 'Un joven descubre un libro que cambiará su vida en la Barcelona de posguerra.'
        ]
    ];
}

/**
 * Retorna una cadena HTML con los detalles de un libro.
 * @param array $libro
 * @return string
 */
function mostrarDetallesLibro($libro) {
    $html = '<div class="libro">';
    $html .= '<h2>' . htmlspecialchars($libro['titulo']) . '</h2>';
    $html .= '<p><strong>Autor:</strong> ' . htmlspecialchars($libro['autor']) . '</p>';
    $html .= '<p><strong>Año de publicación:</strong> ' . htmlspecialchars($libro['anio_publicacion']) . '</p>';
    $html .= '<p><strong>Género:</strong> ' . htmlspecialchars($libro['genero']) . '</p>';
    $html .= '<p>' . htmlspecialchars($libro['descripcion']) . '</p>';
    $html .= '</div>';
    return $html;
}

/**
 * Ordena un array de libros por título o autor.
 * @param array $libros
 * @param string $criterio ('titulo' o 'autor')
 * @return array
 */
function ordenarLibros($libros, $criterio = 'titulo') {
    usort($libros, function($a, $b) use ($criterio) {
        return strcmp($a[$criterio], $b[$criterio]);
    });
    return $libros;
}
?>