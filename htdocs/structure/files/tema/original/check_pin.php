<?php
session_start();
include 'config.php'; // seu arquivo de conexão

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

if (!isset($_POST['pin'])) {
    echo json_encode(['success' => false, 'message' => 'PIN não enviado']);
    exit;
}

$usuario = $_SESSION['usuario'];
$pin = $_POST['pin'];

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro na conexão']);
    exit;
}

$stmt = $conn->prepare("SELECT pin FROM users WHERE username = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($pinArmazenado);
$stmt->fetch();
$stmt->close();

if ($pin === $pinArmazenado && !empty($pinArmazenado)) {
    $_SESSION['pin_unlocked'] = true;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'PIN incorreto']);
}
$conn->close();
