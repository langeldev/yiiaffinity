# Anexos

Documentos específicos vinculados a determinados requisitos funcionales o
técnicos ("prueba del seis" y similares).

Poner cada uno en un apartado separado, indicando en el título de cada apartado
el código y la descripción corta del requisito asociado (por ejemplo,
**(RF24) Prueba del seis**).


### ([R25](https://github.com/rolLangel/yiiaffinity/issues/25)) Codeception
![Codeception](images/anexos/codeception.png)

### ([R26](https://github.com/rolLangel/yiiaffinity/issues/26)) Code Climate
![Code Climate](images/anexos/codeclimate.png)

### ([R33](https://github.com/rolLangel/yiiaffinity/issues/33)) Microdatos

![microdatos](images/anexos/microdatos.png)

### ([R34](https://github.com/rolLangel/yiiaffinity/issues/34)) Validación HTML5, CSS3 y accesibilidad
   
* HTML
![validador-html](images/anexos/validador-html.png)

* CSS 
![validador-css](images/anexos/validador-css.png)

### ([R38](https://github.com/rolLangel/yiiaffinity/issues/38)) Despliegue en un servidor local

#### **DHCP**

*Configuracion de la red*
* Servidor 

    ![Netplan servidor](images/anexos/servidor-local/netplan-server.png)

* Cliente

    ![Netplan cliente](images/anexos/servidor-local/netplan-cliente.png)


#### **DNS**
 
 * /etc/bind/named,conf.local

    ![named.local.conf](images/anexos/servidor-local/zonas.png)

* Zona Directa: /etc/bind/db.yiiaffinity.com

    ![db.yiiaffinity.com](images/anexos/servidor-local/zona.png)

* Zona Inversa: /etc/bind/db.1.168.192

    ![db.1.168.192](images/anexos/servidor-local/zona-inversa.png)



#### **Apache**

*Configuracion del apache*

* /etc/apache2/sites-available/000-default.conf
    
    ![apache.conf](images/anexos/servidor-local/apache-conf.png)

* redireccion https:

    ![redirect](images/anexos/servidor-local/redirect.png)

* configuracion mod_speling

  ![speling](images/anexos/servidor-local/mod-speling.png)

#### *Configuración ssl autofirmada:*

1. Creé la clave privada RSA de 2048 bits
    
    `$ openssl genrsa -out yiiaffinity.key 2048`
2. Generé una solicitud de certificado CSR
    
    `$ openssl req -new -key yiiaffinity.key -out yiiaffinity.csr`

3. Una vez hecho lo anterior creé el certificado autofirmado usando la clave privada
    
    `$ openssl x509 -req -days 365 -in yiiaffinity.csr -signkey yiiaffinity.key -out yiiaffinity.crt`

4. Moví las clave y el certificado a los directorios que usa por defecto apache 

    * `$ sudo mv yiiaffinity.key /etc/ssl/private/`
    * `$ sudo mv yiiaffinity.crt /etc/ssl/certs/`

5. Configuré los permisos
    * `$ sudo chown root:ssl-cert /etc/ssl/private/yiiaffinity.key`
    * `$ sudo chown 640 /etc/ssl/private/yiiaffinity.key`
    * `$ sudo chown root:root /etc/ssl/certs/yiiaffinity.crt`

6. Creé el fichero de configuración  yiiaffinityseguro.conf
    
    `$ sudo nano /etc/apache2/sites-available/yiiaffinityseguro.conf`

7. Habilité el módulo ssl
    
    `$ sudo a2enmod ssl`

8. Habilité el servidor virtual que creé y configuré anteriormente
    
    `$ sudo a2ensite yiiaffinityseguro`

    * Configuración del servidor virtual

        ![host-443](images/anexos/servidor-local/host-443.png)
    
**Comprobación:**

1. *speling*
2. *redireccion*
3. *certificado ssl*

    ![redireccion https](images/anexos/servidor-local/red-spel-https.gif)

* **Autenticacion Digest:**

    * (uso de alias para acceder a la documentacion)
    ![digest](images/anexos/servidor-local/digest.png)

    * Prueba
    ![digest-prueba](images/anexos/servidor-local/digest.gif)

<br>

#### **Las dos máquinas funcionando**

![maquinas](images/anexos/servidor-local/maquinas.gif)
