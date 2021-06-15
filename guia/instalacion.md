# Instrucciones de instalación y despliegue

## En local

### Requisitos
* PHP 7.3.0
* PostgreSQL
* Extensión pgcrypto
* Composer
* Cuenta de gmail
* Cuenta de Amazon S3
* Cuenta de API The Movie Database

### Instalación
1. Ejecutar los comandos
    * `$ git clone https://github.com/rolLangel/yiiaffinity.git`
    * `$ composer install`
    * `$ db/create.sh`
    * `$ db/load`
2. Rellena las variabes de entorno
    * copia el archivo *.env.example* y poner el nombre de *.env*:
        `$ sudo cp .env.example .env`
3. Añade rellena el archivo .env con las siguientes credenciales  
    * `SMTP_PASS` La clave de el correo de la aplicación.
    * `AWSAccessKeyId` KeyId de Amazon S3.
    * `AWSSecretKey` SecretKey de Amazon S3.
    * `TMDBKey` Clave de la API The Movie Database.
4. Ejecutar `$ ./yii serve` para arrancar el servidor.
5. Abrir el navegador e introducir la direccion `localhost:8080`

## En la nube

### Despliegue en Heroku
*Se requiere Heroku CLI*

1. Ejecutamos el comando `$ heroku login`
2. Creamos una nueva aplicación
3. Añadimos el addons **Heroku Postgres**
    * Introducimos las variables de entorno 
        * `YII_ENV` le asignamos `prod`
        * `SMTP_PASS` La clave de el correo de la aplicación.
        * `AWSAccessKeyId` KeyId de Amazon S3.
        * `AWSSecretKey` SecretKey de Amazon S3.
        * `TMDBKey` Clave de la API The Movie Database.
4. En el directorio del proyecto conectamos la app de heroku con el comando `$ heroku git:remote --app <nombre_app>`
5. Entramos a la base de datos de heroku e instalamos el pgcrypto con el comando `$ heroku psql` seguido de `# create extension pgcrypto`
6. Ejecutamos `$ heroku psql < db/yiiaffinity.sql` para cargar los  datos a la base de datos de heroku.
7. La aplicacíón estaría instalada y funcionando.
