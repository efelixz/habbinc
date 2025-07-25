<?php 
$titulo = "".usuario.":  Hall da Fama - ".nome."";
include 'header.php';
?>

<style>
    /* Ícones nas abas */
    .nav-tabs .nav-link {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        font-size: 15px;
        color: #ddd;
        cursor: pointer;
    }
    .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #1e262c;
        border-color: #3a8eee #3a8eee #111;
    }
    .nav-tabs .nav-link svg {
        fill: currentColor;
    }

    /* Cards gerais */
    .card {
        background: #2a343e;
        border: 1px solid #3a4550;
        color: #eee;
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(58, 142, 238, 0.7);
    }
    .card a {
        color: #3a8eee;
        text-decoration: none;
        font-weight: 700;
    }
    .card a:hover {
        text-decoration: underline;
    }

    /* Promoções sem destaque dourado, fundo um pouco mais claro */
    .tab-pane#promocoes .card {
        background-color: #324150 !important;
        color: #f0f0f0 !important;
    }

    /* Destaque dos números em negrito e azul claro */
    .card b {
        color: #a7d7ff;
        font-size: 1.1em;
    }

    /* Destaque para os top 3 */
    .top3 {
        border: 2px solid #3a8eee !important;
        box-shadow: 0 0 15px #3a8eee !important;
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
</style>

<div class="container">
    <ul class="nav nav-tabs" id="hallFamaTabs" role="tablist" style="margin-bottom: 20px; border-bottom: 2px solid #3a8eee;">
        <li class="nav-item">
            <a class="nav-link active" id="promocoes-tab" data-toggle="tab" href="#promocoes" role="tab" aria-controls="promocoes" aria-selected="true">
                <!-- Ícone Jornal -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                  <path d="M5 8h6v1H5V8zM5 5h6v1H5V5z"/>
                  <path d="M3 2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H3zM2 3a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3z"/>
                </svg>
                Promoções
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="eventos-tab" data-toggle="tab" href="#eventos" role="tab" aria-controls="eventos" aria-selected="false">
                <!-- Ícone Gamepad -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-controller" viewBox="0 0 16 16">
                  <path d="M11.5 7a.5.5 0 0 1 .5.5V9h1a.5.5 0 0 1 0 1h-1v1.5a.5.5 0 0 1-1 0V10h-1a.5.5 0 0 1 0-1h1V7.5a.5.5 0 0 1 .5-.5z"/>
                  <path d="M2.25 7a.75.75 0 0 0 0 1.5h11.5a.75.75 0 0 0 0-1.5H2.25z"/>
                  <path d="M7.5 3a.5.5 0 0 1 .5.5v1H9a.5.5 0 0 1 0 1H8v1.5a.5.5 0 0 1-1 0V5H5a.5.5 0 0 1 0-1h1v-1A.5.5 0 0 1 7.5 3z"/>
                </svg>
                Eventos
            </a>
        </li>
        <!-- Nova aba Presença Rádio -->
        <li class="nav-item">
            <a class="nav-link" id="presenca-radio-tab" data-toggle="tab" href="#presenca-radio" role="tab" aria-controls="presenca-radio" aria-selected="false">
                <!-- Ícone Microfone -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-mic" viewBox="0 0 16 16">
                  <path d="M8 12a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v4a3 3 0 0 0 3 3z"/>
                  <path d="M5 10.5a.5.5 0 0 1 1 0v.5a2.5 2.5 0 0 0 5 0v-.5a.5.5 0 0 1 1 0v.5a3.5 3.5 0 0 1-7 0v-.5z"/>
                  <path d="M8 15a.5.5 0 0 1 .5.5v.5H7.5v-.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Presença Rádio
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="creditos-tab" data-toggle="tab" href="#creditos" role="tab" aria-controls="creditos" aria-selected="false">
                <!-- Ícone Moeda -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zM8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0z"/>
                  <path d="M8 4a4 4 0 1 1 0 8 4 4 0 0 1 0-8z"/>
                </svg>
                Créditos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="referidos-tab" data-toggle="tab" href="#referidos" role="tab" aria-controls="referidos" aria-selected="false">
                <!-- Ícone Pessoas -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                  <path d="M5.5 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM11.5 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                  <path d="M4 8c-1 0-2 1-2 2v1h6v-1c0-1-1-2-2-2H4zM11 8c-1 0-2 1-2 2v1h6v-1c0-1-1-2-2-2h-2z"/>
                </svg>
                Referidos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="duckets-tab" data-toggle="tab" href="#duckets" role="tab" aria-controls="duckets" aria-selected="false">
                <!-- Ícone Sacola -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                  <path d="M8 1a2 2 0 0 1 2 2v1H6V3a2 2 0 0 1 2-2z"/>
                  <path d="M3 4h10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4z"/>
                </svg>
                Duckets
            </a>
        </li>

    </ul>

    <div class="tab-content" id="hallFamaTabsContent">

        <!-- Promoções -->
        <div class="tab-pane fade show active" id="promocoes" role="tabpanel" aria-labelledby="promocoes-tab">
            <div class="row">
                <?php
                $sql = "SELECT * FROM users ORDER BY pontos_promocao DESC LIMIT 30";
                $res = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = $res->fetch_assoc()) {
                    $count++;
                    $classe = ($count <= 3) ? "top3" : "";
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card <?php echo $classe ?>">
                            <div class="card-body d-flex align-items-center">
                                <div style="background-image:url(<?php echo avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml); width:60px; height:60px; background-size:cover; border-radius:6px;"></div>
                                <div style="margin-left: 10px;">
                                    <strong><a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a></strong><br>
                                    Ganhou <b><?php echo $row['pontos_promocao'] ?></b> promoç<?php echo ($row['pontos_promocao'] > 1) ? "ões" : "ão"; ?>.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Eventos -->
        <div class="tab-pane fade" id="eventos" role="tabpanel" aria-labelledby="eventos-tab">
            <div class="row">
                <?php
                $sql = "SELECT * FROM users ORDER BY pontos_evento DESC LIMIT 30";
                $res = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = $res->fetch_assoc()) {
                    $count++;
                    $classe = ($count <= 3) ? "top3" : "";
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card <?php echo $classe ?>">
                            <div class="card-body d-flex align-items-center">
                                <div style="background-image:url(<?php echo avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml); width:60px; height:60px; background-size:cover; border-radius:6px;"></div>
                                <div style="margin-left: 10px;">
                                    <strong><a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a></strong><br>
                                    Ganhou <b><?php echo $row['pontos_evento'] ?></b> evento<?php echo ($row['pontos_evento'] > 1) ? "s" : ""; ?>.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Créditos -->
        <div class="tab-pane fade" id="creditos" role="tabpanel" aria-labelledby="creditos-tab">
            <div class="row">
                <?php
                $sql = "SELECT * FROM users ORDER BY credits DESC LIMIT 30";
                $res = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = $res->fetch_assoc()) {
                    $count++;
                    $classe = ($count <= 3) ? "top3" : "";
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card <?php echo $classe ?>">
                            <div class="card-body d-flex align-items-center">
                                <div style="background-image:url(<?php echo avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml); width:60px; height:60px; background-size:cover; border-radius:6px;"></div>
                                <div style="margin-left: 10px;">
                                    <strong><a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a></strong><br>
                                    Possui <b><?php echo $row['credits'] ?></b> crédito<?php echo ($row['credits'] > 1) ? "s" : ""; ?>.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Referidos -->
        <div class="tab-pane fade" id="referidos" role="tabpanel" aria-labelledby="referidos-tab">
            <div class="row">
                <?php
                $sql = "SELECT * FROM users ORDER BY referidos DESC LIMIT 30";
                $res = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = $res->fetch_assoc()) {
                    $count++;
                    $classe = ($count <= 3) ? "top3" : "";
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card <?php echo $classe ?>">
                            <div class="card-body d-flex align-items-center">
                                <div style="background-image:url(<?php echo avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml); width:60px; height:60px; background-size:cover; border-radius:6px;"></div>
                                <div style="margin-left: 10px;">
                                    <strong><a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a></strong><br>
                                    Colecionou <b><?php echo $row['referidos'] ?></b> referido<?php echo ($row['referidos'] > 1) ? "s" : ""; ?>.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Duckets -->
        <div class="tab-pane fade" id="duckets" role="tabpanel" aria-labelledby="duckets-tab">
            <div class="row">
                <?php
                $sql = "SELECT * FROM users ORDER BY pixels DESC LIMIT 30";
                $res = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = $res->fetch_assoc()) {
                    $count++;
                    $classe = ($count <= 3) ? "top3" : "";
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card <?php echo $classe ?>">
                            <div class="card-body d-flex align-items-center">
                                <div style="background-image:url(<?php echo avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml); width:60px; height:60px; background-size:cover; border-radius:6px;"></div>
                                <div style="margin-left: 10px;">
                                    <strong><a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a></strong><br>
                                    Possui <b><?php echo $row['pixels'] ?></b> ducket<?php echo ($row['pixels'] > 1) ? "s" : ""; ?>.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- Presença Rádio -->
<div class="tab-pane fade" id="presenca-radio" role="tabpanel" aria-labelledby="presenca-radio-tab">
    <div class="row">
        <?php
        // Query para buscar usuários ordenados pelos pontos de presença
        $sql = "SELECT * FROM users ORDER BY pontos_presenca DESC LIMIT 30";
        $res = mysqli_query($conn, $sql);
        $count = 0;
        while ($row = $res->fetch_assoc()) {
            $count++;
            $classe = ($count <= 3) ? "top3" : "";
        ?>
            <div class="col-md-4 mb-3">
                <div class="card <?php echo $classe ?>">
                    <div class="card-body d-flex align-items-center">
                        <div style="background-image:url(<?php echo avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml); width:60px; height:60px; background-size:cover; border-radius:6px;"></div>
                        <div style="margin-left: 10px;">
                            <strong><a href="/perfil?=<?php echo $row['username'] ?>"><?php echo htmlspecialchars($row['username']) ?></a></strong><br>
                            Possui <b><?php echo $row['pontos_presenca'] ?></b> ponto<?php echo ($row['pontos_presenca'] > 1) ? "s" : ""; ?> de presença na rádio.
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


    </div>
</div>


<!-- JS para funcionamento das abas (Bootstrap 4) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>

    </html>