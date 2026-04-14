# Laboratorio: Implementación de Login en Laravel

## 👤 Datos del Estudiante
- **Nombre:** Marcos De Los Santos
- **Correo:** marcos.delossantos@utp.ac.pa
- **Curso:** Desarrollo Web VII
- **Instructor:** Ing. Irina Fong
- **Fecha de ejecución:** 09 de abril de 2026

---

## 📋 Requisitos Previos

| Tecnología | Versión |
|------------|---------|
| 🐘 PHP | 8.2.12 |
| 📦 Composer | última versión estable |
| 🚀 Laravel | 10.x |
| 🖥️ XAMPP | con Apache y MySQL |
| 🗄️ MySQL | 8.0 |
| ✏️ VS Code | Editor de código |
| 🟢 Node.js | v22.16.0 |

**Sistema Operativo:** Windows 11

---

## 📁 Estructura MVC en Laravel

| Carpeta | Función |
|---------|---------|
| `app/Http/Controllers` | Controladores - Contienen la lógica de la aplicación |
| `routes/web.php` | Rutas - Definen las URLs y a qué controlador responden |
| `resources/views` | Vistas - Archivos Blade con el HTML de la interfaz |
| `app/Models` | Modelos - Representan las tablas de la base de datos |

**Objetivo del laboratorio:** Implementar un sistema de autenticación (login y registro) en Laravel utilizando el patrón MVC, comprendiendo la interacción entre rutas, controladores, vistas y base de datos.

---

# ============================================
# 📁 1. CREACIÓN DEL PROYECTO LARAVEL
# ============================================
cd C:\xampp\htdocs
composer create-project laravel/laravel:^10.0 example-app
cd example-app

# ============================================
# ⚙️ 2. CONFIGURACIÓN DEL ENTORNO
# ============================================
copy .env.example .env
notepad .env   # Configurar credenciales de la base de datos

# ============================================
# 🔑 3. GENERAR CLAVE DE LA APLICACIÓN
# ============================================
php artisan key:generate

# ============================================
# 🔐 4. INSTALAR AUTENTICACIÓN (Laravel UI)
# ============================================
composer require laravel/ui
php artisan ui bootstrap --auth

# ============================================
# 🎨 5. INSTALAR DEPENDENCIAS FRONTEND
# ============================================
npm install
npm run build

# ============================================
# 🗄️ 6. CREACIÓN DE LA BASE DE DATOS
# ============================================
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"

# ============================================
# 📊 7. EJECUCIÓN DE MIGRACIONES
# ============================================
php artisan migrate

# ============================================
# 🧹 8. COMANDOS DE MANTENIMIENTO / ERRORES
# ============================================
php artisan config:clear      # Limpia caché de configuración
php artisan migrate:fresh     # Recreate tablas (elimina y vuelve a migrar)

# ============================================
# 🔍 9. VERIFICACIÓN DE BASE DE DATOS
# ============================================
C:\xampp\mysql\bin\mysql.exe -u root -e "SHOW DATABASES;"
C:\xampp\mysql\bin\mysql.exe -u root -e "USE laravel; SHOW TABLES;"

# ============================================
# 🚀 10. INICIAR SERVIDOR DE DESARROLLO
# ============================================
php artisan serve

# ============================================
# 💾 11. BACKUP DE LA BASE DE DATOS
# ============================================
C:\xampp\mysql\bin\mysqldump.exe -u root laravel > backup_laravel.sql