<?php
$titulo = "".usuario.":  Principal - ".nome."";
include 'header.php' ?>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-8" style="margin-bottom: 20px">

            <div class="alert alert-info">
                <img src="https://i.imgur.com/SQDBx0Y.png"> <strong>Entre no Discord do Habbinc</strong> para ficar por dentro de tudo. <a href="https://discord.gg/UY85KfcKFp"><u>Entrar agora</u></a>!
            </div>

            <div class="card" style="display: block; overflow: hidden;">
                <div class="card-body" id="me-top-profile">
                    <div class="row">
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div onclick="window.open('/react', '_blank');" class="panel-footer client-btn">Entrar no Hotel (Nitro)</div>
                <div onclick="window.open('/react', '_blank');" class="panel-footer client-btn" style="width:100%">Entrar com Flash UI <img src="https://i.imgur.com/lZWES30.png"></div>
            </div>

           <?php
SalsaConta::publicar($conn);
SalsaConta::curtir($conn);
?>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div id="feedController" ng-controller="feedController" class="ng-scope">
    <ul class="list-group" style="margin-top: 20px">
        <li class="list-group-item feed-item clearfix">
            <form method="POST" id="postForm" onsubmit="return postSubmit(event)">
                <div class="feed-item-image" style="background-image: url(<?php echo avatarimage . $roupa ?>&size=m&headonly=1&head_direction=2&gesture=sml)"></div>
                <div class="feed-item-body">
                    <textarea name="postagem" id="postagem" required class="form-control" rows="1" placeholder="No que você está pensando?" 
                        oninput="autoResize(this)"></textarea>
                    <button name="postar" type="submit" class="btn btn-primary float-right mt-2" id="btnPostar" disabled>Publicar</button>
                </div>
            </form>
        </li>
    </ul>

<script>
    // Habilita o botão publicar só se tiver texto
    const postagem = document.getElementById('postagem');
    const btnPostar = document.getElementById('btnPostar');
    postagem.addEventListener('input', () => {
        btnPostar.disabled = postagem.value.trim().length === 0;
    });

    // Auto ajusta altura do textarea conforme digita
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    // Pode expandir aqui para postar via AJAX no futuro
    function postSubmit(event) {
        // Aqui poderia impedir o submit padrão e enviar via AJAX futuramente
        // Por enquanto, só permite o submit normal
        return true;
    }
</script>


                  <?php
$sql = "SELECT * FROM salsa_posts ORDER BY id DESC LIMIT 20";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
while($row = $query->fetch_assoc()) {
    $nova = "SELECT * FROM users WHERE username='".$row['usuario']."'";
    $qrm = mysqli_query($conn, $nova) or die(mysqli_error($conn));
    while($row77 = $qrm->fetch_assoc()) {
?>
<li class="list-group-item feed-item animated fadeInDown d-flex" style="gap: 15px; padding: 15px; border-radius: 8px; box-shadow: 0 2px 6px rgb(0 0 0 / 0.1); transition: background-color 0.3s ease;">
    <div class="feed-item-image" style="
        background-image: url('<?php echo avatarimage . $row77['look'] ?>&size=m&headonly=0&head_direction=2&gesture=sml');
        width: 60px; height: 60px; border-radius: 50%; background-size: cover; background-position: center;
        flex-shrink: 0;
    " loading="lazy" title="<?php echo htmlspecialchars($row['usuario'], ENT_QUOTES); ?>"></div>

    <div class="feed-item-body" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div class="feed-item-header" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; color: #666;">
            <span><?php echo date('d/m/Y \à\s H:i:s', $row['data']) ?></span>
            <?php if ($row['staff'] == 1): ?>
                <span style="background:#ff4757; color:#fff; font-weight: 700; font-size: 0.8rem; padding: 3px 7px; border-radius: 12px; display: inline-block;">
                    STAFF <i class="fas fa-exclamation-triangle" style="margin-left: 5px;"></i>
                </span>
            <?php endif; ?>
        </div>

        <div class="feed-item-title" style="font-weight: 600; font-size: 1.1rem; margin: 5px 0;">
            <a href="perfil?=<?php echo $row['usuario'] ?>" style="color: #2f3542; text-decoration: none; transition: color 0.2s;">
                <?php echo htmlspecialchars($row['usuario'], ENT_QUOTES) ?>
            </a>
        </div>

        <div class="feed-item-content" style="font-size: 1rem; color: #444;">
            <p style="margin: 0;"><?php echo fs($row['postagem']) ?></p>
        </div>

        <div class="feed-item-actions" style="margin-top: 10px; display: flex; gap: 20px; font-size: 0.9rem; color: #57606f;">
            <a href="javascript:void(0);" class="action-btn" title="Curtir" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                <i class="far fa-thumbs-up"></i> <span>Curtidas</span>
            </a>
            <a href="/post/<?php echo $row['id'] ?>" class="action-btn" title="Comentários" style="display: flex; align-items: center; gap: 5px; color: #3742fa;">
                <i class="far fa-comments"></i> <span>Comentários</span>
            </a>
            <a href="javascript:void(0);" class="action-btn" title="Retweetar" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                <i class="fas fa-retweet"></i>
            </a>
        </div>
    </div>
</li>

<style>
    .feed-item:hover {
        background-color: #f1f2f6;
    }
    .action-btn:hover {
        color: #2ed573;
    }
    .action-btn i {
        transition: transform 0.3s ease;
    }
    .action-btn:hover i {
        transform: scale(1.2) rotate(15deg);
    }
</style>

<script>
    // Exemplo simples de clique curtida (futuro pode implementar ajax)
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            if (btn.title === 'Curtir') {
                e.preventDefault();
                alert('Você curtiu o post!');
            }
            if (btn.title === 'Retweetar') {
                e.preventDefault();
                alert('Retweet funcionalidade em breve!');
            }
        });
    });
