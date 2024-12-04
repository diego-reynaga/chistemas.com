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
>[!NOTE]
>NOTA ESPECIAL 