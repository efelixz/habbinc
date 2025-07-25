
<style>
  body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: linear-gradient(270deg, #ff6ec4, #7873f5, #00c6ff, #f9d423);
    background-size: 800% 800%;
    animation: fundoAnimado 20s ease infinite;
    color: white;
    font-family: 'Segoe UI', sans-serif;
  }

  @keyframes fundoAnimado {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
  }

  .erro-box {
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 0 25px #fff;
    animation: brilho 2s infinite alternate;
  }

  @keyframes brilho {
    0% { box-shadow: 0 0 25px #00ffea; }
    100% { box-shadow: 0 0 45px #ff00f2; }
  }

  .loading-container {
    margin-top: 30px;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
  }

  .progress-bar {
    width: 100%;
    height: 25px;
    background-color: #111;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: inset 0 0 10px #000;
  }

  .progress-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(270deg, #ff00f2, #00f2ff, #8e44ad);
    background-size: 400% 100%;
    animation: carregamento 10s linear forwards, brilhoBarra 1s linear infinite;
    border-radius: 15px;
  }

  @keyframes carregamento {
    0% { width: 0%; }
    100% { width: 100%; }
  }

  @keyframes brilhoBarra {
    0% { background-position: 0% 0; }
    100% { background-position: 400% 0; }
  }

  .loading-text {
    font-size: 1.2rem;
    margin-top: 15px;
    animation: piscar 1.2s steps(2, start) infinite;
  }

  @keyframes piscar {
    to { visibility: hidden; }
  }

  .btn-return {
    background-color: #00f2ff;
    color: white;
    padding: 12px 25px;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    text-decoration: none;
    margin-top: 25px;
    display: inline-block;
    transition: 0.3s;
    box-shadow: 0 0 10px #00f2ff;
  }

  .btn-return:hover {
    background-color: #00cfff;
    box-shadow: 0 0 20px #00f2ff;
  }
</style>

<script>
  setTimeout(function () {
    window.location.href = '/me';
  }, 10000);
</script>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-10 text-center erro-box">

      <div class="d-flex align-items-center justify-content-center mb-4">
        <img src="https://3.bp.blogspot.com/-BJqpey89j-8/WUoLYCvCkwI/AAAAAAAA5MM/-sfTRmp4V0MgJFj7agE7fY6UZ3TF15U8gCKgBGAs/s1600/BR656.gif" alt="Erro" style="width: 50px; height: 50px; margin-right: 15px;">
        <h1 class="display-4 mb-0">404</h1>
      </div>

      <h3 class="font-weight-bold mb-3">Você caiu em um mundo desconhecido!</h3>
      <p class="mb-4" style="font-size: 1.1rem;">
        A página que você procurou não está aqui...<br>
        Retornando ao seu universo virtual.
      </p>

      <div class="loading-container">
        <div class="progress-bar">
          <div class="progress-fill"></div>
        </div>
        <div class="loading-text">Aguarde!</div>
      </div>

      <a href="me.php" class="btn-return">← Voltar agora</a>

    </div>
  </div>  
</div>
</body>
</html>