</script>

<?php } } ?>

                        <li class="list-group-item animated fadeInDown updateFeedBtn ng-hide" ng-click="loadNewPosts()" ng-show="newPostsCount &gt; 0 &amp;&amp; loading === false">
                            Carregar novos posts
                        </li>
                     
                        <div id="feedScrollspy" class="d-none d-lg-block" style="height: 1px"></div>
                        <li class="list-group-item updateFeedBtn d-block d-lg-none" ng-click="loadOldPosts()">
                            Carregar mais posts
                        </li>
                    </ul>
                    <div class="modal fade" id="sharePostModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Retweetar Publicação</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form ng-submit="sharePostAction()" class="ng-pristine ng-valid">
                                    <div class="modal-body">
                                        <input type="hidden" id="sharePostId" value="">
                                        <textarea class="form-control ng-pristine ng-untouched ng-valid ng-empty" style="margin-bottom: 10px" id="sharingContent" rows="1" ng-model="sharePost.message" ng-disabled="postingStatus === true"></textarea>

                                        <div class="list-group" style="padding-left: 10px">
                                            <div class="list-group-item feed-item" style="border-radius: 4px;">
                                                <div class="feed-item-image" style="background-image: url(<?php echo url ?>/avatar//size=m&amp;headonly=1&amp;head_direction=3&amp;gesture=sml)"></div>
                                                <div class="feed-item-title">
                                                    <a href="<?php echo url ?>/perfil/" class="ng-binding"></a>
                                                </div>
                                                <div class="feed-item-content">
                                                    <div ng-bind-html="sharePost.content | trustAsHtml" class="ng-binding"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary" ng-disabled="sharePost.message.length &lt; 1 || sharePost.message == null || postingStatus === true" disabled="disabled">Retweetar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="max-width: 300px;">
                <div class="list-group" style="margin-bottom: 20px">
                    <div class="list-group-item" style="padding: 0;overflow: hidden">
                        <div id="articlesSlide" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                  <?php
                            $sql = "SELECT * FROM cms_news order by id DESC LIMIT 1";
      $qaqa = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      while($row111 = $qaqa->fetch_assoc())
      {
        ?>
                                <a href="<?php echo url ?>/noticia?=<?php echo $row111['id'] ?>" class="carousel-item active" style="background: url(<?php echo $row111['image'] ?>) center right no-repeat;height:186px;padding: 20px 15px;overflow:hidden">
                                    <span class="carousel-title"><?php echo $row111['title'] ?></span>
                                    <br>
                                    <span class="carousel-desc"><?php echo $row111['shortstory'] ?></span>
                                </a>

                            <?php } ?>


                                
                                
                                
                               
                            </div>
                            
                           
                        </div>
                    </div>
                       <?php
