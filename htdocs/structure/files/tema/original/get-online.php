<?php
require_once 'salsa-sessao.php';
require_once 'conexao.php';
require_once 'SalsaDado.php';

$online = SalsaDado::usuarios_online($conn);

$response = [
    'online' => $online,
    'status' => $online >= 10 ? 'up' : 'down'
];

header('Content-Type: application/json');
echo json_encode($response);
