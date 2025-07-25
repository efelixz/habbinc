<?php
$titulo = "".usuario.": Loja - ".nome."";
include 'header.php';
?>

<div class="container ng-scope py-4" ng-controller="storeController">
    <div class="row">

        <!-- COLUNA PRINCIPAL DA LOJA -->
        <div class="col-lg-8 mb-4">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <?php SalsaConta::comprarpontos($conn) ?>
                    <div class="card shadow border-0">
                        <div class="card-img-top" style="height: 140px; background: url('https://images.habbo.com/web_images/habbo-web-articles/lpromo_gen15_79.png') center/cover no-repeat; border-radius: .5rem .5rem 0 0;"></div>
                        <div class="card-body">
                            <h5 class="card-title">1.000 Pontos de Conquista</h5>
                            <p class="card-text text-muted">Aumenta seu placar em mil pontos.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge badge-pill badge-secondary">500.000 créditos</span>
                                <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-primary">Comprar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adicione mais produtos aqui replicando o bloco acima -->
            </div>
        </div>

        <!-- SIDEBAR INFORMATIVA -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fa fa-info-circle"></i> Sobre a Loja
                </div>
                <div class="card-body text-muted small">
                    <p>A <b>Store</b> permite comprar itens com moedas do hotel.</p>
                    <p><b>Itens disponíveis:</b></p>
                    <ul class="list-unstyled">
                        <li>• Placar de conquistas</li>
                        <li>• Pacote de emblemas</li>
                        <li>• Efeitos especiais</li>
                        <li>• Comandos temporários</li>
                        <li>• Quartos decorados</li>
                    </ul>
                    <p>Fique de olho! Itens por tempo limitado.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE CONFIRMAÇÃO DE COMPRA -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar compra</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        Você está prestes a comprar <b>1.000 pontos de conquista</b> por <b>500.000 moedas</b>.<br>Deseja continuar?
      </div>
      <div class="modal-footer">
        <form method="POST">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="comprar" class="btn btn-primary">Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DE MÉTODO DE PAGAMENTO -->
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Escolher Método</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>
      <div class="modal-body">
        <div id="alerts" class="alert alert-danger">Você não possui Duckets o suficiente!</div>
        <h5 class="text-center" id="price">800 Duckets</h5>
        <div id="buttons">
          <button class="btn btn-danger btn-block btn-lg ng-scope" ng-click="buyProduct(7)">
            Comprar com Duckets
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- RODAPÉ -->

<style>
    .salsa {
        height: 380px;
    }
</style>

<div class="salsa"></div>

</body>
</html>