// Função para escapar saída HTML (protege contra XSS)
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Busca últimas 6 notícias
$a = "SELECT * FROM cms_news ORDER BY id DESC LIMIT 6";
$gg = mysqli_query($conn, $a) or die(mysqli_error($conn));
$noticiasEncontradas = false;
while ($noticia = $gg->fetch_assoc()) {
    $noticiasEncontradas = true;
    $urlNoticia = e(url) . "/noticia?=" . urlencode($noticia['id']);
    $tituloNoticia = e($noticia['title']);
?>
    <div class="list-group-item d-flex justify-content-between align-items-center" style="cursor:pointer;">
        <!-- Link do título ocupa todo espaço possível -->
        <a href="<?php echo $urlNoticia ?>" title="<?php echo $tituloNoticia ?>" style="flex-grow:1; text-decoration:none; color: inherit; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?php echo $tituloNoticia ?>
        </a>
        <!-- Ícone clicável ao lado direito -->
        <span
            style="color:#007bff; cursor:pointer; font-weight:bold; margin-left: 10px; user-select:none;"
            title="Clique para ação extra"
            onclick="event.stopPropagation(); event.preventDefault(); alert('Ação extra para: <?php echo addslashes($tituloNoticia) ?>');"
        >
            ›
        </span>
    </div>
<?php }
if (!$noticiasEncontradas) {
    echo '<div class="list-group-item text-center text-muted">Nenhuma notícia encontrada.</div>';
}
?>
</div>

<div class="col-md-4" style="max-width: 300px">
    <div class="card" style="margin-bottom: 10px">
        <div class="card-body">
            <div class="input-group">
                <input
                    type="text"
                    placeholder="Pesquisar Usuário"
                    class="form-control"
                    id="user-search"
                    autocomplete="off"
                    aria-label="Pesquisar Usuário"
                    title="Digite o nome do usuário e pressione Enter ou clique no ícone"
                />
                <div class="input-group-prepend">
                    <button
                        class="btn btn-primary btn-sm"
                        style="border-top-right-radius:4px; border-bottom-right-radius:4px"
                        id="btn-search-user"
                        aria-label="Botão de pesquisa"
                    >
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <script>
                function searchUser() {
                    const input = document.getElementById('user-search');
                    const val = input.value.trim();
                    if(val !== "") {
                        const encoded = encodeURIComponent(val);
                        location.href = "/perfil/" + encoded;
                    } else {
                        input.focus();
                    }
                }
                document.getElementById('btn-search-user').addEventListener('click', searchUser);
                document.getElementById('user-search').addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchUser();
                    }
                });
            </script>
        </div>
    </div>

    <div ng-controller="eventsController" class="ng-scope">
        <h5 style="color:#1e262c;font-weight: bold;margin-top:10px; margin-bottom: 0px">Próximas Atividades</h5>
        <div style="color: #8f9396;font-weight: normal; font-size: 15px; margin-bottom: 10px">Anote em sua agenda e não perca!</div>

        <div class="list-group" style="border-radius: 4px; overflow: hidden;">
            <div class="list-group-item ng-hide" ng-show="events.length == 0 && !loadingEvents" style="text-align: center">
                Nenhuma atividade agendada no momento.
            </div>
            <div class="list-group-item ng-hide" ng-show="events.length == 0 && loadingEvents" style="text-align: center">
                <i class="fas fa-spinner fa-spin" style="font-size: 30px"></i><br>Carregando atividades...
            </div>
        </div>
    </div>

    <h5 style="color:#1e262c;font-weight: bold;margin-top:10px; margin-bottom: 0px">Top 5 eventos</h5>
