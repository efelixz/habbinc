<?php
session_start();
if (!isset($_SESSION['spanel']) || $_SESSION['spanel'] != 1) {
    header("Location: /me");
    exit;
}
?>
<?php
session_start();

// Conexão com banco
$conn = new mysqli("localhost", "root", "", "teste");
if ($conn->connect_error) die("Erro de conexão: " . $conn->connect_error);

// Login simples e seguro sem PIN
if (isset($_POST['conectar'])) {
    $user = trim($_POST['usuario_salsa']);
    $pass = $_POST['senha_salsa'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $dados = $resultado->fetch_assoc();

        if (password_verify($pass, $dados['password'])) {
            $_SESSION['usuario'] = $dados['username'];
            $_SESSION['userid'] = $dados['id'];
            $_SESSION['spanel'] = $dados['spanel'];


            header("Location: /salsa-bemvindo");
            exit;
        } else {
            $_SESSION['erro'] = "Senha incorreta.";
        }
    } else {
        $_SESSION['erro'] = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - Painel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">
</head>
<body style="background-color: #1b1e21; color: white;">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-white" style="background-color: #1e262c; font-weight: bold;">
                        <i class="fa fa-sign-in-alt"></i> Entrar no Painel
                    </li>
                    <li class="list-group-item">
                        <div id="alerts">
                            <?php if (isset($_SESSION['erro'])): ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
                            <?php endif; ?>
                        </div>
                        <form method="post" action="">
                            <div class="form-group">
                                <label><i class="fa fa-user"></i> Usuário</label>
                                <input type="text" class="form-control" name="usuario_salsa" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fa fa-lock"></i> Senha</label>
                                <input type="password" class="form-control" name="senha_salsa" required>
                            </div>
                            <button type="submit" name="conectar" class="btn btn-dark w-100">
                                <i class="fa fa-unlock-alt"></i> Entrar agora
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
