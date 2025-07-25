<div class="scrollbar-sidebar ps ps--active-y">
  <div class="app-sidebar__inner">
    <ul class="vertical-nav-menu metismenu">

      <!-- Botão de tema com toggle switch -->
      <li class="app-sidebar__heading">Tema</li>
      <li class="tema-toggle-container">
        <label class="tema-toggle">
          <input type="checkbox" id="botao-tema" />
          <span class="slider"></span>
          <span class="label-text">Modo Escuro</span>
        </label>
      </li>

      <?php if ($rank >= 18 && $rank >= rmin && $rank != null): ?>
        <li class="app-sidebar__heading">DIRETORES</li>
        <li>
          <a href="salsa-banir-usuario"><i class="metismenu-icon pe-7s-close"></i> Banir um usuário</a>
          <a href="salsa-desbanir-usuario"><i class="metismenu-icon pe-7s-smile"></i> Desbanir um usuário</a>
          <a href="salsa-contas-fakes"><i class="metismenu-icon pe-7s-users"></i> Contas fakes</a>
          <a href="salsa-dar-cargo"><i class="metismenu-icon pe-7s-add-user"></i> Dar cargo</a>
        </li>
      <?php endif; ?>

      <li class="app-sidebar__heading">Menu</li>
      <li>
        <a href="salsa-bemvindo"><i class="metismenu-icon pe-7s-home"></i> Voltar ao ME</a>
        <a href="salsa-calenadario"><i class="metismenu-icon pe-7s-add-user"></i> Calendário</a>
      </li>

      <?php if ($rank >= 14 && $rank >= rmin && $rank != null): ?>
        <li class="app-sidebar__heading">Administradores</li>
        <li>
          <a href="salsa-publicar-noticias"><i class="metismenu-icon pe-7s-note2"></i> Publicar uma notícia</a>
          <a href="salsa-noticias"><i class="metismenu-icon pe-7s-print"></i> Notícias publicadas</a>
          <a href="salsa-dar-emblema-usuario"><i class="metismenu-icon pe-7s-photo"></i> Dar emblema</a>
          <a href="salsa-remover-emblema-usuario"><i class="metismenu-icon pe-7s-safe"></i> Remover emblema</a>
          <a href="salsa-dar-pontos-de-promocao"><i class="metismenu-icon pe-7s-cup"></i> Dar pontos de promoção</a>
          <a href="salsa-remover-promocao-ativa"><i class="metismenu-icon pe-7s-wallet"></i> Remover promoção ativa</a>
        </li>
      <?php endif; ?>

        <!-- Moderadores -->
        <?php if ($rank >= 15 && $rank >= rmin && $rank != null): ?>
          <li class="app-sidebar__heading">Moderadores</li>
          <li>
            <a href="salsa-conversas-de-quarto"><i class="metismenu-icon pe-7s-display1"></i> Conversas de quarto</a>
            <a href="salsa-contas-fakes"><i class="metismenu-icon pe-7s-users"></i> Contas fakes</a>
            <a href="salsa-premiar-usuario"><i class="metismenu-icon pe-7s-joy"></i> Premiar usuário</a>
          </li>
        <?php else: ?>
          <li class="app-sidebar__heading">Moderadores</li>
          <li><em>Acesso negado para Moderadores.</em></li>
        <?php endif; ?>

        <!-- Equipe Rádio -->
        <?php if ($rank >= 6 && $rank >= rmin && $rank != null): ?>
          <li class="app-sidebar__heading">Equipe Rádio</li>
          <li>      
            <a href="salsa-promotores"><i class="metismenu-icon pe-7s-add-user"></i> Logs de eventos</a>
            <a href="salsa-dar-cargo-radio"><i class="metismenu-icon pe-7s-add-user"></i> Dar cargo rádio</a>
            <a href="salsa-dar-pontos-presenca"><i class="metismenu-icon pe-7s-like2"></i> Dar pontos de presenças</a>
            <a href="salsa-gerar"><i class="metismenu-icon pe-7s-add-user"></i> Gerar códigos</a>
            <a href="salsa-marcar-horario"><i class="metismenu-icon pe-7s-clock"></i> Marcar o horário</a>
             <a href="salsa-marcarss"><i class="metismenu-icon pe-7s-clock"></i> em breve</a>
          </li>
        <?php else: ?>
          <li class="app-sidebar__heading">Equipe Rádio</li>
          <li><em>Acesso negado para Equipe Rádio.</em></li>
        <?php endif; ?>


    </ul>
  </div>
</div>

<style>
  /* Reset básico */
  body {
    transition: background-color 0.4s ease, color 0.4s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .app-sidebar__inner {
    transition: background-color 0.4s ease;
    padding: 15px;
    height: 100vh;
    overflow-y: auto;
  }

  /* Tema Claro */
  body.tema-claro {
    background-color: #f2f2f2;
    color: #111;
  }

  body.tema-claro .app-sidebar__inner {
    background: #fff;
    box-shadow: 2px 0 8px rgba(0,0,0,0.1);
  }

  /* Tema Escuro */
  body.tema-escuro {
    background-color: #121212;
    color: #ddd;
  }

  body.tema-escuro .app-sidebar__inner {
    background: #1d1d1d;
    box-shadow: 2px 0 8px rgba(0,0,0,0.6);
  }

  /* Estilos do menu */
  .vertical-nav-menu {
    list-style: none;
    padding-left: 0;
  }

  .vertical-nav-menu li {
    margin-bottom: 8px;
  }

  .app-sidebar__heading {
    font-weight: 700;
    font-size: 14px;
    color: #6c757d;
    text-transform: uppercase;
    margin: 20px 0 10px 15px;
    letter-spacing: 0.05em;
  }

  .vertical-nav-menu a {
    display: flex;
    align-items: center;
    color: inherit;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
  }

  .vertical-nav-menu a:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffd700;
  }

  .vertical-nav-menu i.metismenu-icon {
    margin-right: 12px;
    font-size: 18px;
    transition: transform 0.3s ease;
  }

  .vertical-nav-menu a:hover i.metismenu-icon {
    transform: rotate(15deg);
    color: #ffd700;
  }

  /* Toggle switch container */
  .tema-toggle-container {
    padding: 10px 15px;
  }

  /* Toggle switch */
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

  /* Slider */
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
    background-color: #4caf50;
  }

  .tema-toggle input:checked + .slider::before {
    transform: translateX(22px);
  }

  /* Texto do toggle */
  .label-text {
    font-weight: 600;
    font-size: 14px;
    color: inherit;
    user-select: none;
  }

</style>

<script>
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
    const temaSalvo = localStorage.getItem('tema') || 'escuro';
    aplicarTema(temaSalvo);
  };
</script>