<div style="color: #8f9396;font-weight: normal; font-size: 15px; margin-bottom: 10px">As celebridades online agora!</div>
<div id="ranking" ng-controller="rankingController" class="list-group ng-scope" style="margin-top: 10px; margin-bottom: 20px; border-radius: 4px; overflow:hidden;">

    <div class="list-group-item" style="padding: 0; border: 0px">
        <div class="btn-group" role="group" style="width: 100%"></div>

        <?php
        $aBC = "SELECT * FROM users ORDER BY pontos_evento DESC LIMIT 6";
        $QQ = mysqli_query($conn, $aBC) or die(mysqli_error($conn));
        $temRanking = false;
        $pos = 1;
        while ($MOEDAS = $QQ->fetch_assoc()) {
            $temRanking = true;
            $perfilUrl = "/perfil?=" . urlencode($MOEDAS['username']);
            $avatarImg = "//habbo.com/habbo-imaging/avatarimage?figure=" . urlencode($MOEDAS['look']) . "&size=m&direction=2&gesture=sml&head_direction=2";
            $username = e($MOEDAS['username']);
            $pontos = intval($MOEDAS['pontos_evento']);

            // Define medalha para os top 3
            $medalha = '';
            if ($pos == 1) {
                $medalha = '<span title="1º Lugar 🥇" style="color: gold; font-size: 1.3em; margin-right: 5px;">🏅</span>';
            } elseif ($pos == 2) {
                $medalha = '<span title="2º Lugar 🥈" style="color: silver; font-size: 1.3em; margin-right: 5px;">🥈</span>';
            } elseif ($pos == 3) {
                $medalha = '<span title="3º Lugar 🥉" style="color: #cd7f32; font-size: 1.3em; margin-right: 5px;">🥉</span>';
            }
        ?>
            <a class="list-group-item ranking-item" style="text-decoration: none; display: flex; align-items: center; padding: 10px; transition: background-color 0.3s ease;" href="<?php echo $perfilUrl ?>" title="Perfil de <?php echo $username ?>" tabindex="0">
                <div style="position: relative; flex-shrink: 0;">
                    <div style="background-image: url('<?php echo $avatarImg ?>'); background-position: -8px -17px; width:50px; height:50px; border-radius: 50%;" loading="lazy" alt="Avatar de <?php echo $username ?>"></div>
                    <?php echo $medalha ?>
                </div>
                <div style="margin-left: 12px; flex-grow: 1;">
                    <b style="font-size: 1.05em; color: #1e262c;"><?php echo $username ?></b><br>
                </div>
                <div style="flex-shrink: 0; font-size: 0.95em; color: #8f9396; display: flex; align-items: center;" title="Pontos: <?php echo $pontos ?>">
                    <img style="margin-top:-3px; margin-right: 4px;" src="https://i.imgur.com/2gfYU3q.png" alt="Moedas" width="18" height="18" />
                    <?php echo $pontos ?>
                </div>
            </a>
        <?php
            $pos++;
        }
        if (!$temRanking) {
            echo '<div class="list-group-item text-center text-muted">Nenhum evento encontrado.</div>';
        }
        ?>

<style>
    .ranking-item:hover,
    .ranking-item:focus {
        background-color: #f0f4f8;
        outline: none;
        cursor: pointer;
    }
</style>

        </div>
    </div>

    <br>

    <div class="panel panel-primary">
    <div class="panel-heading">
        <div class="list-group-item list-header" style="display: flex; align-items: center; justify-content: space-between;">
            <span>Referidos</span>
            <i class="fas fa-users" title="Referidos" aria-hidden="true" style="color:#1e262c;"></i>
        </div>
    </div>

    <div class="list-group-item config-controller open" data-target="#config">
        <p>Chame novas pessoas para o hotel usando o seu link de referência e ganhe de 1 a 2 tickets a cada novo cadastro.</p>
        <div class="form-group" style="display: flex; gap: 8px; align-items: center;">
            <form class="ng-pristine ng-valid" style="flex-grow: 1; margin-bottom: 0;">
                <small>Link de referência:</small>
                <input 
                    type="text" 
                    onclick="this.select();" 
                    class="form-control" 
                    id="refLinkInput"
                    value="<?php echo e(url) ?>/convite?=<?php echo e(usuario) ?>" 
                    readonly="readonly" 
                    aria-label="Link de referência do usuário" 
                    style="user-select: all;"
                />
            </form>
            <button 
                type="button" 
                class="btn btn-outline-primary btn-sm" 
                onclick="copyRefLink()" 
                aria-label="Copiar link de referência"
                title="Copiar link"
                style="white-space: nowrap;"
            >
                <i class="fas fa-copy"></i> Copiar
            </button>
        </div>
    </div>
</div>

<script>
    function copyRefLink() {
        const input = document.getElementById('refLinkInput');
        input.select();
        input.setSelectionRange(0, 99999); // Para dispositivos móveis

        try {
            const successful = document.execCommand('copy');
            if(successful) {
                alert('Link de referência copiado!');
            } else {
                alert('Não foi possível copiar o link. Por favor, copie manualmente.');
            }
        } catch (err) {
            alert('Erro ao copiar o link.');
        }
        // Remove seleção após copiar
        window.getSelection().removeAllRanges();
    }
</script>




    </div>
