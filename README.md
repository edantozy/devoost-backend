# Devoost API en Laravel

Este es el repositorio del backend de la prueba técnica de Devoost, este proyecto es una API REST construida con [Laravel 11](https://laravel.com/docs/11.x), que sigue las instrucciones siguientes:

<!-- Crear un sistema en Laravel con frontend en VueJS o React y TailwindCss
El sistema debe permitir hacer login, registrar un nuevo usuario y recuperar la contraseña.
El sistema debe tener una vista de lista de Ordenes
Al dar click sobre cada orden se puede ver el detalle de la orden: Cliente (catalogo), datos generales de la orden (fecha, numero, etc) y el listado de productos (catalogo)
El sistema puede crear o cancelar ordenes pero no puede eliminar.
El sistema puede agregar, editar, eliminar items a la orden y el subtotal debe ir cambiando sin refrescar la página. -->

- Crear un sistema en Laravel con frontend en VueJS o React y TailwindCss.
- El sistema debe permitir hacer login, registrar un nuevo usuario y recuperar la contraseña.
- El sistema debe tener una vista de lista de Órdenes.
- Al dar click sobre cada orden se puede ver el detalle de la orden: Cliente (catalogo), datos generales de la orden (fecha, numero, etc) y el listado de productos (catalogo).
- El sistema puede crear o cancelar ordenes pero no puede eliminar.
- El sistema puede agregar, editar, eliminar items a la orden y el subtotal debe ir cambiando sin refrescar la página.

## Requisitos previos

Asegúrate de tener instalados los siguientes componentes en tu sistema antes de continuar:

- **PHP >= 8.1**
- **Composer** (para la gestión de dependencias de PHP)
- **MySQL** o cualquier otra base de datos compatible

## Instalación y configuración

Sigue estos pasos para instalar y configurar el proyecto:

1. **Clona el repositorio en tu máquina local.**

2. **Instala las dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Configura el archivo de entorno (.env):**
   - Duplica el archivo `.env.example` y renómbralo a `.env`.
   - Configura las variables de entorno en el archivo `.env`, como la conexión a la base de datos. Asegúrate de que el archivo incluya lo siguiente:

     ```plaintext
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=nombre_de_tu_base_de_datos
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
     ```

4. **Genera la clave de aplicación de Laravel:**
   ```bash
   php artisan key:generate
   ```

5. **Ejecuta las migraciones de la base de datos:**
   Esto creará las tablas necesarias en la base de datos.
   ```bash
   php artisan migrate
   ```

6. **Ejecuta el seed para llenar la base de datos:**
   ```bash
   php artisan db:seed
   ```

## Ejecución de la aplicación

Para ejecutar la aplicación en un servidor de desarrollo, usa el siguiente comando:

```bash
php artisan serve
```

Esto iniciará el servidor en [http://localhost:8000](http://localhost:8000) de forma predeterminada.

## Endpoints de la API

### Autenticación

- `POST /api/register` - Registro de un nuevo usuario.

- `POST /api/login` - Inicio de sesión.

- `POST /api/sendPasswordResetLink` - Simula enviar un enlace de restablecimiento de contraseña.


### Pedidos (Orders)

- `GET /api/orders` - Lista de todos los pedidos. *(Requiere autenticación)*
- `GET /api/orders/{order}` - Muestra los detalles de un pedido específico. *(Requiere autenticación)*
- `POST /api/orders` - Crea un nuevo pedido. *(Requiere autenticación)*
- `PUT /api/orders/{order}` - Actualiza un pedido existente. *(Requiere autenticación)*

### Clientes (Clients)

- `GET /api/clients` - Lista de todos los clientes registrados. *(Requiere autenticación)*

### Productos (Products)

- `GET /api/products` - Lista de todos los productos disponibles. *(Requiere autenticación)*

## Despliegue

Para desplegar esta aplicación en un servidor de producción, asegúrate de:

1. Configurar las variables de entorno adecuadamente en el archivo `.env`.
2. Ejecutar `composer install --optimize-autoloader --no-dev`.
3. Ejecutar `php artisan migrate --force`.

## Licencia

Este proyecto está licenciado bajo la licencia MIT.