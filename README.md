# Configuración de Laravel con SQLite en WSL

Este proyecto documenta los pasos realizados para configurar un entorno de desarrollo en Laravel utilizando SQLite en Windows con WSL.

## Pasos realizados

### 1. Instalación de dependencias

Ejecutamos los siguientes comandos para asegurarnos de que SQLite y las extensiones necesarias estén instaladas:

```sh
sudo apt update && sudo apt install php8.3-sqlite3 sqlite3
```

Verificamos que la extensión de SQLite está habilitada en PHP:

```sh
php -m | grep sqlite
```

Si aparece `sqlite3` en la salida, la instalación fue exitosa.

### 2. Configuración de Laravel para SQLite

Editamos el archivo `.env` en la raíz del proyecto y configuramos la base de datos para que use SQLite:

```ini
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/completa/hacia/database.sqlite
DB_FOREIGN_KEYS=true
```

Creamos el archivo de base de datos si no existe:

```sh
touch database/database.sqlite
```

### 3. Migraciones

Ejecutamos las migraciones para crear las tablas necesarias:

```sh
php artisan migrate
```

### 4. Solución de errores

Si aparece un error del tipo `could not find driver`, verificamos que la extensión `sqlite3` está habilitada en el archivo de configuración de PHP (`php.ini`).

Si aparece un error sobre `no such table: sessions`, ejecutamos:

```sh
php artisan migrate --path=database/migrations
```

### 5. Ejecución del servidor de desarrollo

Finalmente, iniciamos el servidor de Laravel:

```sh
php artisan serve
```

Accedemos a la aplicación en `http://127.0.0.1:8000/`.

---

Este archivo se actualizará a medida que avancemos en la configuración y desarrollo del proyecto.
