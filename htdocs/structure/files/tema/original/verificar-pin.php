<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['verificando_pin']) || !isset($_SESSION['tentativa_usuario'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['pin_digitado'])) {
    $usuario_id = $_SESSION['verificando_pin'];
    $pin_digitado = $_POST['pin_digitado'];

    $sql = "SELECT pin, username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    if ($user['pin'] === $pin_digitado) {
        $_SESSION['usuario'] = $user['username'];
        unset($_SESSION['verificando_pin']);
        unset($_SESSION['tentativa_usuario']);
        header("Location: /salsa-bemvindo");
        exit;
    } else {
        $erro = "PIN incorreto.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verificação de PIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <strong>Verificação de PIN</strong>
                </div>
                <div class="card-body">
                    <?php if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                    <form method="post">
                        <div class="form-group">
                            <label>Digite seu PIN</label>
                            <input type="password" name="pin_digitado" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Verificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
