# Proyecto Final: Sistema de Gestión de Estudiantes

Este proyecto consiste en desarrollar un sistema completo para la gestión de estudiantes utilizando PHP, aplicando conceptos avanzados de arreglos y programación orientada a objetos.

## Características Principales

- **Gestión de estudiantes:** Alta, consulta, listado y graduación de estudiantes.
- **Manipulación avanzada de arreglos:** Uso de arreglos asociativos y multidimensionales.
- **Programación orientada a objetos:** Clases `Estudiante` y `SistemaGestionEstudiantes` con métodos robustos y type hinting.
- **Funcionalidades avanzadas:** Búsqueda, filtrado, generación de reportes, ranking, estadísticas por carrera y sistema de flags.
- **Funciones de orden superior:** Uso de `array_map`, `array_filter`, `array_reduce`, entre otras.
- **Manejo de errores:** Validación y gestión de casos excepcionales.
- **Método `__toString()`:** Para impresión sencilla de información de estudiantes.

## Uso del Sistema

1. **Instalación:**  
    Coloca el archivo `proyecto_final.php` en la carpeta `TALLER_5`.

2. **Ejecución:**  
    Ejecuta el script en tu entorno PHP.  
    Ejemplo:
    ```bash
    php proyecto_final.php
    ```

3. **Pruebas Incluidas:**  
    El script incluye una sección de pruebas donde se crean al menos 10 estudiantes, se demuestran todas las funcionalidades y se muestran los resultados de forma clara y organizada.

## Funcionalidades Implementadas

- **Agregar, listar y buscar estudiantes** por ID, nombre o carrera (búsqueda parcial e insensible a mayúsculas/minúsculas).
- **Gestión de materias y calificaciones** por estudiante.
- **Cálculo de promedios** individuales y generales.
- **Ranking de estudiantes** por promedio.
- **Reporte de rendimiento** por materia (promedio, máxima y mínima calificación).
- **Graduación de estudiantes** y gestión de graduados.
- **Estadísticas por carrera:** Número de estudiantes, promedio general y mejor estudiante.
- **Sistema de flags:** Identificación de estudiantes en riesgo académico, cuadro de honor, etc.

## Retos Adicionales (Opcionales)

- **Persistencia en JSON:** Guardado y carga de datos en archivo JSON.
- **Interfaz de línea de comandos:** Interacción directa con el sistema.
- **Validación de datos:** Control de rangos y formatos válidos.

## Recomendaciones

- Revisa los comentarios en el código para entender la lógica de las implementaciones más complejas.
- El código sigue las mejores prácticas de PHP y es fácil de leer y mantener.
