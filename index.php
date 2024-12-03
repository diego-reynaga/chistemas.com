<?php
// Leer el archivo /etc/resolv.conf
$dns_servers = file_get_contents('/etc/resolv.conf');

// Buscar las direcciones IP de los servidores DNS
preg_match_all('/nameserver\s+(\S+)/', $dns_servers, $matches);

// Si encontramos direcciones, mostrar las dos primeras
if (count($matches[1]) > 1) {
    $dns_ip_1 = $matches[1][0]; // Primer DNS
    $dns_ip_2 = $matches[1][1]; // Segundo DNS
} else {
    $dns_ip_1 = $matches[1][0] ?? 'No DNS disponible'; // Si solo hay un DNS
    $dns_ip_2 = 'No DNS disponible';  // Si no hay segundo DNS
}

// Determinar cuál IP mostrar
// Aquí solo estamos mostrando la primera IP como ejemplo
// Esto lo puedes cambiar según tu lógica para alternar entre las IPs.
$current_dns_ip = $dns_ip_1; // Cambia esta lógica según tus necesidades

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servidor DNS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        .dns-ip {
            font-weight: bold;
            color: #007BFF;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dirección IP del Servidor DNS</h1>
        <p>Actualmente, el servidor está conectado al servidor DNS con la siguiente dirección IP:</p>
        <p class="dns-ip"><?php echo $current_dns_ip; ?></p>
        
        <?php if ($dns_ip_2 == 'No DNS disponible'): ?>
            <p class="error-message">No se encontró una segunda dirección IP de DNS.</p>
        <?php else: ?>
            <p>La otra IP de DNS disponible es: <span class="dns-ip"><?php echo $dns_ip_2; ?></span></p>
        <?php endif; ?>
    </div>
</body>
</html>