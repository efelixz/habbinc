<?php
@session_start();
error_reporting(0); // Oculta notices e warnings

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "teste");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se username está na sessão
$username = $_SESSION['username'] ?? '';
if (empty($username)) {
    die("<div style='color:white; padding:20px;'>Erro: Usuário não logado.</div>");
}

// Pega o look do banco
$sql = "SELECT look FROM usuarios WHERE username = '$username' LIMIT 1";
$result = $conn->query($sql);
$look = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['look'] : 'ch-3015-92.hr-802-61.hd-190-1.lg-275-82.sh-3063-92';

// Lista de visuais prontos
$visuais = [
    'Visual 1' => 'ch-3015-92.hr-802-61.hd-190-1.lg-275-82.sh-3063-92',
    'Visual 2' => 'ch-255-66.hr-100-45.hd-209-1.lg-280-82.sh-3063-92',
    'Visual 3' => 'ch-255-66.hr-831-61.hd-195-1.lg-270-64.sh-290-64',
];

// Se mudou visual via GET
if (isset($_GET['visual']) && !empty($_GET['visual'])) {
    $look = $_GET['visual'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Gerador de Avatar - <?php echo htmlspecialchars($username); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background: #121217; color: #eee; font-family: Arial, sans-serif; }
        .container { margin-top: 30px; max-width: 600px; }
        .avatar-preview { background: #222; border-radius: 12px; padding: 15px; text-align: center; }
        #avatar_img { border-radius: 12px; }
        .btn-download { width: 100%; margin-top: 15px; }
        label { font-weight: 600; margin-top: 20px; display: block; }
        select {
            background: #1f1f2b; border: 1px solid #444; color: #eee;
            padding: 8px; border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">👕 Gerador de Avatar com Roupas</h3>

    <div class="avatar-preview">
        <img id="avatar_img" src="https://habbo.city/habbo-imaging/avatarimage?figure=<?php echo htmlspecialchars($look); ?>&direction=2&head_direction=2&gesture=sml&action=wav&size=l&img_format=gif" alt="Avatar" />
    </div>

    <form method="get">
        <label>Escolha um visual:</label>
        <select name="visual" onchange="this.form.submit()">
            <?php foreach ($visuais as $nome => $code): ?>
                <option value="<?php echo $code; ?>" <?php if ($look == $code) echo 'selected'; ?>>
                    <?php echo $nome; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <a href="https://habbo.city/habbo-imaging/avatarimage?figure=<?php echo $look; ?>&direction=2&head_direction=2&gesture=sml&action=wav&size=l&img_format=gif" class="btn btn-success btn-download" download>Baixar Avatar</a>
</div>

</body>
</html>
