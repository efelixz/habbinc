<?php
include 'config.php';
include 'header.php';

// Verificar se é staff/admin (exemplo: rank 5 ou mais)
if ($_SESSION['rank'] < 5) {
    echo "<div class='alert alert-danger text-center mt-4'>Você não tem permissão para acessar esta página.</div>";
    exit;
}

// Quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $data = $_POST['data_evento'];

    $sql = "INSERT INTO calendario_eventos (titulo, descricao, data_evento) VALUES ('$titulo', '$descricao', '$data')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center mt-3'>✅ Evento adicionado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>❌ Erro ao adicionar: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="container mt-5">
    <h4 class="mb-4">📅 Adicionar Evento ao Calendário</h4>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Título do Evento</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4" placeholder="Descreva o evento..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Data do Evento</label>
            <input type="date" name="data_evento" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Evento</button>
        <a href="promocoes-atividades-calendario.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
