# NATATORIO - SISTEMA DE GESTIÓN

## DESCRIPCIÓN
-------------
El proyecto "Natatorio" consiste en la modernización de un sistema de gestión para natatorios desarrollado originalmente en ADA 95. Mediante ingeniería inversa y directa, se rediseñará como aplicación web en Laravel, mejorando su arquitectura y añadiendo funcionalidades que respondan a necesidades actuales.

## EQUIPO DE DESARROLLO
--------------------
* Gomes dos Ramos Ignacio - nacho.gdr24@gmail.com
* Mansilla Maximiliano - maximansilla902@gmail.com
* Silvestre Thalia - thaliasilvestre042@gmail.com

## REQUISITOS DEL SISTEMA
------------------------
* PHP >= 8.2
* Composer
* Node.js >= 20.x
* NPM
* MySQL >= 8.0 o PostgreSQL >= 13
* Git

## INSTALACIÓN
-------------

### 1. Clonar el repositorio
```bash
git clone https://github.com/Maxpa902/is-proyecto-2025.git
cd is-proyecto-2025
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar variables de entorno
```bash
cp .env.example .env
```

Edita el archivo `.env` con tus datos:
```env
APP_NAME=Natatorio
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=natatorio
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Generar clave de aplicación
```bash
php artisan key:generate
```

### 6. Configurar base de datos
Crear la base de datos:
```sql
CREATE DATABASE natatorio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Ejecutar migraciones:
```bash
php artisan migrate
```

### 7. Seeders
```bash
php artisan db:seed
```

### 8. Compilar assets
```bash
npm run dev
```

### 9. Iniciar servidor de desarrollo
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## COMANDOS ÚTILES
-----------------
```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar la aplicación
php artisan optimize:clear

# Ejecutar tests
php artisan test

# Rollback de migraciones
php artisan migrate:rollback

# Reejecutar migraciones
php artisan migrate:refresh

# Con seeders
php artisan migrate:refresh --seed
```
