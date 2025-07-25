<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Saindo do Habbinc...</title>
<style>
  /* Fundo animado */
  @keyframes backgroundShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  
  body {
    background: linear-gradient(270deg, #6a11cb, #2575fc, #ff0080, #00ff99, #ffcc00);
    background-size: 1000% 1000%;
    animation: backgroundShift 30s ease infinite;
    color: #fff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    height: 100vh;
    margin: 0;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
    padding: 20px;
  }
  
  h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    text-shadow: 1px 1px 8px rgba(0,0,0,0.7);
  }
  
  .slider {
    position: relative;
    width: 350px;
    height: 60px;
    overflow: hidden;
    margin-bottom: 20px;
    font-weight: 600;
    font-size: 1.25rem;
    text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
  }
  
  .slide {
    position: absolute;
    width: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }
  
  .slide.active {
    opacity: 1;
  }
  
  .btn-return {
    background: linear-gradient(270deg, #ff00cc, #3333ff, #00ff99, #ffcc00);
    background-size: 800% 800%;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 12px 30px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow:
      0 0 15px #ff00cc,
      0 0 25px #3333ff,
      0 0 35px #00ff99,
      0 0 45px #ffcc00;
    text-decoration: none;
    display: inline-block;
    animation: colorShift 12s ease infinite;
    transition: box-shadow 0.3s ease;
    margin-top: 15px;
  }
  
  .btn-return:hover {
    box-shadow:
      0 0 25px #ff00cc,
      0 0 35px #3333ff,
      0 0 45px #00ff99,
      0 0 55px #ffcc00;
  }
  
  footer {
    margin-top: 30px;
    font-size: 0.9rem;
    opacity: 0.7;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
  }
  
  @keyframes colorShift {
    0% {
      background-position: 0% 50%;
      box-shadow:
        0 0 15px #ff00cc,
        0 0 25px #3333ff,
        0 0 35px #00ff99,
        0 0 45px #ffcc00;
    }
    25% {
      background-position: 50% 50%;
      box-shadow:
        0 0 20px #3333ff,
        0 0 30px #00ff99,
        0 0 40px #ffcc00,
        0 0 50px #ff00cc;
    }
    50% {
      background-position: 100% 50%;
      box-shadow:
        0 0 25px #00ff99,
        0 0 35px #ffcc00,
        0 0 45px #ff00cc,
        0 0 55px #3333ff;
    }
    75% {
      background-position: 50% 50%;
      box-shadow:
        0 0 20px #ffcc00,
        0 0 30px #ff00cc,
        0 0 40px #3333ff,
        0 0 50px #00ff99;
    }
    100% {
      background-position: 0% 50%;
      box-shadow:
        0 0 15px #ff00cc,
        0 0 25px #3333ff,
        0 0 35px #00ff99,
        0 0 45px #ffcc00;
    }
  }
</style>
</head>
<body>

<h2>Já vai sair do Habbinc? Que triste! Volte logo!</h2>

<div class="slider" aria-live="polite" aria-atomic="true">
  <div class="slide active">Sentiremos sua falta, volte logo!</div>
  <div class="slide">O Habbinc fica vazio sem você.</div>
  <div class="slide">Não fique longe muito tempo!</div>
  <div class="slide">Volte para curtir a diversão novamente.</div>
  <div class="slide">Esperamos por você sempre!</div>
</div>

<p id="countdown" style="font-weight: 600; font-size: 1.15rem; margin-top: 10px; text-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
  Saindo do Habbinc em <span id="seconds">10</span> segundos...
</p>

<a href="index.php" class="btn-return" role="button" aria-label="Voltar para o Habbinc">Clique aqui para voltar ao Habbinc</a>

<footer>Até breve! 👋</footer>

<script>
  // Slider frases
  const slides = document.querySelectorAll('.slide');
  let current = 0;
  function showNextSlide() {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
  }
  setInterval(showNextSlide, 3000);

  // Countdown e redirecionamento
  let secondsLeft = 10;
  const secondsSpan = document.getElementById('seconds');
  const countdownP = document.getElementById('countdown');

  const countdownInterval = setInterval(() => {
    secondsLeft--;
    if (secondsLeft <= 0) {
      clearInterval(countdownInterval);
      // Redireciona para index.php
      window.location.href = 'index.php';
    } else {
      secondsSpan.textContent = secondsLeft;
    }
  }, 1000);
</script>

</body>
</html>
