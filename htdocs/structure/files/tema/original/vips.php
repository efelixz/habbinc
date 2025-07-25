<?php
$titulo = usuario . ": Usuários VIP - " . nome;
include 'header.php';

$avatarimage = "https://habbo.city/habbo-imaging/avatarimage?figure=";
?>

<div class="container" style="max-width: 960px; margin: 30px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e262c;">

  <!-- Abas -->
  <div class="tabs-container">
    <button class="tab-btn active-tab" data-tab="supervip">
      <img src="https://i.imgur.com/2yaf2wb.png" alt="Super VIP" class="tab-icon">
      Super VIPs
    </button>
    <button class="tab-btn" data-tab="vip">
      <img src="https://i.imgur.com/1nW0fzo.png" alt="VIP" class="tab-icon">
      VIPs
    </button>
  </div>

  <!-- Conteúdo Super VIP -->
  <div id="supervip" class="tab-content" style="display: block;">
    <h5>Super VIPs - Alta sociedade do <?php echo nome ?> Hotel.</h5>
    <div class="cards-row">
      <?php
      $sqlSuperVip = "SELECT * FROM users WHERE rank=3";
      $resSuperVip = mysqli_query($conn, $sqlSuperVip) or die(mysqli_error($conn));
      while ($row = $resSuperVip->fetch_assoc()) {
      ?>
        <div class="card">
          <div class="user-profile-image" style="background-image: url('<?php echo $avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml');"></div>
          <div class="card-info">
            <div class="card-header">
              <a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a>
              <?php if ($row['online'] == 1): ?>
                <span class="status online">Online</span>
              <?php endif; ?>
            </div>
            <div><b>Missão:</b> <?php echo fs($row['motto']) ?></div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Conteúdo VIP -->
  <div id="vip" class="tab-content" style="display: none;">
    <h5>VIPs - Alta sociedade do <?php echo nome ?> Hotel.</h5>
    <div class="cards-row">
      <?php
      $sqlVip = "SELECT * FROM users WHERE rank=1";
      $resVip = mysqli_query($conn, $sqlVip) or die(mysqli_error($conn));
      while ($row = $resVip->fetch_assoc()) {
      ?>
        <div class="card">
          <div class="user-profile-image" style="background-image: url('<?php echo $avatarimage . $row['look'] ?>&size=m&head_direction=2&gesture=sml');"></div>
          <div class="card-info">
            <div class="card-header">
              <a href="/perfil?=<?php echo $row['username'] ?>"><?php echo $row['username'] ?></a>
              <?php if ($row['online'] == 1): ?>
                <span class="status online">Online</span>
              <?php endif; ?>
            </div>
            <div><b>Missão:</b> <?php echo fs($row['motto']) ?></div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

</div>

<script>
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active-tab');
      });
      btn.classList.add('active-tab');

      const tabId = btn.getAttribute('data-tab');
      document.querySelectorAll('.tab-content').forEach(c => {
        c.style.display = (c.id === tabId) ? 'block' : 'none';
      });
    });
  });
</script>

<style>
  .tabs-container {
    display: flex;
    border-bottom: 2px solid #ccc;
    margin-bottom: 25px;
    gap: 10px;
  }

  .tab-btn {
    flex: 1;
    padding: 14px 0;
    font-weight: 700;
    font-size: 1.15rem;
    border: none;
    background: none;
    cursor: pointer;
    color: #555;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
  }

  .tab-btn .tab-icon {
    width: 22px;
    height: 22px;
  }

  .tab-btn.active-tab {
    border-bottom-color: #007bff;
    color: #007bff;
    font-size: 1.2rem;
  }

  .tab-btn:hover:not(.active-tab) {
    color: #007bff;
  }

  h5 {
    font-weight: 600;
    color: #222;
    margin-bottom: 15px;
  }

  .cards-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .card {
    flex: 1 1 calc(50% - 20px);
    display: flex;
    align-items: center;
    background: #fdfdfd;
    padding: 14px 16px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.1);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    cursor: pointer;
  }

  .card:hover {
    box-shadow: 0 8px 20px rgb(0 0 0 / 0.18);
    transform: translateY(-6px);
  }

  .user-profile-image {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    flex-shrink: 0;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
  }

  .card:hover .user-profile-image {
    transform: scale(1.1);
  }

  .card-info {
    margin-left: 18px;
    font-size: 15px;
    color: #333;
    flex-grow: 1;
  }

  .card-header {
    font-weight: 700;
    font-size: 17px;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-header a {
    color: #222;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .card-header a:hover {
    color: #007bff;
  }

  .status.online {
    background-color: #28a745;
    color: #fff;
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 15px;
  }

  b {
    color: #007bff;
  }

  /* Responsivo */
  @media (max-width: 700px) {
    .card {
      flex: 1 1 100%;
    }
  }
</style>
