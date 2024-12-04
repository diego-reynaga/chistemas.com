# INSTALACIÓN Y CONFIGURACIÓN DE UN SERVIDOR DNS

### 1. Actualizamos los repositorios.
```bash
sudo apt update
```

### 2. Nos instalamos el paquete de Bind9 y Nano para editar archivos en caso de que no lo tengamos.
```bash
sudo apt install bind9 bind9-utils nano
```
### 3. Comprobamos si Bind9 ya esta en funcionamiento, los errores o advertencias son normales (aún no hemos realizado ninguna configuración)
```bash
systemctl status bind9
```
### 4. Instalamos UFW.
>[!NOTE]
>es una herramienta sencilla para configurar un firewall en Linux. 
```bash
sudo apt install ufw
```

### 5. Permitir de forma sencilla en el Firewall local, el acceso al puerto y protocolo que utiliza Bind9
```bash
sudo ufw allow bind9
```

### 6. Configuración mínima de Bind9
>[!NOTE]
>ip a y tomamos la ip de 2
```bash
sudo nano /etc/bind/named.conf.options
```
-----------------
```bash
options {
        directory "/var/cache/bind";

        // If there is a firewall between you and nameservers you want
        // to talk to, you may need to fix the firewall to allow multiple
        // ports to talk.  See http://www.kb.cert.org/vuls/id/800113

        // If your ISP provided one or more IP addresses for stable
        // nameservers, you probably want to use them as forwarders.
        // Uncomment the following block, and insert the addresses replacing
        // the all-0's placeholder.




        listen-on { any; };
        allow-query { localhost; 10.0.0.0/8; };
        forwarders {
                8.8.8.8;
                8.8.4.4;
        };


        // forwarders {
        //      0.0.0.0;
        // };

        //========================================================================
        // If BIND logs error messages about the root key being expired,
        // you will need to update your keys.  See https://www.isc.org/bind-keys
        //========================================================================
        #dnssec-validation auto;

        dnssec-validation no;

        #listen-on-v6 { any; };
};
```

### 7. Obligar el uso único de IPv4
```bash
sudo nano /etc/default/named
```
>[!NOTE]
>Modificar la línea dejándola así: OPTIONS="-u bind -4"
```bash
#
# run resolvconf?
RESOLVCONF=no

# startup options for the server
OPTIONS="-u bind -4"
```
### 8. Comprobar la configuración de Bind9 y reiniciar el servicio si todo está bien, luego lanzar status para ver si no hay errores.
```bash
sudo named-checkconf
```
```bash
sudo systemctl restart bind9
```
```bash
systemctl status bind9
```
### 9. Agregar las Zonas
```bash
sudo nano /etc/bind/named.conf.local
```
-----------------
```bash
//
// Do any local configuration here
//

// Consider adding the 1918 zones here, if they are not used in your
// organization
//include "/etc/bind/zones.rfc1918";

zone "chistemas.com" IN {
        type master;
        file "/etc/bind/zonas/db.chistemas.com";
};

zone "50.2.10.in-addr.arpa" IN {
    type master;
    file "/etc/bind/zonas/db.10.2.50";
};
```
### 10. Creando el directorio donde guardaremos los archivos de zonas y luego creamos las dos zonas, la directa y la inversa.
```bash
sudo mkdir /etc/bind/zonas
```
```bash
sudo nano /etc/bind/zonas/db.chistemas.com
```
---------------
```bash
$TTL    1D
@       IN      SOA     ns1.chistemas.com. admin.chistemas.com. (
                        20241202        ; Serial
                        12h             ; Refresh
                        15m             ; Retry
                        3w              ; Expire
                        2h      )       ; Negative Cache TTL
;
@      IN      NS      ns1.chistemas.com.
ns1    IN      A       10.2.50.211
www    IN      A       10.2.50.211
@      IN      A       10.2.50.211     ; Este es el registro A para chistemas.com
```
------------------
```bash
sudo nano /etc/bind/zonas/db.10.2.50
```
------------------
```bash
$TTL    1D
@       IN      SOA     ns1.chistemas.com. admin.chistemas.com. (
                        20241202        ; Serial
                        12h             ; Refresh
                        15m             ; Retry
                        3w              ; Expire
                        2h      )       ; Negative Cache TTL
;
@      IN      NS      ns1.chistemas.com.
ns1    IN      A       10.2.50.211    ; Agregar este registro A
www    IN      A       10.2.50.211
```
---------------------
### 11. Comprobar los archivos de zona que acabamos de crear para ver si todo esta bien.
```bash
sudo named-checkzone chistemas.com /etc/bind/zonas/db.chistemas.com
```
```bash
sudo named-checkzone db.10.50.10.in-addr.arpa /etc/bind/zonas/db.10.2.50
```