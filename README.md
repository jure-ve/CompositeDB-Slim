# CompositeDB-Slim (Composite DB con Slim)

Esta aplicación es un ejemplo práctico que integra Composite DB (un ORM ligero para PHP) con Slim Framework, utilizando SQLite como base de datos. Su propósito principal es demostrar la implementación de Composite DB en un proyecto con Slim Framework, facilitando el desarrollo de aplicaciones web pequeñas o prototipos mediante una estructura básica para crear y gestionar usuarios.

## Requisitos

* PHP 8.1 o superior 
* Composer instalado ([https://getcomposer.org/](https://getcomposer.org/))
* Una base de datos compatible con Composite DB (en este ejemplo usamos SQLite)

## Instalación

1.  Clona el repositorio:
    ```bash
    git clone https://github.com/jure-ve/CompositeDB-Slim
    cd CompositeDB-Slim
    ```

2.  Instala las dependencias de Composer:
    ```bash
    composer install
    ```

## Configuración

1. La aplicación está implementada para que luego de usar `composer` puedas usarla inmediatamente sin cambios, usa una base de datos SQLite que esta ubicada en el directorio `database` 

## Configuración de la Base de Datos

La base de datos tiene unos datos previamente incluidos pero si necesitas inicializar la base de datos (crear las tablas, etc.). Para hacer esto, descomenta la siguiente línea en tu archivo `public/index.php` y luego ejecuta la aplicación una vez:

```php
// $container->get(\App\Table\UsersTable::class)->init();
```

Después de la primera ejecución exitosa, puedes volver a comentar esta línea.

## Ejecución de la Aplicación

Puedes ejecutar la aplicación utilizando el servidor de desarrollo integrado de PHP:

```bash
php -S localhost:8000 -t public
```

Luego, puedes acceder a la aplicación en tu navegador o mediante herramientas como Postman en `http://localhost:8000`.

## Endpoints de la API

* **`GET /`**: Muestra un json con un mensaje de bienvenida.
* **`GET /users`**: Devuelve un json con una lista de todos los usuarios activos
* **`POST /users`**: Crea un nuevo usuario basado en los datos proporcionados en el cuerpo de la petición

### **Ejemplos de uso de endpoints**

#### 1. **Obtener mensaje de bienvenida**

```bash
curl -X GET http://localhost:8000/
```

**Respuesta exitosa (200 OK):**

```json
{
    "status": "success",
    "message": "Esta App implementa Composite DB en Slim con unos sencillos ejemplos de uso.",
    "documentation": "Ver README.md para más detalles."
}
```

---

#### 2. **Listar usuarios activos**

```bash
curl -X GET http://localhost:8000/users
```

**Respuesta exitosa (200 OK):**

```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "email": "user@example.com",
            "name": "John",
            "is_test": false,
            "status": "ACTIVE",
            "created_at": "2025-04-10 22:24:20.128227"
        },
        {
            "id": 2,
            "email": "user@example.com",
            "name": "Martie",
            "is_test": false,
            "status": "ACTIVE",
            "created_at": "2025-04-10 22:56:49.105486"
        }
    ],
    "message": "Usuarios activos obtenidos correctamente"
}
```

---

#### 3. **Crear un nuevo usuario**

```bash
curl -X POST http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{
        "email": "nuevo@example.com",
        "name": "Carlos Gómez"
      }'
```

**Respuesta exitosa (201 Created):**

```json
{
    "data": {
        "id": 3,
        "email": "mail@mail.com",
        "name": "Ginger",
        "is_test": false,
        "status": "BLOCKED",
        "created_at": "2025-04-11 15:12:45.608387"
    },
    "message": "Usuario creado correctamente"
}
```

**Posible error (400 Bad Request):**

```json
{
    "error": "Se requiere un email válido"
}
```

## Estructura del proyecto
```
CompositeDB-Slim/
├── public/
│   └── index.php # Punto de entrada
├── src/
│   ├── Controllers/
│   │   ├── UserController.php # Lógica Get y Post de Users
│   │   └── RootController.php # Ruta raíz
│   ├── Config/
│   │   └── ConnectionManager.php # Configura conexión SQLite.
│   ├── Entity/
│   │   └── User.php # Representación de User
│   ├── Enums/
│   │   └── Status.php # Estados posibles de User.
│   └── Table/
│       └── UserTable.php # Implementación de AbstractTable de persistencia y consultas de User.
├── vendor/             # Dependencias
├── .env                # archivo de Variables
├── composer.json       # Configuración de Composer
└── README.md           # Documentación
```

## Dependencias Principales

* [Composite DB](https://github.com/compositephp/db): Es un PHP DataMapper y Table Gateway ligero y rápido que le permite representar su esquema de tablas SQL en estilo OOP utilizando todo el poder de la sintaxis de clase PHP 8.1+.
* [Slim Framework](https://www.slimframework.com/): Un microframework PHP para construir aplicaciones web y APIs.
* [PHP-DI](http://php-di.org/): Un contenedor de inyección de dependencias para PHP.
* [Dotenv](https://github.com/vlucas/phpdotenv): Una librería para cargar variables de entorno desde un archivo `.env`.

## Contribuir
1. Haz fork del repositorio.
2. Crea una rama (`git checkout -b feature/nueva-funcionalidad`).
3. Haz commit de tus cambios (`git commit -am 'Añade funcionalidad X'`).
4. Haz push a la rama (`git push origin feature/nueva-funcionalidad`).
5. Abre un Pull Request.

## Licencia
MIT License - Ver [LICENSE](LICENSE.txt) para detalles.