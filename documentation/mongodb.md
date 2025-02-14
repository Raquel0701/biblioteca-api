# Documentación - Mongodb

## Introducción
Esta API permite gestionar una biblioteca con libros, autores y usuarios. Utiliza Yii2 con MongoDB y JWT para autenticación.

### Configuración y Ejecución

#### **1. Instalación del Proyecto**
```sh
# Clonar el repositorio
git clone https://github.com/Raquel0701/biblioteca-api
cd biblioteca-api

# Instalar dependencias
composer install
```

#### **2. Configurar la Base de Datos**
Modificar `config/db.php` con:
```php
return [
    'class' => '\\yii\\mongodb\\Connection',
    'dsn' => 'mongodb://localhost:27017/biblioteca',
];
```

#### **3. Crear la Base de Datos y Colecciones en MongoDB**
```sh
use biblioteca

db.createCollection("libros")
db.createCollection("users")

db.libros.insertMany([
  {
    "titulo": "El principito",
    "autores": ["Antoine de Saint-Exupéry"],
    "anio_publicacion": 1943,
    "descripcion": "Un cuento filosófico sobre un niño y su viaje por el universo."
  },
  {
    "titulo": "Cien años de soledad",
    "autores": ["Gabriel García Márquez"],
    "anio_publicacion": 1967,
    "descripcion": "La historia de la familia Buendía en el pueblo de Macondo."
  }
])
```

#### **4. Configurar Servidor Local**
```sh
php yii serve --port=8080
```
Ahora puedes acceder a la API en `http://localhost:8080/`

#### **5. Probar con Postman**
Importa la colección JSON en Postman y prueba los endpoints.

---

### Seguridad
- Se requiere autenticación con **Bearer Token** para actualizar y eliminar libros.
- Las contraseñas están cifradas con `Yii::$app->security->generatePasswordHash()`.
- Se usan JSON Web Tokens (JWT) para la autenticación.

---

## Contribución
Si deseas contribuir, por favor abre un **Pull Request** en el repositorio del proyecto.

---

### Contacto
- **Autor:** DIANA RAQUEL DIAZ TAPIA
- **Email:** drdiazt7@gmail.com
- **Repositorio:** [GitHub](https://github.com/Raquel0701/biblioteca-api)
