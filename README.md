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
### 4.instalamos UFW.
>[!NOTE]
>una herramienta sencilla para configurar un firewall en Linux. 
```bash
sudo apt install ufw
```

>[!NOTE]
>NOTA ESPECIAL 