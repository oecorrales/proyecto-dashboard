## Applicacion de Creacion de Usuarios utilizando DDD

Este proyecto se enfoca en la creacion de usuarios implementando domain driven design. 
Se empleo Doctrine ORM para la presistencia, utilizando UUID para el el ID de usuario con la ayuda del paquete ramsey/uuid-cotrine.

La aplicacion cuenta con un archivo MAKE que facilita la creacion del contenedor docker para poder ejecutar la aplicacion.

## Instalacion
Para crear los contenedores se debe ejecutar el comando
```
make up
```

Una vez la instalacion se haya terminado debemos instalar los paquetes de composer
```
make install
```

Como ultimo paso debemos migrar nuestra entidad a la base de datos
```
make migrate
```

Una vez hecho esto podemos comunicarnos con la API al puerto 8000.
La URL para comunicarnos con la app es:
```
http://localhost:8000/api/users
```

El cuerpo de nuestra peticion POST debe ser la siguiente:
```json
{
    "name": "Omar Corrales",
    "email": "correo@gmail.com",
    "password": "Clave#1234"
}
```