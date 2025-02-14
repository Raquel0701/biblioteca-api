# Documentación de la API - Biblioteca

## Introducción
Esta API permite gestionar una biblioteca con libros, autores y usuarios. Utiliza Yii2 con MongoDB y JWT para autenticación.

## Tecnologías Utilizadas
- **Framework:** Yii2
- **Base de Datos:** MongoDB
- **Autenticación:** JWT (JSON Web Tokens)
- **Servidor:** Laragon (Opcional)

## Endpoints Disponibles

### Autenticación
#### **1. Iniciar Sesión**
- **URL:** `/auth/login`
- **Método:** `POST`
- **Parámetros:**
  ```json
  {
    "username": "usuario",
    "password": "contraseña"
  }
  ```
- **Respuesta:**
  ```json
  {
    "access_token": "token_jwt",
    "expires_in": 1800
  }
  ```

#### **2. Registrar Usuario**
- **URL:** `/auth/register`
- **Método:** `POST`
- **Parámetros:**
  ```json
  {
    "username": "usuario",
    "password": "contraseña"
  }
  ```
- **Respuesta:**
  ```json
  {
    "message": "Usuario registrado exitosamente"
  }
  ```

---

### Libros
#### **3. Obtener todos los libros**
- **URL:** `/libro`
- **Método:** `GET`
- **Respuesta:**
  ```json
  [
    {
      "_id": "65a8f3b2d5d7c3a1b7e94a3c",
      "titulo": "El Quijote",
      "autores": "Miguel de Cervantes",
      "anio_publicacion": 1605,
      "descripcion": "Novela clásica"
    }
  ]
  ```

#### **4. Obtener un libro por ID**
- **URL:** `/libro/{id}`
- **Método:** `GET`
- **Respuesta:**
  ```json
  {
    "_id": "65a8f3b2d5d7c3a1b7e94a3c",
    "titulo": "El Quijote",
    "autores": "Miguel de Cervantes",
    "anio_publicacion": 1605,
    "descripcion": "Novela clásica"
  }
  ```

#### **5. Crear un libro**
- **URL:** `/libro`
- **Método:** `POST`
- **Parámetros:**
  ```json
  {
    "titulo": "Nuevo Libro",
    "autores": "Autor Desconocido",
    "anio_publicacion": 2024,
    "descripcion": "Una descripción del libro"
  }
  ```
- **Respuesta:**
  ```json
  {
    "message": "Libro creado correctamente",
    "data": {
      "_id": "65a8f3b2d5d7c3a1b7e94a3c",
      "titulo": "Nuevo Libro",
      "autores": "Autor Desconocido",
      "anio_publicacion": 2024,
      "descripcion": "Una descripción del libro"
    }
  }
  ```

#### **6. Actualizar un libro**
- **URL:** `/libro/{id}`
- **Método:** `PUT`
- **Parámetros:**
  ```json
  {
    "titulo": "Nuevo Título"
  }
  ```
- **Respuesta:**
  ```json
  {
    "message": "Libro actualizado correctamente"
  }
  ```

#### **7. Eliminar un libro**
- **URL:** `/libro/{id}`
- **Método:** `DELETE`
- **Respuesta:**
  ```json
  {
    "message": "Libro eliminado"
  }
  ```

---

### Configuración y Ejecución

#### **1. Instalación del Proyecto**
```sh
# Clonar el repositorio
git clone https://github.com/Raquel0701/biblioteca-api.git
cd biblioteca-api

# Instalar dependencias
composer install
```

#### **2. Configurar la Base de Datos**
Modificar `config/db.php` con:
```php
return [
    'class' => '\yii\mongodb\Connection',
    'dsn' => 'mongodb://localhost:27017/biblioteca',
];
```

#### **3. Configurar Servidor Local**
```sh
php yii serve --port=8080
```
Ahora puedes acceder a la API en `http://localhost:8080/`

#### **4. Probar con Postman**
Importa la colección JSON en Postman y prueba los endpoints.

---

### Seguridad
- Se requiere autenticación con **Bearer Token** para actualizar y eliminar libros.
- Las contraseñas están cifradas con `Yii::$app->security->generatePasswordHash()`.
- Se usan JSON Web Tokens (JWT) para la autenticación.

---

## Postman
Si deseas contribuir, por favor abre un **Pull Request** en el repositorio del proyecto.

---

## Ejemplo de ejecución en postman

Se ha enviado al correo o esta exportado en la raiz de este proyecto  *Biblioteca API.postman_collection.json*



### Contacto
- **Autor:** DIANA RAQUEL DIAZ TAPIA
- **Email:** drdiazt7@gmail.com
- **Repositorio:** [GitHub](https://github.com/Raquel0701/biblioteca-api)

