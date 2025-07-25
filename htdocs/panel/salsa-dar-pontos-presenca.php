<?php 
// Conexão com o banco - ajuste conforme seu ambiente
$conn = new mysqli("localhost", "root", "", "teste");
if ($conn->connect_error) die("Erro de conexão: " . $conn->connect_error);

function darPontosPresenca($conn, $userId, $pontos = 1) {
    $hoje = date('Y-m-d');

    // Verifica se já recebeu pontos hoje
    $stmt = $conn->prepare("SELECT 1 FROM presenca_logs WHERE user_id = ? AND data_presenca = ?");
    $stmt->bind_param("is", $userId, $hoje);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return false; // Já recebeu hoje
    }

    $conn->begin_transaction();

    try {
        // Atualiza pontos
        $stmt = $conn->prepare("UPDATE users SET pontos_presenca = pontos_presenca + ? WHERE id = ?");
        $stmt->bind_param("ii", $pontos, $userId);
        $stmt->execute();

        // Registra log de presença
        $stmt = $conn->prepare("INSERT INTO presenca_logs (user_id, data_presenca) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $hoje);
        $stmt->execute();

        $conn->commit();
        return true;

    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

// Variáveis para mensagens
$msg = '';
$msg_type = '';

if (isset($_POST['dar_ponto'])) {
    $username = trim($_POST['username'] ?? '');

    if ($username === '') {
        $msg = "Por favor, informe o nome do usuário.";
        $msg_type = 'danger';
    } else {
        // Buscar usuário pelo username
        $stmt = $conn->prepare("SELECT id, pontos_presenca FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (darPontosPresenca($conn, $user['id'])) {
                $msg = "Ponto de presença dado para <strong>" . htmlspecialchars($username) . "</strong>!";
                $msg_type = 'success';
            } else {
                $msg = "Usuário <strong>" . htmlspecialchars($username) . "</strong> já recebeu ponto hoje.";
                $msg_type = 'warning';
            }
        } else {
            $msg = "Usuário <strong>" . htmlspecialchars($username) . "</strong> não encontrado.";
            $msg_type = 'danger';
        }
    }
}

// Buscar usuários para listagem (só quem tem pontos > 0)
$lista_usuarios = $conn->query("SELECT username, pontos_presenca FROM users WHERE pontos_presenca > 0 ORDER BY pontos_presenca DESC");

?>

<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dar Pontos de Presença</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

<style>
  /* Tema escuro/claro usando data-theme */
  :root {
    --cor-bg: #111;
    --cor-bg-container: rgba(0,0,0,0.3);
    --cor-texto: #eee;
    --cor-primaria: #06d6a0;
    --cor-hover: #04ad7a;
    --cor-alert-success: #28a745;
    --cor-alert-danger: #dc3545;
    --cor-alert-warning: #ffc107;
    --sombra-texto: 0 0 10px rgba(6,214,160,0.8);
  }

  [data-theme="light"] {
    --cor-bg: #f4f7f6;
    --cor-bg-container: rgba(255,255,255,0.85);
    --cor-texto: #222;
    --cor-primaria: #06d6a0;
    --cor-hover: #04ad7a;
    --cor-alert-success: #198754;
    --cor-alert-danger: #dc3545;
    --cor-alert-warning: #ffb700;
    --sombra-texto: none;
  }

  body {
    background: var(--cor-bg);
    min-height: 100vh;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--cor-texto);
    display: flex;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .menu-lateral {
    width: 220px;
    background-color: var(--cor-bg);
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    border-right: 2px solid var(--cor-primaria);
  }

  .menu-lateral h3 {
    color: var(--cor-primaria);
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 20px;
    letter-spacing: 1.4px;
    text-shadow: var(--sombra-texto);
  }

  .menu-lateral a {
    color: var(--cor-texto);
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 15px;
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .menu-lateral a:hover {
    color: var(--cor-hover);
  }

  .menu-lateral .toggle-theme {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-weight: 600;
    color: var(--cor-primaria);
    user-select: none;
  }

  .toggle-switch {
    position: relative;
    width: 40px;
    height: 20px;
  }

  .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc;
    border-radius: 34px;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    border-radius: 50%;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: var(--cor-primaria);
  }

  input:checked + .slider:before {
    transform: translateX(20px);
  }

  .container {
    background: var(--cor-bg-container);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 30px 40px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 8px 30px rgba(0,0,0,0.4);
    margin: 40px;
    flex-grow: 1;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  h2 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
    text-shadow: var(--sombra-texto);
  }

  input.form-control {
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 1.1rem;
    border: none;
    outline: none;
    transition: box-shadow 0.3s ease;
  }
  input.form-control:focus {
    box-shadow: 0 0 8px var(--cor-primaria);
  }

  button.btn-primary {
    width: 100%;
    padding: 12px 0;
    font-weight: 600;
    border-radius: 8px;
    background-color: var(--cor-primaria);
    border: none;
    transition: background-color 0.3s ease;
    box-shadow: 0 0 8px var(--cor-primaria);
  }

  button.btn-primary:hover {
    background-color: var(--cor-hover);
  }

  table {
    margin-top: 30px;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
    color: var(--cor-texto);
  }

  table thead th {
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid var(--cor-primaria);
    padding-bottom: 8px;
  }

  table tbody tr {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    transition: background-color 0.25s ease, transform 0.4s ease, opacity 0.4s ease;
    opacity: 0;
    transform: translateX(-30px);
  }

  table tbody tr.show {
    opacity: 1;
    transform: translateX(0);
  }

  table tbody tr:hover {
    background: rgba(255,255,255,0.25);
  }

  table tbody td {
    padding: 12px 10px;
  }

  .alert {
    font-weight: 600;
    margin-top: 15px;
    border-radius: 8px;
    text-align: center;
    transition: background-color 0.3s ease;
  }

  .alert-success {
    background-color: var(--cor-alert-success);
    color: #fff;
  }

  .alert-danger {
    background-color: var(--cor-alert-danger);
    color: #fff;
  }

  .alert-warning {
    background-color: var(--cor-alert-warning);
    color: #222;
  }

  /* Scroll suave para o conteúdo da tabela */
  tbody {
    display: block;
    max-height: 300px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--cor-primaria) transparent;
  }

  thead, tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
  }

  /* Estilo scrollbar para Chrome, Edge e Safari */
  tbody::-webkit-scrollbar {
    width: 8px;
  }
  tbody::-webkit-scrollbar-track {
    background: transparent;
  }
  tbody::-webkit-scrollbar-thumb {
    background-color: var(--cor-primaria);
    border-radius: 10px;
  }
