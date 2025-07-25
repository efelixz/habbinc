<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$titulo = usuario . ": Rádio - " . nome;
include 'header.php';

$avatarimage = "https://habbo.city/habbo-imaging/avatarimage?figure=";

$cargoImagens = [
    14 => ['nome' => 'CEO', 'imagem' => 'https://i.imgur.com/7CZ2JuG.png'],
    13 => ['nome' => 'Diretora', 'imagem' => 'https://i.imgur.com/nfB6xlh.png'],
    12 => ['nome' => 'Administradores', 'imagem' => 'https://i.imgur.com/IZVmG4v.png'],
    11 => ['nome' => 'Coordenadores', 'imagem' => 'https://i.imgur.com/jtXamrc.png'],
    7 => ['nome' => 'Locutores', 'imagem' => 'https://i.imgur.com/XXZGGbB.png'],  // exemplo, pode trocar
    6 => ['nome' => 'Promotores', 'imagem' => 'https://i.imgur.com/abcd123.png'], // exemplo, trocar
];

define('TEMPO_ONLINE_EM_SEGUNDOS', 600); // 10 minutos para considerar "online"

if (!function_exists('fs')) {
    function fs($text) {
        return htmlspecialchars($text);
    }
}

function tempoNaEquipe($timestampEntrada) {
    if (!$timestampEntrada) return 'Desconhecido';

    $agora = time();
    $diferenca = $agora - $timestampEntrada;

    if ($diferenca < 3600) {
        $minutos = floor($diferenca / 60);
        if ($minutos <= 1) return 'Menos de 1 minuto';
        return $minutos . ' minuto' . ($minutos > 1 ? 's' : '');
    }

    $horas = floor($diferenca / 3600);
    if ($horas < 24) return $horas . ' hora' . ($horas > 1 ? 's' : '');

    $dias = floor($diferenca / 86400);
    if ($dias < 7) return $dias . ' dia' . ($dias > 1 ? 's' : '');

    $semanas = floor($dias / 7);
    if ($semanas < 4) return $semanas . ' semana' . ($semanas > 1 ? 's' : '');

    $meses = floor($dias / 30);
    if ($meses < 12) return $meses . ' mês' . ($meses > 1 ? 'es' : '');

    $anos = floor($meses / 12);
    return $anos . ' ano' . ($anos > 1 ? 's' : '');
}

function exibirUsuarioCompacto($user, $avatarimage, $cargoImagens, $isOnline) {
    $rank = intval($user['rank']);
    $cargo = isset($cargoImagens[$rank]) ? $cargoImagens[$rank]['nome'] : 'Membro';
    $cargoImg = isset($cargoImagens[$rank]) ? $cargoImagens[$rank]['imagem'] : '';
    ?>
    <div class="user-card-compact">
        <div class="user-avatar" style="background-image: url('<?php echo $avatarimage . $user['look']; ?>&size=m&head_direction=2&gesture=sml');"></div>
        <?php if ($cargoImg): ?>
            <img src="<?php echo $cargoImg; ?>" alt="<?php echo $cargo; ?>" class="cargo-img" title="<?php echo $cargo; ?>">
        <?php endif; ?>
        <a href="/perfil?=<?php echo urlencode($user['username']); ?>" class="username"><?php echo fs($user['username']); ?></a>
        <span class="badge <?php echo $isOnline ? 'badge-success' : 'badge-secondary'; ?>" title="<?php echo $isOnline ? 'Online' : 'Offline'; ?>">
            <?php echo $isOnline ? 'Online' : 'Offline'; ?>
        </span>

        <div class="user-info-compact">
            <div><b>Missão:</b> <?php echo fs($user['motto']); ?></div>
            <div><b>Discord:</b> <?php echo fs($user['discord']); ?></div>
            <div><b>Funções:</b> <?php echo !empty($user['tasks']) ? fs($user['tasks']) : 'Não informado'; ?></div>
            <div><b>Tempo na equipe:</b> <?php echo tempoNaEquipe(intval($user['contract_start'])); ?></div>
        </div>
    </div>
    <?php
}

