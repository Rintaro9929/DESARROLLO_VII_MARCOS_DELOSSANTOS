<?php
// 1. Crear un arreglo de 10 nombres de ciudades
$ciudades = ["Nueva York", "Tokio", "Londres", "París", "Sídney", "Río de Janeiro", "Moscú", "Berlín", "Ciudad del Cabo", "Toronto"];

// 2. Imprimir el arreglo original
echo "Ciudades originales:\n";
print_r($ciudades);

// 3. Agregar 2 ciudades más al final del arreglo
array_push($ciudades, "Dubái", "Singapur");

// 4. Eliminar la tercera ciudad del arreglo
array_splice($ciudades, 2, 1);

// 5. Insertar una nueva ciudad en la quinta posición
array_splice($ciudades, 4, 0, "Mumbai");

// 6. Imprimir el arreglo modificado
echo "\nCiudades modificadas:\n";
print_r($ciudades);

// 7. Crear una función que imprima las ciudades en orden alfabético
function imprimirCiudadesOrdenadas($arr) {
    $ordenado = $arr;
    sort($ordenado);
    echo "Ciudades en orden alfabético:\n";
    foreach ($ordenado as $ciudad) {
        echo "- $ciudad\n";
    }
}

// 8. Llamar a la función
imprimirCiudadesOrdenadas($ciudades);

// TAREA: Crea una función que cuente y retorne el número de ciudades que comienzan con una letra específica
function contarCiudadesPorInicial($ciudades, $letra) {
    $contador = 0;
    $letra = strtoupper($letra); // Convertir a mayúscula para hacer la comparación case-insensitive
    
    foreach ($ciudades as $ciudad) {
        // Obtener la primera letra de cada ciudad y convertirla a mayúscula
        $primeraLetra = strtoupper(substr(trim($ciudad), 0, 1));
        
        // Comparar si coincide con la letra buscada
        if ($primeraLetra === $letra) {
            $contador++;
        }
    }
    
    return $contador;
}

// Ejemplos de uso de la función
echo "\n--- Pruebas de la función contarCiudadesPorInicial ---\n";
echo "Ciudades que empiezan con 'S': " . contarCiudadesPorInicial($ciudades, 'S') . "\n";
echo "Ciudades que empiezan con 'M': " . contarCiudadesPorInicial($ciudades, 'M') . "\n";
echo "Ciudades que empiezan con 'B': " . contarCiudadesPorInicial($ciudades, 'B') . "\n";
echo "Ciudades que empiezan con 'T': " . contarCiudadesPorInicial($ciudades, 'T') . "\n";

// Mostrar todas las ciudades para referencia
echo "\nLista actual de ciudades:\n";
foreach ($ciudades as $ciudad) {
    echo "- $ciudad\n";
}
?>