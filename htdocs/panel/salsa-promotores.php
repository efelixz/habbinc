<?php 
class SalsaPromotores
{
    public static function salvar_evento($conn)
    {
        if (isset($_POST['salvar_evento'])) {
            $responsavel = isset($_POST['responsavel']) ? trim($_POST['responsavel']) : '';
            $nome_evento = isset($_POST['nome_evento']) ? trim($_POST['nome_evento']) : '';
            $data_realizado = isset($_POST['data_realizado']) ? $_POST['data_realizado'] : '';
            $locutor = isset($_POST['locutor']) ? trim($_POST['locutor']) : '';
            $ganhadores = isset($_POST['ganhadores']) ? trim($_POST['ganhadores']) : '';

            if (!$responsavel || !$nome_evento || !$data_realizado || !$locutor || !$ganhadores) {
                echo '<div class="alert alert-danger">Preencha todos os campos.</div>';
                return;
            }

            $stmt = $conn->prepare("INSERT INTO radio_eventos (responsavel, nome_evento, data_realizado, locutor, ganhadores) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $responsavel, $nome_evento, $data_realizado, $locutor, $ganhadores);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success">Evento salvo com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger">Erro: ' . htmlspecialchars($stmt->error) . '</div>';
            }
        }
    }

    public static function listar_eventos($conn)
    {
        $result = $conn->query("SELECT * FROM radio_eventos ORDER BY data_realizado DESC");
        if ($result && $result->num_rows > 0) {
            echo '<table class="table table-bordered table-striped">';
            echo '<thead><tr>';
            echo '<th>Responsável</th>';
            echo '<th>Nome do Evento</th>';
            echo '<th>Data Realizado</th>';
            echo '<th>Locutor</th>';
            echo '<th>Ganhadores</th>';
            echo '</tr></thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['responsavel']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nome_evento']) . '</td>';
                echo '<td>' . ($row['data_realizado'] ? date('d/m/Y', strtotime($row['data_realizado'])) : '') . '</td>';
                echo '<td>' . htmlspecialchars($row['locutor']) . '</td>';
                echo '<td>' . nl2br(htmlspecialchars($row['ganhadores'])) . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p class="text-center">Nenhum evento registrado ainda.</p>';
        }
    }
}

// Ajuste a conexão para seu ambiente MySQL
$conn = new mysqli("localhost", "root", "", "teste");
if ($conn->connect_error) die("Erro de conexão: " . $conn->connect_error);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Salsa Promotores</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" rel="stylesheet" />

<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f2f2f2;
    color: #111;
    display: flex;
    min-height: 100vh;
    transition: background-color 0.4s ease, color 0.4s ease;
  }
  .scrollbar-sidebar {
    width: 260px;
    background: #fff;
    border-right: 1px solid #ddd;
    height: 100vh;
    position: fixed;
    overflow-y: auto;
    padding-top: 20px;
  }
  .app-sidebar__inner {
    padding: 0 10px 20px 10px;
  }
  ul.vertical-nav-menu {
    list-style: none;
    padding-left: 0;
  }
  ul.vertical-nav-menu li {
    margin-bottom: 6px;
  }
  .app-sidebar__heading {
    font-weight: 700;
    font-size: 14px;
    color: #666;
    padding-left: 15px;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.07em;
  }
  ul.vertical-nav-menu a {
    display: flex;
    align-items: center;
    color: #333;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 500;
    transition: background-color 0.3s, color 0.3s;
  }
  ul.vertical-nav-menu a i.metismenu-icon {
    margin-right: 10px;
    font-size: 18px;
  }
  ul.vertical-nav-menu a:hover,
  ul.vertical-nav-menu a.active {
    background-color: #007bff;
    color: #fff;
  }
  ul.vertical-nav-menu a:hover i.metismenu-icon,
  ul.vertical-nav-menu a.active i.metismenu-icon {
    color: #fff;
  }
  .content-area {
    margin-left: 260px;
    padding: 25px 40px;
    width: calc(100% - 260px);
    min-height: 100vh;
    background: #fff;
    box-shadow: inset 0 0 10px #ccc;
    overflow-y: auto;
  }
  .tab-content {
    display: none;
  }
  .tab-content.active {
    display: block;
  }
  .tema-toggle-container {
    padding: 0 20px 20px 20px;
  }
  .tema-toggle {
    position: relative;
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
  }
  .tema-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  .slider {
    position: relative;
    width: 46px;
    height: 24px;
    background-color: #ccc;
    border-radius: 12px;
    transition: background-color 0.3s;
    margin-right: 12px;
    flex-shrink: 0;
  }
  .slider::before {
    content: "";
    position: absolute;
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    border-radius: 50%;
    transition: transform 0.3s ease;
  }
  .tema-toggle input:checked + .slider {
    background-color: #28a745;
  }
  .tema-toggle input:checked + .slider::before {
    transform: translateX(22px);
  }
  .label-text {
    font-weight: 600;
    font-size: 14px;
    color: #333;
  }
  .alert {
    margin-bottom: 20px;
  }
  table.table {
    margin-top: 15px;
  }
  /* Tema escuro */
  body.tema-escuro {
    background-color: #121212;
    color: #ddd;
  }
  body.tema-escuro .scrollbar-sidebar {
    background: #1d1d1d;
    border-color: #444;
  }
  body.tema-escuro ul.vertical-nav-menu a {
    color: #ddd;
  }
  body.tema-escuro ul.vertical-nav-menu a:hover,
  body.tema-escuro ul.vertical-nav-menu a.active {
    background-color: #28a745;
    color: #fff;
  }
  body.tema-escuro .label-text {
    color: #ddd;
  }
  body.tema-escuro .content-area {
    background: #222;
    box-shadow: inset 0 0 10px #000;
  }