function listarUsuariosPorRank($conn, $rank, $cargoImagens, $avatarimage) {
    $rank = intval($rank);

    $sql = "SELECT * FROM users WHERE rank=$rank ORDER BY username ASC";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $usuarios = [];
    while ($user = $query->fetch_assoc()) {
        $isOnline = false;
        if ($user['online'] == 1) {
            $isOnline = true;
        } else {
            $now = time();
            if (isset($user['last_online']) && ($now - intval($user['last_online']) <= TEMPO_ONLINE_EM_SEGUNDOS)) {
                $isOnline = true;
            }
        }
        $user['isOnlineReal'] = $isOnline;
        $usuarios[] = $user;
    }

    if (count($usuarios) === 0) return false;

    usort($usuarios, function($a, $b){
        return ($b['isOnlineReal'] <=> $a['isOnlineReal']) ?: strcmp($a['username'], $b['username']);
    });

    $info = $cargoImagens[$rank] ?? ['nome' => 'Membro', 'imagem' => ''];

    ?>
    <section class="cargo-section" data-rank="<?php echo $rank; ?>">
        <h3 class="cargo-title">
            <?php if($info['imagem']): ?>
            <img src="<?php echo $info['imagem']; ?>" alt="<?php echo $info['nome']; ?>" class="cargo-section-img" />
            <?php endif; ?>
            <?php echo $info['nome']; ?>
        </h3>
        <div class="slider-container">
            <div class="slider-track">
                <?php
                foreach ($usuarios as $user) {
                    exibirUsuarioCompacto($user, $avatarimage, $cargoImagens, $user['isOnlineReal']);
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    return true;
}

function obterRanksComUsuarios($conn, $ranksValidos) {
    $ranksStr = implode(',', $ranksValidos);
    $sql = "SELECT DISTINCT rank FROM users WHERE rank IN ($ranksStr) ORDER BY rank DESC";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $ranks = [];
    while ($row = $result->fetch_assoc()) {
        $ranks[] = intval($row['rank']);
    }
    return $ranks;
}

$ranksValidos = array_keys($cargoImagens);
$ranksComUsuarios = obterRanksComUsuarios($conn, $ranksValidos);
?>

<div class="container mt-4">

    <h2 class="equipes-titulo">Equipe Rádio</h2>

    <div class="tabs-wrapper">
        <div class="tabs">
            <a href="/staff" class="tab-btn">Staff</a>
            <a href="/colaboradores" class="tab-btn">Colaboradores</a>
            <button class="tab-btn active" data-tab="radio">Rádio Binc</button>
        </div>

        <div class="tab-content" id="tab-radio" style="display: block;">
            <?php
            if(empty($ranksComUsuarios)) {
                echo '<p>Nenhum membro encontrado na equipe de rádio.</p>';
            } else {
                foreach ($ranksComUsuarios as $rank) {
                    listarUsuariosPorRank($conn, $rank, $cargoImagens, $avatarimage);
                }
            }
            ?>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 980px;
}

.equipes-titulo {
    font-size: 32px;
    font-weight: 700;
    color: #1e262c;
    margin-bottom: 30px;
    border-bottom: 3px solid #1e262c;
    padding-bottom: 10px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.tabs-wrapper {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.tabs {
    display: flex;
    background: #f9f9f9;
}

.tab-btn {
    flex: 1;
    padding: 12px 20px;
    font-weight: 600;
    color: #555;
    background: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    text-align: center;
    font-size: 16px;
    text-decoration: none;
}

.tab-btn:hover:not(.active) {
    background-color: #e0e0e0;
    color: #111;
}

.tab-btn.active {
    background-color: #1e262c;
    color: white;
    font-weight: 700;
    cursor: default;
}

.tab-content {
    padding: 20px;
    background-color: white;
}

/* Cargo section */
.cargo-section {
    margin-bottom: 40px;
}

.cargo-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 22px;
    font-weight: 700;
    color: #1e262c;
    margin-bottom: 15px;
}

.cargo-section-img {
    width: 48px;
    height: 48px;
}

/* Slider container */
.slider-container {
    position: relative;
    overflow: hidden;
}

/* Slider track */
.slider-track {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 10px;
}

/* Esconder scrollbar padrão */
.slider-track::-webkit-scrollbar {
    display: none;
}
.slider-track {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Cards compactos dos usuarios */
.user-card-compact {
    flex: 0 0 220px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 12px;
    box-shadow: 0 1px 4px rgb(0 0 0 / 0.1);
    text-align: left;
    position: relative;
    user-select: none;
    transition: transform 0.3s ease;
}

.user-card-compact:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
}

.user-avatar {
    width: 80px;
    height: 80px;
    margin: 0 0 8px 0;
    background-size: cover;
    background-position: center;
    border-radius: 12px;
}

.cargo-img {
    width: 32px;
    height: 32px;
    position: absolute;
    top: 10px;
    right: 10px;
}

.username {
    display: block;
    font-weight: 700;
    font-size: 18px;
    color: #007bff;
    margin: 0 0 10px 0;
    text-decoration: none;
}

.username:hover {
    text-decoration: underline;
}

.badge {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 12px;
    user-select: none;
    margin-bottom: 8px;
    display: inline-block;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-secondary {
    background-color: #6c757d;
    color: #fff;
}

/* Informações extras */
.user-info-compact b {
    color: #1e262c;
}

.user-info-compact div {
    font-size: 13px;
    color: #555;
    margin-bottom: 4px;
}

/* Responsivo */
@media (max-width: 768px) {
    .user-card-compact {
        flex: 0 0 180px;
        padding: 10px;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
    }

    .username {
        font-size: 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tab switching for Rádio only (Staff and Colaboradores are links)
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            if (btn.dataset.tab === 'radio') {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
                document.getElementById('tab-radio').style.display = 'block';
            }
        });
    });
});
</script>

<div style="font-weight: 14px; background: #1e262c; padding: 10px; border-top: 4px solid #1b2228; margin-top: 30px;">
    <div class="container">
        <span style="color:#a7a7a7;">
            © <?php echo date('Y'); ?> Rede <?php echo nome; ?> Corporation Ltd. Todos os direitos reservados.
        </span>
    </div>
</div>
</body>
</html>
