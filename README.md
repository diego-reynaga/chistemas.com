# INSTALACIÓN Y CONFIGURACIÓN DE UN SERVIDOR DNS

### Actualizamos los repositorios.
```bash
sudo apt update
```

### Nos instalamos el paquete de Bind9 y Nano para editar archivos en caso de que no lo tengamos.
```bash
sudo apt install bind9 bind9-utils nano
```
### Comprobamos si Bind9 ya esta en funcionamiento, los errores o advertencias son normales (aún no hemos realizado ninguna configuración)
```bash
systemctl status bind9
```

>[!NOTE]
>NOTA ESPECIAL 