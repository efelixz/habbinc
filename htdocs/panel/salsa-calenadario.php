<?php
// Inicia sessão se não iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'teste');

$titulo = (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuário') . ": Painel de Calenadário - " . (defined('nome') ? nome : 'Meu Site');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Erro na conexão com banco de dados: " . $conn->connect_error);
}

$msg = '';

function validarDatas($inicio, $fim) {
    return strtotime($inicio) <= strtotime($fim);
}

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $color = trim($_POST['color'] ?? '#3788d8');

    if (!$title || !$start_date || !$end_date) {
        $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong> Título e datas são obrigatórios.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } elseif (!validarDatas($start_date, $end_date)) {
        $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong> Data início não pode ser maior que data fim.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else {
        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO event_calendar (title, description, start_date, end_date, color) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $title, $description, $start_date, $end_date, $color);
            if ($stmt->execute()) {
                $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Evento cadastrado com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Erro ao cadastrar evento: ' . h($stmt->error) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
            $stmt->close();
        } elseif ($action === 'edit') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $stmt = $conn->prepare("UPDATE event_calendar SET title = ?, description = ?, start_date = ?, end_date = ?, color = ? WHERE id = ?");
                $stmt->bind_param('sssssi', $title, $description, $start_date, $end_date, $color, $id);
                if ($stmt->execute()) {
                    $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Evento atualizado com sucesso!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Erro ao atualizar evento: ' . h($stmt->error) . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                }
                $stmt->close();
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ID inválido para edição.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM event_calendar WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Evento excluído com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Erro ao excluir evento: ' . h($stmt->error) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
        $stmt->close();
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ID inválido para exclusão.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

$edit_event = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT * FROM event_calendar WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $edit_event = $res->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title><?= h($titulo) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background: #f8f9fa;
        }
        header {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background-color: #ffffffcc;
            backdrop-filter: saturate(180%) blur(10px);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .container {
            max-width: 960px;
        }
        .event-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
        }
        .color-indicator {
            width: 25px;
            height: 25px;
            border-radius: 6px;
            border: 1px solid #ddd;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
        .card-description {
            font-size: 0.9rem;
            color: #555;
            min-height: 3.2rem;
        }
        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        form input[type="color"] {
            height: 42px;
            width: 60px;
            padding: 0;
            border-radius: 6px;
            border: 1px solid #ced4da;
            cursor: pointer;
        }
        @media (max-width: 576px) {
            .row-cols-1-sm {
                grid-template-columns: repeat(1, 1fr) !important;
            }
        }
    </style>
</head>
<body>

<header class="text-center">
    <h1 class="h3 fw-bold"><?= h($titulo) ?></h1>
</header>

<div class="container">
    <?= $msg ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold fs-5">
            <?= $edit_event ? '✏️ Editar Evento #' . (int)$edit_event['id'] : '➕ Cadastrar Novo Evento' ?>
        </div>
        <div class="card-body">
            <form method="POST" action="" class="row g-3 align-items-center">
                <input type="hidden" name="action" value="<?= $edit_event ? 'edit' : 'add' ?>">
                <?php if ($edit_event): ?>
                    <input type="hidden" name="id" value="<?= (int)$edit_event['id'] ?>">
                <?php endif; ?>

                <div class="col-12 col-md-8">
                    <label for="title" class="form-label">Título *</label>
                    <input type="text" id="title" name="title" maxlength="255" required class="form-control" value="<?= h($edit_event['title'] ?? '') ?>" placeholder="Digite o título do evento">
                </div>

                <div class="col-12 col-md-4 d-flex align-items-end">
                    <label for="color" class="form-label me-2 mb-0">Cor do Evento</label>
                    <input type="color" id="color" name="color" value="<?= h($edit_event['color'] ?? '#3788d8') ?>" title="Escolha uma cor">
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea id="description" name="description" rows="3" class="form-control" placeholder="Descrição opcional"><?= h($edit_event['description'] ?? '') ?></textarea>
                </div>

                <div class="col-6 col-md-3">
                    <label for="start_date" class="form-label">Data Início *</label>
                    <input type="date" id="start_date" name="start_date" required class="form-control" value="<?= h($edit_event['start_date'] ?? '') ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label for="end_date" class="form-label">Data Fim *</label>
                    <input type="date" id="end_date" name="end_date" required class="form-control" value="<?= h($edit_event['end_date'] ?? '') ?>">
                </div>

                <div class="col-12 d-flex justify-content-start align-items-center gap-2">
                    <button type="submit" class="btn btn-<?= $edit_event ? 'warning' : 'success' ?> btn-lg btn-icon">
                        <?= $edit_event ? '<i class="bi bi-check-lg"></i> Salvar Alterações' : '<i class="bi bi-plus-lg"></i> Cadastrar Evento' ?>
                    </button>
                    <?php if ($edit_event): ?>
                        <a href="salsa-calendario.php" class="btn btn-secondary btn-lg btn-icon">
                            <i class="bi bi-x-lg"></i> Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <h2 class="mb-3 fw-bold">Eventos Cadastrados</h2>

    <?php
    $result = $conn->query("SELECT * FROM event_calendar ORDER BY start_date DESC");
    if ($result && $result->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($ev = $result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card event-card shadow-sm">
                        <div class="card-header d-flex align-items-center" style="background-color: <?= h($ev['color']) ?>; color: #fff;">
                            <span class="color-indicator" style="background-color: <?= h($ev['color']) ?>"></span>
                            <h5 class="mb-0 flex-grow-1"><?= h($ev['title']) ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-description"><?= nl2br(h($ev['description'] ?: '— Sem descrição —')) ?></p>
                            <p class="mb-1"><strong>Início:</strong> <?= h($ev['start_date']) ?></p>
                            <p><strong>Fim:</strong> <?= h($ev['end_date']) ?></p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="?edit=<?= (int)$ev['id'] ?>" class="btn btn-sm btn-outline-warning btn-icon" title="Editar">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <a href="?delete=<?= (int)$ev['id'] ?>" class="btn btn-sm btn-outline-danger btn-icon" title="Excluir" onclick="return confirm('Confirma excluir este evento?');">
                                    <i class="bi bi-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center">Nenhum evento cadastrado.</div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto fade out alerts after 5s
    window.addEventListener('DOMContentLoaded', () => {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>

</body>
</html>
