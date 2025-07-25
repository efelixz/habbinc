<?php
// Exemplo completo: painel rádio com classe, método estático, formulário e listagem

class RadioPainel
{
    public static function marcar_horario_radio($conn)
    {
        if (isset($_POST['marcar_horario'])) {
            // Supondo que você tenha a função fs() para sanitizar (se não, use trim+htmlspecialchars)
            $usuario = function_exists('fs') ? fs($_POST['usuario']) : htmlspecialchars(trim($_POST['usuario']));
            $data = $_POST['data'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fim = $_POST['hora_fim'];
            $programa = isset($_POST['programa']) ? (function_exists('fs') ? fs($_POST['programa']) : htmlspecialchars(trim($_POST['programa']))) : '';

            if (!$usuario || !$data || !$hora_inicio || !$hora_fim) {
                echo '<div class="alert alert-danger" role="alert">Preencha todos os campos obrigatórios.</div>';
                return;
            }

            $stmt = $conn->prepare("INSERT INTO radio_horario (usuario, data, hora_inicio, hora_fim, programa) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $usuario, $data, $hora_inicio, $hora_fim, $programa);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Horário marcado com sucesso para <strong>' . htmlspecialchars($usuario) . '</strong>.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erro ao marcar horário: ' . htmlspecialchars($stmt->error) . '</div>';
            }
        }
    }

    public static function listar_horarios($conn)
    {
        $sql = "SELECT * FROM radio_horario ORDER BY data ASC, hora_inicio ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered text-center">';
            echo '<thead class="table-dark"><tr><th>Locutor</th><th>Data</th><th>Início</th><th>Fim</th><th>Programa</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['usuario']) . '</td>';
                echo '<td>' . date("d/m/Y", strtotime($row['data'])) . '</td>';
                echo '<td>' . htmlspecialchars($row['hora_inicio']) . '</td>';
                echo '<td>' . htmlspecialchars($row['hora_fim']) . '</td>';
                echo '<td>' . htmlspecialchars($row['programa']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p class="text-center">Nenhum horário marcado ainda.</p>';
        }
    }
}


// --- Configurações do banco (altere aqui) ---
$conn = new mysqli("localhost", "root", "", "teste");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Painel Rádio - Marcar Horário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background:#f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 750px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h3 {
            text-align:center;
            margin-bottom: 25px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">

    <h3>🎙️ Marcar Horário de Locução</h3>

    <?php
        RadioPainel::marcar_horario_radio($conn);
    ?>

    <form method="post" class="mb-5">
        <div class="mb-3">
            <label>Seu Nome:</label>
            <input type="text" name="usuario" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Data:</label>
            <input type="date" name="data" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Início:</label>
            <input type="time" name="hora_inicio" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Fim:</label>
            <input type="time" name="hora_fim" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Nome do Programa (opcional):</label>
            <input type="text" name="programa" class="form-control" />
        </div>

        <button type="submit" name="marcar_horario" class="btn btn-primary w-100">Salvar Horário</button>
    </form>

    <h3>📅 Horários Marcados</h3>

    <?php
        RadioPainel::listar_horarios($conn);
    ?>

</div>

</body>
</html>
