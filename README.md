# laravel_10_vue 
 
## Introducción
Proyecto laravel 10 con apis rest de usuarios junto con sanctum, además de front se usa vue, donde se consumen estas apis del backend. Todo dentro de docker.

## Instalación
Para instalar esto, debes seguir las siguientes indicaciones
- tener el repositorio en una carpeta, en su defecto, gestion-usuarios
- acceder a la carpeta gestion-usuarios
- entrar a src (desde una terminal o visualcode o buscando la carpeta en tu OS)
- - copiar el archivo Dockerfile.node.example y pegar en el mismo lugar, el archivo pegado se le debe cambiar el nombre a Dockerfile.node
- - copiar el archivo .env.example y pegar en el mismo lugar, el archivo pegado se le debe cambiar el nombre a .env
- abrir una terminal en gestion-usuarios
- ejecutar 
- - docker-compose build --no-cache --force-rm
- - - esto creará la imagen en docker
- - docker-compose up -d --build
- - - esto levantará los servicios de docker
- - docker-compose exec app composer install
- - - aquí ocupo "app" ya que es el nombre que definí para el servicio de laravel en docker-compose.yml, con esto se instalarán las dependencias de laravel
- - docker-compose exec app php artisan key:generate
- - - generar la key en el .env
- - docker-compose exec app php artisan migrate
- - - realizar las migraciones de laravel
- abrir un navegador
- acceder http://localhost:8080/ para hacer uso del sitio
- - usuario: test@test.com
- - password: password
- acceder http://localhost:3400/ para ver la base de datos
- - usuario: root
- - password: password


# Ejemplos de uso
Tomando como base que la instalación fue exitosa y con los servicios encendidos, para ver los ejemplos de uso, puedes hacer lo siguiente:
- Ir a la ruta /
- Si quieres autenticarte debes ingresar lo siguiente:
- - user admin:
- - - email: test@test.com
- - - password: password
- todos los usuarios pueden hacer uso del crud luego de loguearse, pero sólo el usuario admin no podrá ser eliminado ya que es administrador


# APIS
Tomando como base que la instalación fue exitosa y con los servicios encendidos, para el uso de apis (dentro del sistema o pruebas por postman por ej):
- Para consultas sobre los endpoint en específico, visitar api.php dentro de la carpeta routes
- La ruta base es http://localhost:8080/api/v1/
- Solo las apis de login y register no hacen uso del token bearer
- Si aún no creas usuarios, puedes registrarte y realizar el login o en su defecto ocupar el usuario admin
- - user admin:
- - - email: test@test.com
- - - password: password
- todos los usuarios pueden hacer uso del crud luego de loguearse, pero sólo el usuario admin no podrá ser eliminado ya que es administrador


# Observaciones
Si se cambia algún nombre o puerto, se debe considerar ese cambio en diferentes archivos, por ejemplo:
- Para lo relacionado con node, el puerto 3000 está configurado en:
- - docker-compose.yml
- - src/Dockerfile.node
- - src/vite.config.js
- Para lo relacionado con laravel, el puerto 9000 está configurado en:
- - docker-compose.yml
- - nginx/default.conf/default.conf
- - php/Dockerfile
- Para lo relacionado con mysql, el puerto 3306 está configurado en:
- - docker-compose.yml
- - src/.env


# Referencias
- https://laravel.com/docs/10.x/releases
- https://vuejs.org/guide/introduction.html
- https://sweetalert2.github.io/
