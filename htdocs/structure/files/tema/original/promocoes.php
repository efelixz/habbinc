<?php
$titulo = $_SESSION['usuario'] . ": Promoções, Atividades e Calendário - " . nome;
include 'header.php';
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

<div class="container py-4">

  <ul class="nav nav-tabs custom-tabs mb-4" id="tabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="promocoes-tab" data-bs-toggle="tab" data-bs-target="#promocoes" type="button" role="tab" aria-controls="promocoes" aria-selected="true">
        <i class="fas fa-gift me-2"></i> Promoções
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false">
        <i class="fas fa-trophy me-2"></i> Atividades
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="calendario-tab" data-bs-toggle="tab" data-bs-target="#calendario" type="button" role="tab" aria-controls="calendario" aria-selected="false">
        <i class="fas fa-calendar-alt me-2"></i> Calendário
      </button>
    </li>
  </ul>

  <div class="tab-content" id="tabsContent">
    <!-- Promoções -->
    <div class="tab-pane fade show active" id="promocoes" role="tabpanel" aria-labelledby="promocoes-tab">
      <div class="row gx-4 gy-4">
        <?php
        $sql = "SELECT * FROM cms_news WHERE noticia_ativa = 1 ORDER BY id DESC LIMIT 20";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="promo-card shadow-sm" style="background-image: url('<?php echo htmlspecialchars($row['image']); ?>');">
              <div class="promo-overlay p-3">
                <h5 class="promo-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <p class="promo-desc"><?php echo htmlspecialchars($row['shortstory']); ?></p>
                <a href="<?php echo url ?>/noticia?=<?php echo (int)$row['id']; ?>" class="btn btn-sm btn-primary">Ver mais</a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- Atividades -->
    <div class="tab-pane fade" id="atividades" role="tabpanel" aria-labelledby="atividades-tab">
      <div class="alert alert-info text-center py-5">
        <h4>Em breve!</h4>
        <p>Atividades dinâmicas e eventos interativos estarão disponíveis aqui. Fique ligado!</p>
      </div>
    </div>

    <!-- Calendário -->
    <div class="tab-pane fade" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
      <div id="calendar"></div>
    </div>
  </div>

  <!-- Seções explicativas -->
  <div class="row mt-5 gx-4 gy-4">
    <div class="col-md-4">
      <div class="p-4 bg-white rounded shadow-sm border">
        <h5 class="mb-3 text-primary">Sobre Promoções Ativas</h5>
        <p>Confira aqui todas as promoções atuais criadas pela equipe. Participe para ganhar prêmios exclusivos e aproveite ofertas especiais que são preparadas especialmente para você!</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="p-4 bg-white rounded shadow-sm border">
        <h5 class="mb-3 text-success">Sobre Atividades</h5>
        <p>Em breve, você poderá participar de diversas atividades interativas, jogos e desafios. Prepare-se para se divertir e conquistar recompensas únicas com a nossa equipe!</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="p-4 bg-white rounded shadow-sm border">
        <h5 class="mb-3 text-warning">Sobre o Calendário de Eventos</h5>
        <p>Fique por dentro de todos os eventos futuros do hotel. Nosso calendário mostra datas importantes, competições e encontros para você não perder nada!</p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: 550,
        events: [
          <?php
          $res = mysqli_query($conn, "SELECT * FROM event_calendar");
          while ($ev = mysqli_fetch_assoc($res)) {
            echo "{
              title: '" . addslashes($ev['title']) . "',
              start: '" . $ev['start_date'] . "',
              end: '" . date('Y-m-d', strtotime($ev['end_date'] . ' +1 day')) . "',
              description: '" . addslashes($ev['description']) . "',
              color: '" . $ev['color'] . "'
            },";
          }
          ?>
        ],
        eventClick: function(info) {
          alert(info.event.title + "\n\n" + info.event.extendedProps.description);
        }
      });
      calendar.render();
    }
  });
</script>

<style>
  /* Abas personalizadas */
  .custom-tabs .nav-link {
    font-weight: 600;
    color: #555;
    border: none;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
  }

  .custom-tabs .nav-link:hover {
    color: #0d6efd;
  }

  .custom-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 3px solid #0d6efd;
    background-color: transparent;
  }

  .promo-card {
    height: 180px;
    background-size: cover;
    background-position: center;
    border-radius: 12px;
    display: flex;
    align-items: end;
    transition: 0.3s;
  }

  .promo-card:hover {
    transform: scale(1.03);
  }

  .promo-overlay {
    background: rgba(255, 255, 255, 0.95);
    width: 100%;
    border-radius: 0 0 12px 12px;
  }

  .promo-title, .promo-desc {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  #calendar {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    margin-top: 20px;
  }
</style>
