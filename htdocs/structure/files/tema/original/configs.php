<?php
$titulo = $_SESSION['usuario'] . ": Configurações - " . nome;
include 'header.php';

// Pegando dados do usuário logado
$usuario = $_SESSION['usuario'];

$sql3 = "SELECT * FROM users WHERE username='" . $usuario . "'";
$query1 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
while ($row2 = $query1->fetch_assoc()) {
    $missao = $row2['motto'];
    $email = $row2['mail'];
    $dc = $row2['discord'];
    $capa = $row2['capa'];
}
?>

<div class="container py-4" ng-controller="configController">

    <h2 class="mb-4 font-weight-bold">Configurações</h2>

    <!-- Abas no topo -->
    <ul class="nav nav-tabs" id="configTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="missao-tab" data-toggle="tab" href="#missao" role="tab" aria-controls="missao" aria-selected="false">Configurações Gerais</a>
        </li>
         <li class="nav-item">
            <a class="nav-link active" id="senha-tab" data-toggle="tab" href="#senha" role="tab" aria-controls="senha" aria-selected="true">Alterar a senha</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="conixao-tab" data-toggle="tab" href="#conixao" role="tab" aria-controls="conixao" aria-selected="false">Conexão</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pin-tab" data-toggle="tab" href="#pin" role="tab" aria-controls="pin" aria-selected="false">PIN</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="configTabsContent">

        <!-- Aba Alterar a senha -->
        <div class="tab-pane fade show active" id="senha" role="tabpanel" aria-labelledby="senha-tab">

            <?php
            if (isset($_POST['alterar_senha'])) {
                $senha_atual = $_POST['senha_atual'] ?? '';
                $nova_senha = $_POST['nova_senha'] ?? '';
                $confirma_senha = $_POST['confirma_senha'] ?? '';

                if (empty($senha_atual) || empty($nova_senha) || empty($confirma_senha)) {
                    echo '<div class="alert alert-danger">Preencha todos os campos.</div>';
                } elseif ($nova_senha !== $confirma_senha) {
                    echo '<div class="alert alert-danger">As senhas não coincidem.</div>';
                } elseif (strlen($nova_senha) < 6) {
                    echo '<div class="alert alert-danger">A senha nova deve ter pelo menos 6 caracteres.</div>';
                } else {
                    // Buscar a senha atual (hash) do banco para comparar
                    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
                    $stmt->bind_param("s", $usuario);
                    $stmt->execute();
                    $stmt->bind_result($senha_hash_banco);
                    $stmt->fetch();
                    $stmt->close();

                    if (!$senha_hash_banco || !password_verify($senha_atual, $senha_hash_banco)) {
                        echo '<div class="alert alert-danger">Senha atual incorreta.</div>';
                    } else {
                        // Atualiza com o hash da nova senha
                        $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                        $stmt->bind_param("ss", $novo_hash, $usuario);
                        if ($stmt->execute()) {
                            echo '<div class="alert alert-success">Senha atualizada com sucesso!</div>';
                        } else {
                            echo '<div class="alert alert-danger">Erro ao atualizar a senha.</div>';
                        }
                        $stmt->close();
                    }
                }
            }
            ?>

            <form method="post">
                <div class="form-group">
                    <label><b>Senha atual:</b></label>
                    <input type="password" name="senha_atual" class="form-control" required placeholder="Digite sua senha atual">
                </div>

                <div class="form-group">
                    <label><b>Nova senha:</b></label>
                    <input type="password" name="nova_senha" class="form-control" required minlength="6" placeholder="Digite sua nova senha">
                </div>

                <div class="form-group">
                    <label><b>Confirme a nova senha:</b></label>
                    <input type="password" name="confirma_senha" class="form-control" required minlength="6" placeholder="Confirme sua nova senha">
                </div>

                <button type="submit" name="alterar_senha" class="btn btn-primary float-right">Alterar Senha</button>
            </form>

        </div>

        <!-- Aba Configurações Gerais (Missão, email, discord, capa) -->
        <div class="tab-pane fade" id="missao" role="tabpanel" aria-labelledby="missao-tab">

            <div id="alerts">
                <?php 
                SalsaConta::configuracoes($conn);
                if (isset($_SESSION['erro'])) {
                    echo '<div class="alert alert-primary">' . $_SESSION['erro'] . '</div>';
                    unset($_SESSION['erro']);
                }
                ?>
            </div>

            <form method="post" class="ng-pristine ng-valid">
                <div class="form-group">
                    <label><b>Missão:</b></label>
                    <input type="text" class="form-control" name="missao" value="<?php echo htmlspecialchars($missao); ?>">
                </div>

                <div class="form-group">
                    <label><b>E-mail:</b></label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <label><b>Seu Discord:</b></label>
                    <input type="text" class="form-control" name="discord" value="<?php echo htmlspecialchars($dc); ?>">
                </div>

                <div class="form-group">
                    <label><b>Sua capa de perfil (PNG, GIF):</b></label>
                    <input type="text" class="form-control" name="capa" value="<?php echo htmlspecialchars($capa); ?>">
                </div>

                <input type="hidden" name="confirmacao" value="<?php echo htmlspecialchars($email); ?>">

                <button type="submit" name="enviar" class="btn btn-success float-right">Salvar</button>
            </form>
        </div>

        <!-- Aba Conixão -->
        <div class="tab-pane fade" id="conixao" role="tabpanel" aria-labelledby="conixao-tab">
            <div class="alert alert-info">
                Aqui você pode gerenciar suas conexões e integrações.
            </div>
        </div>

        <!-- Aba PIN -->
        <div class="tab-pane fade" id="pin" role="tabpanel" aria-labelledby="pin-tab">
            <div class="alert alert-info">
                Configure seu PIN de segurança. Ele será solicitado em ações importantes.
            </div>

            <?php
            if (isset($_POST['salvar_pin'])) {
                $novo_pin = trim($_POST['novo_pin']);

                if (!preg_match('/^\d{4,6}$/', $novo_pin)) {
                    echo '<div class="alert alert-danger">O PIN deve conter entre 4 e 6 dígitos numéricos.</div>';
                } else {
                    $stmt = $conn->prepare("UPDATE users SET pin = ? WHERE username = ?");
                    $stmt->bind_param("ss", $novo_pin, $usuario);
                    if ($stmt->execute()) {
                        echo '<div class="alert alert-success">PIN atualizado com sucesso.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Erro ao atualizar o PIN.</div>';
                    }
                    $stmt->close();
                }
            }

            $res = mysqli_query($conn, "SELECT pin FROM users WHERE username = '" . $usuario . "'");
            $dados = mysqli_fetch_assoc($res);
            $pin_mascarado = $dados['pin'] ? str_repeat("●", strlen($dados['pin'])) : "Nenhum PIN definido.";
            ?>

            <form method="post">
                <div class="form-group">
                    <label><b>PIN atual:</b></label>
                    <input type="text" class="form-control" value="<?php echo $pin_mascarado; ?>" disabled>
                </div>

                <div class="form-group">
                    <label><b>Novo PIN:</b></label>
                    <input type="password" name="novo_pin" class="form-control" maxlength="6" placeholder="Digite um novo PIN (4-6 números)" required>
                </div>

                <button type="submit" name="salvar_pin" class="btn btn-primary float-right">Salvar PIN</button>
            </form>
        </div>

    </div>
</div>

<style>
    .salsa {
        height: 300px;
    }
</style>

<div class="salsa"></div>

<footer class="bg-dark text-center text-secondary py-3 mt-5" style="font-size: 0.9rem;">
    <div class="container">
        ©  <?php echo ano ?> Rede <?php echo nome ?> Corporation Ltd. Todos os direitos reservados.
        <br>

    </div>
</footer>

<script>
    $(function () {
        $('#configTabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