</div>
<script>

        $("#ranking button").on("click", function() {
            $("#ranking button.active").removeClass("active");
            $(this).addClass("active");
        });

        $(".emoji-list, .emoji-list-long").hover(function() {
            $(this).removeClass("closed");
        }, function() {
            $(this).addClass("closed");
        });

        $(".emoji-list img").on("click", function() {
            var $scope = angular.element($('div[ng-controller="feedController"]')).scope();

            if ($(focusedInput).attr("ng-model").includes("[")) {
                var variableName = $(focusedInput).attr("ng-model").substr(0, $(focusedInput).attr("ng-model").indexOf('['));
                $scope[variableName][$(focusedInput).attr("myindex")] = $scope[variableName][$(focusedInput).attr("myindex")] + " " + $(this).attr("title");
            } else
                $scope[$(focusedInput).attr("ng-model")] = $scope[$(focusedInput).attr("ng-model")] + " " + $(this).attr("title");

            $scope.$digest();
            $(focusedInput).focus();
        });

        $(".emoji-list-long img").on("click", function() {
            $(focusedInput).val($(focusedInput).val() +" "+ $(this).attr("title"));
            $(focusedInput).trigger('input');
            $(focusedInput).focus();
        });

        $(document).on("click", ".feed-poll-option-radio", function() {
            $(".feed-poll-option-radio").removeClass("selected");
            $(this).addClass("selected");
            $(this).find("input").prop("checked", true);
        });

        var focusedInput = null;

        $(document).on("focus", "input[type='text'], textarea", function() {
            focusedInput = this;
        });
    
        app.controller('eventsController', function ($scope, $http) {
            $scope.events = [];
            $scope.loadingEvents = true;

            function getBrasiliaTime() {
                const now = new Date();
                try {
                    return new Date(now.toLocaleString('en-US', { timeZone: 'America/Sao_Paulo' }));
                } catch (e) {
                    const offset = now.getTimezoneOffset() + 180;
                    return new Date(now.getTime() + offset * 60000);
                }
            }

            $scope.formatDateTime = function (datetime) {
                const date = new Date(datetime);
                return date.toLocaleString('pt-BR', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    timeZone: 'America/Sao_Paulo'
                });
            };

            $scope.isHappeningNow = function(event) {
                if (!event.starts_at || !event.ends_at) return false;
                
                const now = getBrasiliaTime();
                const start = new Date(event.starts_at);
                const end = new Date(event.ends_at);
                
                return now >= start && now <= end;
            };

            const nowBrasilia = getBrasiliaTime();
            const startOfDayBrasilia = new Date(
                nowBrasilia.getFullYear(),
                nowBrasilia.getMonth(),
                nowBrasilia.getDate()
            );
            const timestampBrasilia = Math.floor(startOfDayBrasilia.getTime() / 1000);

            $http({
                method: 'POST',
                url: '/callback/getNextEvents',
                data: { timestamp: timestampBrasilia },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                transformRequest: function(obj) {
                    return Object.keys(obj).map(key => 
                        encodeURIComponent(key) + '=' + encodeURIComponent(obj[key])
                    ).join('&');
                }
            }).then(function successCallback(response) {
                $scope.events = response.data;
            }).catch(function(error) {
                console.error('Erro ao carregar eventos:', error);
            }).finally(function() {
                $scope.loadingEvents = false;
            });
        });

        var rankingController = app.controller('rankingController', function ($scope, $http, $interval, $timeout, $window) {
            $scope.users = [];
            $scope.currency = 0;
            $scope.currencyName = null;
            $scope.loadingRanking = false;

            $scope.setCurrency = function (num) {
                if (num == $scope.currency)
                    return;

                $scope.loadingRanking = true;
                $scope.users.length = 0;

                if (num == 1) {
                    $scope.currencyName = "Diamantes";
                } else if (num == 2) {
                    $scope.currencyName = "Moedas";
                } else if (num == 3) {
                    $scope.currencyName = "Duckets";
                } else {
                    $scope.currencyName = "Emblemas";
                }


                $scope.currency = num;

                $http({
                    method: 'POST',
                    url: '/callback/getRanking',
                    data: $.param({type: num, limit: 5}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function successCallback(obj) {
                    var i = 1;
                    $scope.loadingRanking = false;
                    angular.forEach(obj.data, function (data) {
                        data.position = i;
                        data.amount = parseFloat(data.amount).toLocaleString('pt-br');
                        $scope.users.push(data);
                        i++;
                    });
                });
            };

            $scope.setCurrency(1);
        });

        var feedController = $('#feedController').length > 0 && app.controller('feedController', function ($scope, $http, $interval, $timeout, $window) {
            $scope.creatingPoll = false;
            $scope.pollOptions = ["", ""];

            $scope.addPollOption = function() {
                if ($scope.pollOptions.length < 4)
                    $scope.pollOptions.push('');
            };

            $scope.toggleCreatingPoll = function() {
                if ($scope.creatingPoll) {
                    $scope.creatingPoll = false;
                    $(".feed-poll-option input").removeAttr("required");
                }
                else {
                    $(".feed-poll-option input").attr("required", "required");
                    $scope.creatingPoll = true;
                }
            };

            $scope.loadPoll = function(postId) {
                $http({
                    method: 'POST',
                    url: '/callback/getPollOptions',
                    data: $.param({postId: postId}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function successCallback(obj) {
                    var post = $scope.findPost(postId);
                    post.poll = {};
                    post.poll.options = [];
                    post.poll.selectedOption = null;
                    post.poll.iVoted = obj.data.iVoted;

                    post.poll.allVotes = 0;

                    angular.forEach(obj.data.options, function (data) {
                        post.poll.allVotes += parseInt(data.votes);
                    });

                    angular.forEach(obj.data.options, function (data) {

                        data.text = data.text.replace(/:([a-z0-9_.-]+):/i, function (match, offset, string) {
                            return '<img src="' + $(".emoji-list img[title='" + match.toLowerCase() + "']").attr("src") + '">';
                        });

                        if (obj.data.iVoted == 0) {
                            var option = {id: data.id, text: data.text};
                        } else {
                            var option = {
                                id: data.id,
                                text: data.text,
                                votes: data.votes,
                                percentage: post.poll.allVotes != 0 ? ((data.votes / post.poll.allVotes) * 100).toFixed(0) : 0
                            };
                        }

                        $scope.findPost(postId).poll.options.push(option);
                    });
                });
            };

            $scope.sendPollVote = function(postId) {
                if ($scope.findPost(postId).poll.selectedOption === undefined)
                    return;

                $http({
                    method: 'POST',
                    url: '/callback/sendPollVote',
                    data: $.param({postId: postId, optionId: $scope.findPost(postId).poll.selectedOption}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function successCallback(obj) {
                    $("#feed-poll-" + postId).css("min-height", $("#feed-poll-" + postId).css("height") - 44);
                    $("#feed-poll-" + postId).animate({opacity: 0}, 500, function() {
                        $("#feed-poll-" + postId + " .feed-poll-option-radio").css("display", "none");
                        $("#feed-poll-" + postId + " button").css("display", "none");
                        $timeout(function(){
                            $("#feed-poll-" + postId).animate({opacity: 1}, 500);
                        },0,false);
                        $scope.loadPoll(postId);
                        $scope.$digest;
                    });
                });
            };

            $scope.postingStatus = false;
            $scope.newPostMessage = "";

            $scope.newPost = function () {
                if ($scope.postingStatus) {
                    return;
                }

                $scope.postingStatus = true;

                let requestData = {};
                let url = '';

                if (!$scope.creatingPoll) {
                    requestData = { message: $("#postingContent").val() };
                    url = '/callback/newFeedPost';
                } else {
                    requestData = {
                        question: $("#postingContent").val(),
                        options: JSON.stringify($scope.pollOptions)
                    };
                    url = '/callback/newFeedPoll';
                }

                $http({
                    method: 'POST',
                    url: url,
                    data: $.param(requestData),
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                }).then(function successCallback(response) {
                    $scope.newPostMessage = "";
                    if ($scope.creatingPoll) {
                        $scope.creatingPoll = false;
                        $scope.pollOptions = ["", ""];
                    }
                    $scope.loadPosts();
                }).finally(function () {
                    $scope.postingStatus = false;
                });
            };

            $scope.postComment = function (post) {
                if ($scope.postingStatus === false) {
                    $scope.postingStatus = true;

                    $http({
                        method: 'POST',
                        url: '/callback/newFeedComment',
                        data: $.param({postId: post.id, message: $("#inputCommentPostId"+post.id).val()}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function successCallback(obj) {
                        $("#inputCommentPostId"+post.id).val("");
                        post.comments = +post.comments + +1;
                        $scope.postingStatus = false;

                        $timeout(function () {
                            $scope.getComments(post);
                        }, 200);
                    });
                }
            };

            $scope.sharePost = null;
            $scope.prepareShare = function (post) {
                $scope.sharePost = post;

                $("#sharePostId").val(post.id);
                $('#sharePostModal').modal('toggle');
            };

            $scope.sharePostAction = function () {
                if ($scope.postingStatus === false) {
                    $scope.postingStatus = true;

                    $http({
                        method: 'POST',
                        url: '/callback/sharePost',
                        data: $.param({postId: $("#sharePostId").val(), message: $("#sharingContent").val()}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function successCallback(obj) {
                        $scope.sharePost.shared = +$scope.sharePost.shared + +1;
                        $("#sharePostId").val("");
                        $("#sharingContent").val("");

                        $('#sharePostModal').modal('hide');
                        $scope.loadPosts();
                        $scope.postingStatus = false;
                    });
                }
            };

            $scope.posts = [];
            $scope.newPostsCount = 0;
            $scope.newPostLastId = 0;
            $scope.postLasId = 0;
            $scope.beforeId = 0;
            $scope.loading = false;

            $scope.loadPosts = function () {
                if ($scope.loading === false) {

                    $scope.loading = true;
                    $http({
                        method: 'POST',
                        url: '/callback/getFeed',
                        data: $.param({afterId: $scope.postLasId}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function successCallback(obj) {
                        $scope.loading = false;
                        $scope.newPostsCount = 0;

                        if (obj.data !== "null") {
                            angular.forEach(obj.data, function (data) {
                                $scope.posts.unshift(data);
                                if (data.type == 2) {
                                    $scope.loadPoll(data.id);
                                }
                            });

                            $scope.beforeId = obj.data[obj.data.length - 1].id;
                            $scope.postLasId = obj.data[0].id;
                            $scope.newPostLastId = $scope.postLasId;
                        }
                    }, function errorCallback(obj) {
                        $scope.loading = false;
                        console.log(obj);
                    });
                }

            };
            $scope.loadPosts();

            $scope.loadNewPosts = function () {
                $scope.loadPosts();
                $(".updateFeedBtn").addClass("ng-hide");
            };

            $scope.loadOldPosts = function () {
                if ($scope.loading === false) {
                    $scope.loading = true;
                    $http({
                        method: 'POST',
                        url: '/callback/getOldFeed',
                        data: $.param({beforeId: $scope.beforeId}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function successCallback(obj) {
                        $scope.loading = false;
                        angular.forEach(obj.data, function (data) {
                            if (data.type == 2) {
                                $scope.loadPoll(data.id);
                                data.poll = {};
                            }

                            $scope.posts.push(data);
                            $scope.beforeId = data.id;
                        });
                    });
                }
            };

            $scope.checkNewPosts = function () {
                $http({
                    method: 'POST',
                    url: '/callback/checkFeedNewPosts',
                    data: $.param({afterId: $scope.newPostLastId}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function successCallback(obj) {
                    if (obj.data !== "null") {
                        if (obj.data.posts > 0) {
                            $scope.newPostsCount += +obj.data.posts;
                            $scope.newPostLastId = obj.data.lastid;
                        }
                    }
                }, function errorCallback(obj) {
                    console.log(obj);
                });
            };

            $interval(function () {
                if ($scope.newPostsCount < 15) {
                    if (!$window.idleUser && $scope.newPostsCount == 0)
                        $scope.checkNewPosts();
                }
            }, 60000);

            $scope.findPost = function (postId) {
                var foundPost = null;

                if ($scope.loading === false) {
                    angular.forEach($scope.posts, function (post) {
                        if (post.id == postId)
                            foundPost = post;
                    });
                }

                return foundPost;
            };

            $scope.postComments = [];
            $scope.lastCommentId = [];
            $scope.getComments = function (post) {
                $("#commentsPost" + post.id).css("display", "block");

                if ($scope.loading === false) {
                    $scope.loading = true;

                    if (parseInt(post.comments) >= 0) {
                        $http({
                            method: 'POST',
                            url: '/callback/getFeedPostComments',
                            data: $.param({postId: post.id, afterId: $scope.lastCommentId[post.id]}),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function successCallback(obj) {
                            $scope.loading = false;
                            if (obj.data != 'null') {
                                if ($scope.postComments[post.id] == null) {
                                    $scope.postComments[post.id] = [];
                                }

                                angular.forEach(obj.data, function (data) {
                                    $scope.postComments[post.id].push(data);
                                });

                                $scope.lastCommentId[post.id] = obj.data[obj.data.length - 1].id;
                            }
                        });
                    }
                }
            };

            $scope.likePost = function (postId, isShared) {
                var post = $scope.findPost(postId);

                if (isShared)
                    postId = post.sharedId;

                $http({
                    method: 'POST',
                    url: '/callback/likeFeedPost',
                    data: $.param({postId: postId}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function successCallback(obj) {
                    if (obj.data === "LIKED") {
                        if (isShared) {
                            if (post.sharediLiked === 0) {
                                post.sharediLiked = 1;
                                post.sharedLikes = parseInt(post.sharedLikes) + 1;
                            }
                        } else {
                            if (post.iLiked === 0) {
                                post.iLiked = 1;
                                post.likes = parseInt(post.likes) + 1;
                            }
                        }

                    } else {
                        if (isShared) {
                            if (post.sharediLiked === 1) {
                                post.sharediLiked = 0;
                                post.sharedLikes = parseInt(post.sharedLikes) - 1;
                            }
                        } else {
                            if (post.iLiked === 1) {
                                post.iLiked = 0;
                                post.likes = parseInt(post.likes) - 1;
                            }
                        }
                    }
                });
            };

            $scope.likeComment = function (comment) {
                $http({
                    method: 'POST',
                    url: '/callback/likeFeedComment',
                    data: $.param({commentId: comment.id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function successCallback(obj) {
                    if (obj.data === "LIKED") {
                        if (comment.iLiked === 0) {
                            comment.iLiked = 1;
                            comment.likes = parseInt(comment.likes) + 1;
                        }
                    } else {
                        if (comment.iLiked === 1) {
                            comment.iLiked = 0;
                            comment.likes = parseInt(comment.likes) - 1;
                        }
                    }
                });
            };

            $scope.deletePost = function (post) {
                if (confirm("Você tem certeza de que deseja apagar esta publicação?"))
                    $http({
                        method: 'POST',
                        url: '/callback/deleteFeedPost',
                        data: $.param({postId: post.id}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function successCallback(obj) {
                        if (obj.data === "OK") {
                            var index = $scope.posts.indexOf(post);
                            $scope.posts.splice(index, 1);
                        }
                    });
            };

            $scope.deleteComment = function (post, commentId) {
                if (confirm("Você tem certeza de que deseja apagar este comentário?"))
                    $http({
                        method: 'POST',
                        url: '/callback/deleteFeedComment',
                        data: $.param({commentId: commentId}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function successCallback(obj) {
                        if (obj.data === "OK") {
                            post.comments = +post.comments - +1;
                            $("#Comment"+commentId).remove();
                        }
                    });
            };

            $scope.replyComment = function (post, comment) {
                var input = $("#postIdPanel" + post.id).find("input");
                input.val("@" + comment.username + " ").focus();
            };
        });

        $(window).on('resize scroll', function() {
            if ($("#feedScrollspy").isInViewport())
                angular.element($('#feedController')).scope().loadOldPosts();
        });
    </script>
                    <!-- end ngRepeat: user in users track by $index -->
                                  <div class="modal-footer ng-hide" ng-show="notifications.length &gt; 0">
                        <button type="button" class="btn btn-primary" ng-click="clearNotifications()">Limpar notificações</button>
                        <div class="cookies-warning animated bounce">
    <i class="fas fa-exclamation-triangle" style="font-size: 20px; float: left; margin-right: 20px"></i> Nós utilizamos cookies para melhorar a sua experiência aqui dentro. Ao continuar utilizando nosso site você está de acordo com isso.
    <span style="float: right; color: rgba(255, 255, 255, .8); font-size: 18px">OK?</span>
</div>
    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="
    font-weight: 400;
    font-size: 14px;
    background: linear-gradient(90deg, #1e262c, #28313a);
    padding: 12px 20px;
    border-top: 4px solid #2c3e50;
    margin-top: 30px;
    text-align: center;
    color: #a7a7a7;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    user-select: none;
    ">
  <div class="container" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px; height:16px; fill:#a7a7a7;" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
      <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm-.5-13h1a3.5 3.5 0 0 1 0 7h-1v3h-1v-10h2v3h-1a2.5 2.5 0 1 0 0-5z"/>
    </svg>
    <span>
      © <?php echo ano ?> Rede <?php echo nome ?> Corporation Ltd. Todos os direitos reservados.
    </span>
  </div>
</div>


</body>

</html>