</style>
</head>
<body>

<div class="menu-lateral">
  <h3>EQUIPE RÁDIO</h3>
  <a href="#">Dar cargo rádio</a>
  <a href="#">Dar pontos de presenças</a>
  <a href="#">Gerar códigos</a>
  <a href="#">Marcar o horário</a>
  <a href="#">Logs de eventos</a>
  <a href="salsa-bemvindo" style="margin-top: auto; color: var(--cor-primaria); font-weight: 700;">Voltar à página</a>

  <label class="toggle-theme" title="Alternar tema claro/escuro">
    <span>Tema Claro</span>
    <div class="toggle-switch">
      <input type="checkbox" id="toggle-theme-checkbox" />
      <span class="slider"></span>
    </div>
  </label>
</div>

<div class="container">
  <h2>Dar Pontos de Presença</h2>

  <?php if ($msg): ?>
    <div class="alert alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
  <?php endif; ?>

  <form method="post" class="mb-4">
    <input type="text" name="username" placeholder="Nome do usuário" class="form-control mb-3" required autocomplete="off" />
    <button type="submit" name="dar_ponto" class="btn btn-primary">Dar ponto de presença</button>
  </form>

  <h4>Usuários e pontos acumulados</h4>
  <table>
    <thead>
      <tr>
        <th>Usuário</th>
        <th>Pontos de Presença</th>
      </tr>
    </thead>
    <tbody id="lista-usuarios-tbody">
      <?php if ($lista_usuarios && $lista_usuarios->num_rows > 0): ?>
        <?php while ($row = $lista_usuarios->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo (int)$row['pontos_presenca']; ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="2" style="text-align:center;">Nenhum usuário encontrado.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
  // Tema claro/escuro toggle
  const toggleCheckbox = document.getElementById('toggle-theme-checkbox');
  const htmlTag = document.documentElement;
  const toggleLabel = document.querySelector('.toggle-theme span');

  // Detecta tema salvo no localStorage
  const temaSalvo = localStorage.getItem('tema');
  if (temaSalvo) {
    htmlTag.setAttribute('data-theme', temaSalvo);
    if (temaSalvo === 'light') {
      toggleCheckbox.checked = true;
      toggleLabel.textContent = "Tema Escuro";
    }
  }

  toggleCheckbox.addEventListener('change', () => {
    if (toggleCheckbox.checked) {
      htmlTag.setAttribute('data-theme', 'light');
      toggleLabel.textContent = "Tema Escuro";
      localStorage.setItem('tema', 'light');
    } else {
      htmlTag.setAttribute('data-theme', 'dark');
      toggleLabel.textContent = "Tema Claro";
      localStorage.setItem('tema', 'dark');
    }
  });

  // Animação "slide" das linhas da tabela ao carregar
  window.addEventListener('load', () => {
    const linhas = document.querySelectorAll('#lista-usuarios-tbody tr');
    linhas.forEach((linha, i) => {
      setTimeout(() => {
        linha.classList.add('show');
      }, i * 100);
    });
  });
</script>

</body>
</html>
