<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Habbinc › Manutenção</title>
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #121212;
      color: #ddd;
      margin: 0; padding: 0;
    }
    .header, .footer {
      background: #1f1f1f;
      padding: 10px 0;
      text-align: center;
    }
    .footer .links a {
      color: #bbb;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    .footer .links a:hover {
      color: #eee;
    }
    .center {
      max-width: 1100px;
      margin: 0 auto;
      padding: 15px;
    }
    .sub_header {
      background: #222;
      padding: 30px 0;
      text-align: center;
      border-bottom: 1px solid #333;
    }
    .compteur {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 15px;
      font-weight: 600;
    }
    .case {
      background: #2a2a2a;
      padding: 20px 25px;
      border-radius: 10px;
      min-width: 80px;
      color: #ddd;
    }
    .case span {
      font-size: 3em;
      display: block;
      color: #eee;
      text-align: center;
    }
    .case p {
      font-size: 1em;
      color: #bbb;
      text-transform: uppercase;
      text-align: center;
    }
    .page {
      display: flex;
      justify-content: center;
      gap: 30px;
      padding: 30px 0;
      flex-wrap: wrap;
    }
    .box {
      background: #1f1f1f;
      border-radius: 15px;
      padding: 20px;
      flex: 1 1 400px;
      max-width: 480px;
    }
    .title h1 {
      color: #eee;
      margin-bottom: 10px;
    }
    .title p {
      color: #aaa;
      font-weight: 400;
      margin-bottom: 20px;
    }
    .progress-container {
      margin-bottom: 20px;
    }
    .progress-container div:first-child {
      color: #ccc;
      font-weight: 600;
      margin-bottom: 5px;
    }
    .progress-bar-wrapper {
      background: #2c2c2c;
      border-radius: 8px;
      overflow: hidden;
      height: 20px;
    }
    #progressBar {
      width: 0%;
      height: 100%;
      background: linear-gradient(to right, #00d2ff, #3a47d5);
      transition: width 0.6s ease;
    }
    .content .bloc {
      display: flex;
      align-items: center;
      gap: 20px;
      background: #2c2c2c;
      padding: 15px;
      border-radius: 12px;
      margin-bottom: 25px;
      color: #ddd;
    }
    .icon {
      flex-shrink: 0;
      width: 64px;
      height: 64px;
    }
    .icon svg {
      width: 64px;
      height: 64px;
    }
    .bull h1 {
      font-size: 1.2em;
      color: #eee;
      margin-bottom: 6px;
    }
    .bull p {
      color: #bbb;
      font-size: 0.9em;
    }
    iframe {
      border-radius: 15px;
      width: 100%;
      max-width: 350px;
      height: 500px;
    }
    audio { display: none; }
    #slides { overflow: hidden; }
    #slideWrapper {
      display: flex;
      transition: transform 0.6s ease;
    }
    .bloc {
      min-width: 100%;
    }
    .nav-buttons {
      text-align: center;
      margin-top: 15px;
    }
    .nav-buttons button {
      padding: 8px 12px;
      background: #333;
      border: none;
      color: #fff;
      border-radius: 5px;
      margin: 0 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="header"></div>

  <div class="sub_header">
    <div class="center">
      <h1>Faltam em:</h1>
      <div class="compteur" id="countdown">
        <div class="case"><span id="days">0</span><p>Dias</p></div>
        <div class="case"><span id="hours">00</span><p>Horas</p></div>
        <div class="case"><span id="minutes">00</span><p>Minutos</p></div>
        <div class="case"><span id="seconds">00</span><p>Segundos</p></div>
      </div>
    </div>
  </div>

  <div class="page">
    <!-- Esquerda -->
    <div class="box left">
      <div class="title">
        <h1>Atualizações</h1>
        <p>Veja o que falta para abrir o Habbinc</p>
      </div>

      <div class="content">
        <div class="progress-container">
          <div>Progresso Total: <span id="percentText">0%</span></div>
          <div class="progress-bar-wrapper">
            <div id="progressBar"></div>
          </div>
        </div>

        <div id="slides">
          <div id="slideWrapper">
            <div class="bloc">
              <div class="icon"><svg width="64" height="64" viewBox="0 0 64 64"><rect x="12" y="14" width="40" height="30" stroke="#ddd" stroke-width="3" rx="4" ry="4" fill="#2a2a2a"/><rect x="22" y="46" width="20" height="6" fill="#444"/><rect x="27" y="52" width="10" height="2" fill="#666"/></svg></div>
              <div class="bull"><h1>Passo 1 › Client (50%)</h1><p>O trabalho no client já começou.</p></div>
            </div>
            <div class="bloc">
              <div class="icon"><svg width="64" height="64" viewBox="0 0 64 64"><rect x="12" y="20" width="40" height="28" stroke="#ddd" stroke-width="3" rx="3" ry="3" fill="#2a2a2a"/><path d="M12 20L22 10H42L52 20" stroke="#ddd" stroke-width="3"/></svg></div>
              <div class="bull"><h1>Passo 2 › CMS (100%)</h1><p>O CMS está finalizado!</p></div>
            </div>
            <div class="bloc">
              <div class="icon"><svg width="64" height="64" viewBox="0 0 64 64"><circle cx="22" cy="20" r="8" stroke="#ddd" stroke-width="3" fill="#2a2a2a"/><circle cx="42" cy="20" r="8" stroke="#ddd" stroke-width="3" fill="#2a2a2a"/><path d="M12 44C12 36 52 36 52 44V50H12V44Z" stroke="#ddd" stroke-width="3" fill="#2a2a2a"/></svg></div>
              <div class="bull"><h1>Passo 3 › Equipe (50%)</h1><p>Montando a equipe!</p></div>
            </div>
            <div class="bloc">
              <div class="icon"><svg width="64" height="64" viewBox="0 0 64 64"><ellipse cx="32" cy="14" rx="20" ry="8" stroke="#ddd" stroke-width="3" fill="#2a2a2a"/><path d="M12 14V42C12 50 52 50 52 42V14" stroke="#ddd" stroke-width="3" fill="#2a2a2a"/><ellipse cx="32" cy="42" rx="20" ry="8" stroke="#ddd" stroke-width="3" fill="#2a2a2a"/></svg></div>
              <div class="bull"><h1>Passo 4 › Banco (70%)</h1><p>Banco de dados em andamento.</p></div>
            </div>
            <div class="bloc">
              <div class="icon"><svg width="64" height="64" viewBox="0 0 64 64"><rect x="14" y="12" width="36" height="40" stroke="#ddd" stroke-width="3" fill="#2a2a2a" rx="4"/><path d="M22 26L28 32L38 22" stroke="#ddd" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M22 36H42" stroke="#ddd" stroke-width="3" stroke-linecap="round"/></svg></div>
              <div class="bull"><h1>Passo 5 › Testes (30%)</h1><p>Realizando testes finais.</p></div>
            </div>
          </div>
        </div>

        <div class="nav-buttons">
          <button onclick="mudarSlide(-1)">← Anterior</button>
          <button onclick="mudarSlide(1)">Próximo →</button>
        </div>
      </div>
    </div>

    <!-- Direita -->
    <div class="box right">
      <div class="title">
        <h1>Entre em nosso Discord</h1>
      </div>
      <div class="content">
        <iframe src="https://discord.com/widget?id=1390816968524697641&theme=dark" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
      </div>
    </div>
  </div>

  <div class="footer">
    <div class="center">
      <div class="links">
        <a href="https://habbinc.net" target="_blank">Habbinc</a>
      </div>
    </div>
  </div>

  <audio autoplay loop muted>
    <source src="ailovers.mp3" type="audio/mpeg" />
  </audio>

  <script>
    // Progresso
    function calcularProgresso() {
      const etapas = [50, 100, 50, 70, 30];
      const media = Math.floor(etapas.reduce((a, b) => a + b, 0) / etapas.length);
      document.getElementById("progressBar").style.width = media + "%";
      document.getElementById("percentText").textContent = media + "%";
    }

    // Slide
    let slideAtual = 0;
    function mudarSlide(direcao) {
      const wrapper = document.getElementById("slideWrapper");
      const total = wrapper.children.length;
      slideAtual = (slideAtual + direcao + total) % total;
      wrapper.style.transform = `translateX(-${slideAtual * 100}%)`;
    }

    // Contador
    const targetDate = new Date(Date.now() + 25 * 24 * 60 * 60 * 1000);
    function updateCountdown() {
      const now = new Date();
      const diff = targetDate - now;
      if (diff <= 0) return;

      const d = Math.floor(diff / (1000 * 60 * 60 * 24));
      const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
      const m = Math.floor((diff / (1000 * 60)) % 60);
      const s = Math.floor((diff / 1000) % 60);

      document.getElementById('days').textContent = d;
      document.getElementById('hours').textContent = h.toString().padStart(2, '0');
      document.getElementById('minutes').textContent = m.toString().padStart(2, '0');
      document.getElementById('seconds').textContent = s.toString().padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    calcularProgresso();
    updateCountdown();
  </script>

</body>
</html>