</style>
</head>
<body>

<div class="scrollbar-sidebar ps ps--active-y">
  <div class="app-sidebar__inner">
    <ul class="vertical-nav-menu metismenu">

      <li class="app-sidebar__heading">Tema</li>
      <li class="tema-toggle-container">
        <label class="tema-toggle">
          <input type="checkbox" id="botao-tema" />
          <span class="slider"></span>
          <span class="label-text">Modo Escuro</span>
        </label>
      </li>

      <li class="app-sidebar__heading">Equipe Rádio</li>
      <li>
        <a href="#" data-tab="dar-cargo-radio" class="tab-link"><i class="metismenu-icon pe-7s-add-user"></i> Dar cargo rádio</a>
        <a href="#" data-tab="dar-pontos-presenca" class="tab-link"><i class="metismenu-icon pe-7s-like2"></i> Dar pontos de presenças</a>
        <a href="#" data-tab="gerar-codigos" class="tab-link"><i class="metismenu-icon pe-7s-add-user"></i> Gerar códigos</a>
        <a href="#" data-tab="marcar-horario" class="tab-link"><i class="metismenu-icon pe-7s-clock"></i> Marcar o horário</a>
        <a href="salsa-promotores" data-tab="logs-eventos" class="tab-link"><i class="metismenu-icon pe-7s-notebook"></i> Logs de eventos</a>
      </li>

    </ul>
  </div>
</div>

<div class="content-area">

  <div id="home" class="tab-content active">
    <h2>Bem-vindo ao ME</h2>
    <p>Área inicial do painel. Navegue pelo menu para acessar outras funcionalidades.</p>
  </div>

  <div id="calendario" class="tab-content">
    <h2>Calendário</h2>
    <p>Conteúdo do calendário aqui. Pode ser uma integração, um iframe ou sua própria página.</p>
  </div>

  <div id="dar-cargo-radio" class="tab-content">
    <h2>Dar Cargo Rádio</h2>
    <p>Formulários e controles para atribuir cargos na equipe rádio (implemente conforme necessidade).</p>
  </div>

  <div id="dar-pontos-presenca" class="tab-content">
    <h2>Dar Pontos de Presença</h2>
    <p>Interface para dar pontos de presença (implemente conforme necessidade).</p>
  </div>

  <div id="gerar-codigos" class="tab-content">
    <h2>Gerar Códigos</h2>
    <p>Ferramenta para gerar códigos (implemente conforme necessidade).</p>
  </div>

  <div id="marcar-horario" class="tab-content">
    <h2>Marcar Horário</h2>
    <p>Agendamento de horários (implemente conforme necessidade).</p>
  </div>

  <div id="logs-eventos" class="tab-content">
    <h2>Registrar Evento da Rádio</h2>
    <?php SalsaPromotores::salvar_evento($conn); ?>

    <form method="post" class="mb-4">
      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Responsável:</label>
          <input type="text" name="responsavel" class="form-control" required />
        </div>
        <div class="col-md-4 mb-3">
          <label>Nome do Evento:</label>
          <input type="text" name="nome_evento" class="form-control" required />
        </div>
        <div class="col-md-4 mb-3">
          <label>Data Realizado:</label>
          <input type="date" name="data_realizado" class="form-control" required />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Locutor:</label>
          <input type="text" name="locutor" class="form-control" required />
        </div>
        <div class="col-md-6 mb-3">
          <label>Ganhadores (um por linha):</label>
          <textarea name="ganhadores" class="form-control" rows="4" required></textarea>
        </div>
      </div>

      <button type="submit" name="salvar_evento" class="btn btn-primary w-100">Salvar Evento</button>
    </form>

    <h3>Eventos Registrados</h3>
    <?php SalsaPromotores::listar_eventos($conn); ?>
  </div>

</div>

<script>
  // Troca de abas
  document.querySelectorAll('.tab-link').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      document.querySelectorAll('.tab-link').forEach(a => a.classList.remove('active'));
      link.classList.add('active');
      document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
      const abaId = link.getAttribute('data-tab');
      const aba = document.getElementById(abaId);
      if (aba) aba.classList.add('active');
    });
  });

  // Toggle tema escuro/claro
  const botaoTema = document.getElementById('botao-tema');
  const labelTexto = document.querySelector('.label-text');

  function aplicarTema(tema) {
    const body = document.body;
    if (tema === 'escuro') {
      body.classList.add('tema-escuro');
      body.classList.remove('tema-claro');
      botaoTema.checked = true;
      labelTexto.textContent = "Modo Claro";
    } else {
      body.classList.add('tema-claro');
      body.classList.remove('tema-escuro');
      botaoTema.checked = false;
      labelTexto.textContent = "Modo Escuro";
    }
    localStorage.setItem('tema', tema);
  }

  botaoTema.addEventListener('change', () => {
    if (botaoTema.checked) {
      aplicarTema('escuro');
    } else {
      aplicarTema('claro');
    }
  });

  window.onload = () => {
    const temaSalvo = localStorage.getItem('tema') || 'claro';
    aplicarTema(temaSalvo);
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
