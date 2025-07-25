<?php
$titulo = "".usuario.": Comprar VIP - ".nome."";
include 'header.php';
?>

<div class="container py-4">
    <div class="row">
        <!-- COLUNA ESQUERDA -->
        <div class="col-lg-8 mb-4">
            <div id="vipCarousel" class="carousel slide shadow-sm rounded bg-white" data-ride="carousel" data-interval="5000" data-pause="false">
                <div class="carousel-inner p-4">

                    <!-- SLIDE 1 -->
                    <div class="carousel-item active">
                        <h4 class="font-weight-bold mb-3"><i class="fa fa-star text-warning"></i> Benefícios Gerais</h4>
                        <ul class="list-unstyled text-muted">
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> 1.000 diamantes por mês</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Emblema exclusivo VIP</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> 500 pontos no placar de conquistas</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Entrar em quartos lotados</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Quarto VIP exclusivo</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Perfil social diferenciado</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Duckets dobrados a cada 15min</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Mute por flood: 10s</li>
                        </ul>
                        <img src="https://i.imgur.com/hrAv9XI.png" class="img-fluid mt-3 d-block mx-auto" style="max-height: 120px;">
                    </div>

                    <!-- SLIDE 2 -->
                    <div class="carousel-item">
                        <h4 class="font-weight-bold mb-3"><i class="fa fa-diamond text-danger"></i> Catálogo dos VIPs</h4>
                        <ul class="list-unstyled text-muted">
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Raros exclusivos</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Mobis exclusivos</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Emblemas VIPs</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Acesso antecipado a coleções</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> Câmbios com imposto reduzido</li>
                        </ul>
                        <img src="https://i.imgur.com/5BjS8Lx.gif" class="img-fluid mt-3 d-block mx-auto" style="max-height: 120px;">
                    </div>

                    <!-- SLIDE 3 -->
                    <div class="carousel-item">
                        <h4 class="font-weight-bold mb-3"><i class="fa fa-terminal text-info"></i> Comandos Exclusivos</h4>
                        <ul class="list-unstyled text-muted">
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> <strong>:nsiga</strong> – impedir que te sigam</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> <strong>:ncopy</strong> – bloquear cópia de visual</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> <strong>:flagme</strong> – trocar de nick</li>
                            <li><img src="https://i.imgur.com/dfTrL6K.png"> <strong>:userinfo</strong> – ver dados de outros usuários</li>
                        </ul>
                        <img src="https://i.imgur.com/7Pb0R9R.png" class="img-fluid mt-3 d-block mx-auto" style="max-height: 120px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- COLUNA DIREITA - CHAMADA PARA COMPRA -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white text-center" style="background-color: #000;">
                    <strong>Adquira seu VIP agora!</strong>
                </div>
                <div class="card-body text-center">
                    <img src="https://i.imgur.com/7Pb0R9R.png" class="img-fluid mb-3" style="max-height: 100px;">
                    <p class="mb-2">Acesse nossa loja e escolha o plano ideal para você!</p>
                    <a href="/store" class="btn btn-success btn-block">Ir para a Loja</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Estilo adicional -->
<style>
    .carousel-item ul li {
        padding: 4px 0;
    }
</style>

<!-- JS (caso ainda não tenha incluso no CMS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
