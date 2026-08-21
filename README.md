# Cherry — Plataforma de tienda, ventas e inventario

Cherry es una plataforma web para administrar la operación de una tienda y ofrecer un catálogo de productos en línea. Integra escaparate público, registro de clientes, carrito, checkout, control de existencias, proveedores, usuarios, envíos, reportes y emisión de tickets PDF.

Este documento sirve como presentación funcional y manual de instalación para clientes, distribuidores, personal de soporte e implementadores.

> **Importante:** la entrega debe incluir por separado los términos de licencia comercial, alcance del soporte, vigencia de actualizaciones y datos de contacto del proveedor. Este repositorio no contiene todavía una licencia comercial propia.

## Contenido

- [Funciones principales](#funciones-principales)
- [Tecnologías y componentes](#tecnologías-y-componentes)
- [Requisitos del servidor](#requisitos-del-servidor)
- [Instalación rápida](#instalación-rápida)
- [Instalación paso a paso](#instalación-paso-a-paso)
- [Acceso inicial](#acceso-inicial)
- [Configuración para producción](#configuración-para-producción)
- [Operación y mantenimiento](#operación-y-mantenimiento)
- [Solución de problemas](#solución-de-problemas)
- [Alcance comercial y seguridad](#alcance-comercial-y-seguridad)

## Funciones principales

### Tienda y experiencia de compra

- Catálogo público organizado por categorías y secciones.
- Consulta de productos, precios y disponibilidad.
- Carrito de compras almacenado en la sesión del navegador.
- Registro e inicio de sesión de clientes.
- Checkout con validación de existencias en tiempo real.
- Registro operativo de pagos en efectivo, tarjeta o vales.
- Cálculo de efectivo recibido y cambio.
- Registro de pedidos, partidas y movimientos de salida.
- Generación de ticket de compra en PDF con formato de 80 mm.
- Página informativa de sucursales con mapas integrados.

### Administración comercial

- Gestión de productos y stock.
- Control de lotes, ubicación, mínimos, máximos y vencimientos.
- Registro de entradas y salidas para seguimiento de inventario.
- Búsqueda y filtros avanzados de existencias.
- Activación, desactivación y restauración de registros.
- Exportación del stock filtrado a Excel.
- Gestión de proveedores y marcas asociadas.
- Gestión de clientes, domicilios y datos de envío.
- Administración de usuarios y consulta de roles.
- Reportes de ventas por rango de fechas.
- Generación de tickets PDF de ventas y pedidos.

### Roles contemplados

El modelo incluye roles para administrador, supervisor, vendedor, almacén, contador, cliente, soporte técnico, compras, recursos humanos, invitado y abogado. La matriz de permisos está definida en el modelo de usuario.

> La existencia de roles no implica que todas las rutas administrativas estén protegidas automáticamente. Antes de publicar el sistema se debe aplicar y validar el middleware de autenticación, autorización y roles de acuerdo con la licencia o implementación contratada.

## Tecnologías y componentes

| Componente | Tecnología | Uso |
|---|---|---|
| Backend | PHP 8.1+ y Laravel 10 | Lógica, rutas, validaciones, sesiones y acceso a datos |
| Base de datos | PostgreSQL | Catálogos, usuarios, pedidos, ventas, pagos e inventario |
| Frontend | Blade, JavaScript, CSS y Vite 5 | Interfaz y compilación de estilos |
| UI | Bootstrap 5, Bootstrap Icons y Font Awesome | Diseño e iconografía |
| Tablas | jQuery DataTables | Consultas, paginación y filtros |
| Formularios | Select2 y SweetAlert2 | Selectores y mensajes interactivos |
| PDF | DOMPDF | Tickets de compra y venta |
| Excel | Laravel Excel / PhpSpreadsheet | Exportación de existencias |
| Autenticación | Laravel Auth y Sanctum | Sesiones web y base para API autenticada |
| Pruebas | PHPUnit 10 | Pruebas automatizadas |

Algunas bibliotecas visuales se cargan desde CDN. El servidor y los equipos cliente necesitan acceso a internet para obtener Bootstrap, DataTables, jQuery, Select2, SweetAlert2, iconos y traducciones externas. Para instalaciones aisladas se deben alojar esos recursos localmente.

## Requisitos del servidor

### Requisitos mínimos

- PHP 8.1 o superior.
- Extensiones PHP: `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `pdo`, `pdo_pgsql`, `session`, `tokenizer`, `xml` y `zip`.
- PostgreSQL 13 o superior recomendado.
- Composer 2.x.
- Node.js 18 o superior y npm.
- Servidor web Apache 2.4 o Nginx.
- Acceso de escritura para el usuario del servidor web en `storage/` y `bootstrap/cache/`.
- Navegador moderno con JavaScript habilitado.

### Recursos sugeridos

Para una instalación pequeña o de demostración: 2 núcleos de CPU, 2 GB de RAM y 2 GB libres, además del espacio requerido por la base de datos y respaldos. La capacidad final debe calcularse según usuarios concurrentes, catálogo, transacciones y retención de reportes.

### Compatibilidad de base de datos

La versión actual está orientada a **PostgreSQL**: utiliza búsquedas `ILIKE`, secuencias de PostgreSQL y sentencias `TRUNCATE ... CASCADE` en los datos de demostración. No se debe configurar MySQL sin adaptar previamente esas consultas y seeders.

## Instalación rápida

Para un ambiente local de evaluación:

```bash
git clone <URL-DE-LA-ENTREGA> cherry
cd cherry
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Edite `.env` para usar PostgreSQL, cree la base y después ejecute:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

Abra `http://127.0.0.1:8000`.

> En Windows PowerShell, use `Copy-Item .env.example .env` en lugar de `cp .env.example .env`.

## Instalación paso a paso

### 1. Copiar el sistema

Obtenga el paquete entregado por el proveedor o clone el repositorio autorizado. Coloque el proyecto fuera de carpetas públicas genéricas cuando sea posible; el servidor web debe exponer únicamente el directorio `public/`.

### 2. Instalar las dependencias PHP

Desde la raíz del proyecto:

```bash
composer install --no-interaction
```

Para producción utilice:

```bash
composer install --no-dev --optimize-autoloader --no-interaction
```

### 3. Instalar y compilar los recursos frontend

```bash
npm ci
npm run build
```

El comando genera los recursos versionados que Laravel sirve desde `public/build/`. Durante desarrollo puede utilizar `npm run dev`.

### 4. Crear la base de datos PostgreSQL

Ejemplo con `psql` y un usuario con permisos administrativos:

```sql
CREATE USER cherry_app WITH ENCRYPTED PASSWORD 'CAMBIE_ESTA_CLAVE';
CREATE DATABASE cherry OWNER cherry_app ENCODING 'UTF8';
```

Use una contraseña única y segura. No reutilice las credenciales del servidor ni conceda permisos de superusuario a la cuenta de la aplicación.

### 5. Crear y configurar `.env`

Copie el archivo de ejemplo:

```bash
cp .env.example .env
```

Configure como mínimo:

```dotenv
APP_NAME="Cherry"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://tienda.ejemplo.com

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=cherry
DB_USERNAME=cherry_app
DB_PASSWORD=CAMBIE_ESTA_CLAVE

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

Genere la clave de cifrado:

```bash
php artisan key:generate
```

No comparta ni incluya `.env` en la entrega pública o en el control de versiones.

### 6. Crear las tablas

#### Instalación productiva sin datos de muestra

```bash
php artisan migrate --force
```

Después cree el primer administrador mediante un procedimiento controlado del proveedor, una consola administrativa protegida o una instrucción SQL segura. No use cuentas de demostración en producción.

#### Instalación de demostración

```bash
php artisan migrate --seed
```

Los seeders cargan catálogos, productos, usuarios, clientes, proveedores y existencias de prueba.

> **Advertencia:** algunos seeders ejecutan `TRUNCATE ... CASCADE`; pueden borrar y reemplazar información existente. Ejecute `--seed` solamente en una base nueva, de demostración o después de un respaldo verificado.

### 7. Preparar cachés y permisos

En Linux, asigne al usuario del servidor web permisos de escritura sobre:

```text
storage/
bootstrap/cache/
```

Luego optimice Laravel:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Si modifica `.env`, limpie y regenere la configuración:

```bash
php artisan optimize:clear
php artisan config:cache
```

### 8. Configurar el servidor web

#### Apache

- Habilite `mod_rewrite`.
- Defina el `DocumentRoot` apuntando a `<proyecto>/public`.
- Permita que Laravel procese las rutas mediante el `.htaccess` de `public/`.
- Configure HTTPS y redireccione HTTP a HTTPS.

Ejemplo conceptual:

```apache
<VirtualHost *:443>
    ServerName tienda.ejemplo.com
    DocumentRoot /var/www/cherry/public

    <Directory /var/www/cherry/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx

Configure la raíz en `<proyecto>/public` y envíe las rutas inexistentes a `index.php`:

```nginx
root /var/www/cherry/public;
index index.php;

location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

La configuración completa de PHP-FPM, TLS, límites y logs depende del servidor contratado.

### 9. Verificar la instalación

```bash
php artisan about
php artisan migrate:status
php artisan test
```

Compruebe manualmente:

1. Apertura de `/home` y carga de categorías.
2. Registro e inicio de sesión.
3. Alta o consulta de un producto de prueba.
4. Agregar al carrito y completar una compra.
5. Descuento correcto de existencias.
6. Apertura del ticket PDF.
7. Exportación de stock a Excel.
8. Consulta de clientes, proveedores, envíos y reportes.

## Acceso inicial

La carga de demostración crea la siguiente cuenta:

| Campo | Valor de demostración |
|---|---|
| Correo | `admin@cherry.com` |
| Contraseña | `123456` |

Cambie o elimine esta cuenta inmediatamente. Estas credenciales son públicas dentro del código fuente y **no son aptas para producción**.

La pantalla de acceso está en `/login`; el registro de clientes está en `/register`.

## Configuración para producción

Antes de entregar el sistema al cliente final:

- Use `APP_ENV=production` y `APP_DEBUG=false`.
- Configure un dominio, certificado TLS y redirección obligatoria a HTTPS.
- Sustituya todas las credenciales de demostración.
- Proteja paneles y endpoints administrativos con autenticación y autorización por rol.
- Retire la ruta de prueba `/test-vista/{slug}`.
- Revise que el registro público de clientes sea apropiado para el negocio.
- Defina políticas de contraseña, bloqueo, recuperación y sesiones.
- Configure cookies seguras (`SESSION_SECURE_COOKIE=true`) bajo HTTPS.
- Valide CORS, límites de carga, encabezados de seguridad y protección CSRF.
- Mantenga `storage/logs` fuera del acceso público y rote sus archivos.
- Automatice respaldos cifrados de PostgreSQL y pruebe su restauración.
- Instale monitoreo de disponibilidad, espacio, errores y vencimiento del certificado.
- Ejecute `composer audit`, `npm audit` y las pruebas antes de cada liberación.
- Confirme conectividad con los CDN o aloje las dependencias frontend localmente.

### Pagos

El módulo actual captura información operativa y referencias de efectivo, tarjeta y vales; no realiza cargos, conciliaciones ni devoluciones con un banco. Para vender en línea se debe integrar una pasarela certificada y evitar almacenar datos completos de tarjetas. La aplicación actual conserva únicamente datos operativos como marca, tipo, últimos cuatro dígitos y referencia.

### Correo

El `.env.example` usa Mailpit para desarrollo. Si se habilitan notificaciones o recuperación de contraseñas, configure un servicio SMTP real y pruebe el envío antes de producción.

## Operación y mantenimiento

### Respaldo de base de datos

Ejemplo:

```bash
pg_dump --format=custom --file=cherry_YYYYMMDD.dump --dbname=cherry --username=cherry_app
```

Guarde los respaldos fuera del servidor principal, cifrados y con una política de retención. Verifique periódicamente la restauración en un ambiente separado.

### Actualización de la plataforma

Antes de actualizar:

1. Active una ventana de mantenimiento.
2. Respalde base de datos, `.env` y archivos persistentes.
3. Revise las notas de versión del proveedor.
4. Instale dependencias y compile frontend.
5. Ejecute migraciones.
6. Regenere cachés y ejecute pruebas.
7. Valide compra, stock, tickets y reportes antes de reabrir.

Comandos habituales:

```bash
php artisan down
composer install --no-dev --optimize-autoloader --no-interaction
npm ci
npm run build
php artisan migrate --force
php artisan optimize
php artisan up
```

### Logs

Los registros se almacenan normalmente en `storage/logs/laravel.log`. No publique este archivo ni lo envíe sin revisar datos sensibles. Para observar errores recientes durante soporte:

```bash
php artisan pail
```

Si `pail` no está instalado en esta versión, consulte directamente el archivo de log con las herramientas del sistema operativo.

## Solución de problemas

### Error `could not find driver`

Habilite `pdo_pgsql` en el PHP que utiliza Composer, la terminal y el servidor web. Reinicie Apache o PHP-FPM después del cambio.

### Error de conexión a PostgreSQL

Revise `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`; confirme además que PostgreSQL acepte conexiones desde el servidor de la aplicación.

### Error con `ILIKE`, `setval` o `pg_get_serial_sequence`

La aplicación se está ejecutando con un motor distinto de PostgreSQL. Cambie `DB_CONNECTION=pgsql` o solicite al proveedor una adaptación compatible con el motor requerido.

### Error 500 después de cambiar `.env`

```bash
php artisan optimize:clear
php artisan config:cache
```

Después revise `storage/logs/laravel.log`.

### Vite manifest not found

```bash
npm ci
npm run build
```

Confirme que existe `public/build/manifest.json` y que el servidor puede leerlo.

### No se generan PDF o Excel

- Ejecute `composer install` y confirme que las extensiones `dom`, `mbstring`, `xml` y `zip` estén habilitadas.
- Verifique memoria disponible y permisos temporales/escritura.
- Consulte el log de Laravel para identificar el error exacto.

### La interfaz aparece sin estilos o las tablas no funcionan

Revise la conexión a los CDN indicados en [Tecnologías y componentes](#tecnologías-y-componentes). En redes cerradas, instale esos recursos dentro de `public/` y actualice las plantillas.

### Permiso denegado en `storage` o `bootstrap/cache`

Otorgue propiedad o permisos de escritura únicamente al usuario que ejecuta PHP. Evite permisos globales `777` en producción.

## Estructura del proyecto

```text
app/                 Modelos, controladores, servicios y exportaciones
bootstrap/           Arranque y caché del framework
config/              Configuración de Laravel
database/migrations/ Estructura versionada de la base de datos
database/seeders/    Catálogos y datos de demostración
public/              Punto de entrada y recursos públicos
resources/views/     Pantallas Blade
resources/css/       Estilos compilados con Vite
routes/               Rutas web, API y consola
storage/              Logs, sesiones, cachés y archivos internos
tests/                Pruebas automatizadas
```

## Alcance comercial y seguridad

Para una venta profesional, el contrato o ficha de entrega debe definir expresamente:

- Tipo de licencia: perpetua, suscripción, por sucursal, dominio o número de usuarios.
- Ambientes incluidos: producción, pruebas y desarrollo.
- Instalación, migración de datos, personalización y capacitación incluidas.
- Horario, canal, tiempos de respuesta y exclusiones del soporte.
- Periodo de garantía y política de actualizaciones.
- Responsabilidad de respaldos, hosting, dominio, TLS y servicios de terceros.
- Propiedad del código fuente, restricciones de redistribución y uso de componentes de terceros.
- Tratamiento de datos personales y cumplimiento legal aplicable.
- Alcance real de pagos: registro operativo o integración con una pasarela.

El nombre, logotipo, datos de sucursales, productos de muestra, correos, mapas y credenciales deben personalizarse antes de entregar cada instancia.

## Soporte

Complete estos datos antes de distribuir el producto:

- **Proveedor:** `[NOMBRE DE LA EMPRESA]`
- **Correo:** `[SOPORTE@EJEMPLO.COM]`
- **Teléfono:** `[TELÉFONO]`
- **Portal de soporte:** `[URL]`
- **Horario:** `[DÍAS Y HORARIO, ZONA HORARIA]`
- **Versión del producto:** `[VERSIÓN]`

Al solicitar ayuda incluya la versión, ambiente, pasos para reproducir el problema y fragmentos relevantes del log, sin compartir contraseñas, claves privadas ni datos personales.
