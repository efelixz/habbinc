<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli('localhost', 'root', '', 'teste');
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (!isset($_SESSION['usuario'])) {
    die("Faça login para validar o código.");
}
$usuario = $_SESSION['usuario'];

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['codigo']) || trim($_POST['codigo']) === '') {
        $mensagem = "Código não informado.";
    } else {
        $codigoDigitado = trim($_POST['codigo']);

        // Verifica se o código está ativo
        $stmt = $conn->prepare("SELECT codigo FROM codigos_presenca WHERE codigo = ? AND expira_em > NOW()");
        $stmt->bind_param("s", $codigoDigitado);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 0) {
            $mensagem = "Código inválido ou expirado.";
        } else {
            // Verifica se usuário já usou esse código
            $stmt = $conn->prepare("SELECT id FROM pontos_presenca WHERE usuario = ? AND codigo = ?");
            $stmt->bind_param("ss", $usuario, $codigoDigitado);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $mensagem = "Você já usou esse código anteriormente.";
            } else {
                // Registra o ponto
                $stmt = $conn->prepare("INSERT INTO pontos_presenca (usuario, codigo, data) VALUES (?, ?, NOW())");
                $stmt->bind_param("ss", $usuario, $codigoDigitado);

                if ($stmt->execute()) {
                    $mensagem = "Ponto registrado com sucesso!";
                } else {
                    $mensagem = "Erro ao registrar ponto.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Validar Código de Presença</title>
<style>
  body {
    background: #121212;
    color: #eee;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100vh;
    padding-top: 60px;
  }
  .container {
    background: #222;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px #00ffc8aa;
    width: 360px;
    text-align: center;
  }
  h1 {
    margin-bottom: 20px;
    color: #00ffc8;
    text-shadow: 0 0 8px #00ffc8;
  }
  input[type=text] {
    width: 100%;
    padding: 14px 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: none;
    font-size: 18px;
    letter-spacing: 10px;
    text-transform: uppercase;
    text-align: center;
    background: #111;
    color: #00ffc8;
    box-shadow: 0 0 8px #00ffc8;
  }
  button {
    background: #00b894;
    border: none;
    padding: 14px 0;
    width: 100%;
    font-size: 18px;
    border-radius: 30px;
    cursor: pointer;
    color: white;
    box-shadow: 0 0 20px #00b894aa;
    transition: background 0.3s ease;
  }
  button:hover {
    background: #019874;
  }
  .mensagem {
    margin-top: 20px;
    font-weight: bold;
    font-size: 16px;
    color: #f39c12;
  }
</style>
</head>
<body>
  <div class="container">
    <h1>Validar Código</h1>
    <form method="POST" action="">
      <input type="text" name="codigo" maxlength="6" placeholder="Digite o código" autofocus required />
      <button type="submit">Validar e Receber Pontos</button>
    </form>
    <?php
    if ($mensagem) {
        echo '<div class="mensagem">' . htmlspecialchars($mensagem) . '</div>';
    }
    ?>
  </div>
</body>
</html>
