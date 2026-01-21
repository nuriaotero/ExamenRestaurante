<?php
/**
 * Verificar el estado actual de sesiones y cookies
 */

// Iniciar sesión como lo hace index.php
session_start();

// Log en archivo
$log_file = __DIR__ . '/debug_session.log';

$message = date('Y-m-d H:i:s') . " - Session Status:\n";
$message .= "  Session ID: " . session_id() . "\n";
$message .= "  Session Status: " . session_status() . " (1=disabled, 2=none, 3=active)\n";
$message .= "  usuario_id: " . (isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'NOT SET') . "\n";
$message .= "  All SESSION keys: " . implode(', ', array_keys($_SESSION)) . "\n";
$message .= "  REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n";
$message .= "  REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
$message .= "\n";

file_put_contents($log_file, $message, FILE_APPEND);

echo "✅ Log escrito en: $log_file\n";
echo "Contenido:\n";
echo file_get_contents($log_file);
?>
