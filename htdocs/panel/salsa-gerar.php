<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexão mysqli usando root sem senha
$conn = new mysqli('localhost', 'root', '', 'teste');
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica login e rank
if (!isset($_SESSION['usuario'])) {
    die('<div style="padding:30px;text-align:center;color:red;font-weight:bold">Faça login para acessar.</div>');
}
$usuario = $_SESSION['usuario'];

// Verifica rank
$stmt = $conn->prepare("SELECT rank FROM users WHERE username = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res = $stmt->get_result();
$dados = $res->fetch_assoc();

if (!$dados || $dados['rank'] < 7) {
    die('<div style="padding:30px;text-align:center;color:red;font-weight:bold">Apenas locutores (rank 7+) podem acessar.</div>');
}

// Inicializa
$codigoAtivo = "";
$expiraEm = "";
$usuariosUsaram = [];
$mensagem = "";

// Busca código ativo
$sql = "SELECT * FROM codigos_presenca WHERE expira_em > NOW() ORDER BY criado_em DESC LIMIT 1";
$res = $conn->query($sql);
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $codigoAtivo = $row['codigo'];
    $expiraEm = $row['expira_em'];
}

// Gerar código
if (isset($_POST['gerar'])) {
    if ($codigoAtivo) {
        $mensagem = "Já existe código ativo.";
    } else {
        $codigoAtivo = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);
        $agora = date('Y-m-d H:i:s');
        $expiraEm = date('Y-m-d H:i:s', strtotime('+2 minutes'));
        $stmt = $conn->prepare("INSERT INTO codigos_presenca (codigo, criado_em, expira_em) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $codigoAtivo, $agora, $expiraEm);
        $stmt->execute();
        $mensagem = "Código gerado!";
    }
}

// Usuários que usaram o código
if ($codigoAtivo) {
    $stmt = $conn->prepare("SELECT usuario, data FROM pontos_presenca WHERE codigo = ? ORDER BY data DESC");
    $stmt->bind_param("s", $codigoAtivo);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $usuariosUsaram[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Painel Locutor - Código de Presença</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    :root {
      --bg: #121212;
      --text: #f0f0f0;
      --accent: #00ffc8;
      --card: #1f1f1f;
    }
    .light {
      --bg: #f0f0f0;
      --text: #1c1c1c;
      --accent: #00b894;
      --card: #ffffff;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      min-height: 100vh;
      transition: background 0.5s ease, color 0.5s ease;
    }

    .menu-lateral {
      width: 240px;
      background: #0f0f0f;
      padding: 25px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .menu-lateral h2 {
      color: var(--accent);
      margin-bottom: 25px;
      font-size: 1.2rem;
    }

    .menu-lateral a {
      color: #fff;
      text-decoration: none;
      margin: 10px 0;
      display: block;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .menu-lateral a:hover {
      color: var(--accent);
    }

    .toggle-tema {
      margin-top: 40px;
      text-align: center;
    }

    .toggle-tema button {
      padding: 8px 20px;
      border: none;
      border-radius: 8px;
      background-color: var(--accent);
      color: #000;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .toggle-tema button:hover {
      filter: brightness(1.1);
    }

    .container {
      flex-grow: 1;
      padding: 40px;
      max-width: 600px;
      margin: auto;
    }

    .codigo-box {
      background: var(--card);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px #00ffc855;
      text-align: center;
      transition: all 0.4s ease;
    }

    .codigo {
      font-size: 50px;
      font-weight: bold;
      color: var(--accent);
      letter-spacing: 10px;
      margin: 20px 0;
    }

    .expira, .mensagem {
      margin-top: 10px;
      color: #ccc;
    }

    ul.usuarios {
      list-style: none;
      padding: 0;
      margin-top: 20px;
      text-align: left;
      max-height: 160px;
      overflow-y: auto;
    }

    ul.usuarios li {
      padding: 6px 12px;
      border-bottom: 1px solid #333;
    }

    button.gerar {
      background-color: var(--accent);
      color: #000;
      padding: 12px 30px;
      border: none;
      font-size: 1rem;
      border-radius: 30px;
      margin-top: 20px;
      font-weight: bold;
      box-shadow: 0 0 12px var(--accent);
      transition: background 0.3s;
    }

    button.gerar:disabled {
      background: #444;
      box-shadow: none;
      cursor: not-allowed;
    }
  </style>
</head>
<body class="" id="body">

<div class="menu-lateral">
  <div>
    <h2>PAINEL LOCUTOR</h2>
    <a href="#">Dar Cargo Rádio</a>
    <a href="#">Pontos de Presença</a>
    <a href="#">Gerar Códigos</a>
    <a href="#">Marcar Horário</a>
    <a href="#">Logs de Eventos</a>
  </div>
  <div class="toggle-tema">
    <button onclick="alternarTema()">🌗 Alternar Tema</button>
  </div>
</div>

<div class="container">
  <div class="codigo-box">
    <h2>Código de Presença</h2>
    <form method="POST">
      <button class="gerar" name="gerar" <?= $codigoAtivo ? 'disabled' : '' ?>>Gerar Código</button>
    </form>

    <?php if ($codigoAtivo): ?>
      <div class="codigo"><?= htmlspecialchars($codigoAtivo) ?></div>
      <div class="expira">Expira em: <strong><?= htmlspecialchars($expiraEm) ?></strong></div>
    <?php else: ?>
      <div class="expira">Nenhum código ativo.</div>
    <?php endif; ?>

    <?php if ($mensagem): ?>
      <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <?php if ($codigoAtivo): ?>
      <ul class="usuarios">
        <?php if (count($usuariosUsaram) === 0): ?>
          <li>Nenhum usuário usou este código ainda.</li>
        <?php else: ?>
          <?php foreach ($usuariosUsaram as $u): ?>
            <li><?= htmlspecialchars($u['usuario']) ?> — <?= date('d/m/Y H:i', strtotime($u['data'])) ?></li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
