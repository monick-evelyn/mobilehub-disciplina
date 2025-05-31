<?php
session_start();
include "Turma.php";
include "./database/config.php";
include "./others/valida_dados.php";

#### EMAILS PARA COLOCAR NA PARTE DE DEVS ######
$email_vitoria = "vitoria.ketillyn@academico.ifpb.edu.br";
$email_monick = "monick.evelyn@academico.ifpb.edu.br";
$email_rebeca = "rebeca.medeiros@academico.ifpb.edu.br";

$turma_obj = new Turma(mysql: $conexao);
$turmas = $turma_obj->get_turmas();

$input_turma = $turma_erro = $input_periodo = $periodo_erro = $add_turma_erro = "";
$val_ano_turma = $val_periodo_turma = false;

$permissao = false;
// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Se não for administrador, redireciona para a página de login
    //$_SESSION['user_type'] = 'aluno';
    $permissao = false;
} else {
    //$_SESSION['user_type'] = 'admin';
    $permissao = true;
}
######### LÓGICA LOGIN ###########

if (isset($_GET["enviar_turma"])) {
    $input_turma = valida_dados($_GET["input_turma"]);
    $input_periodo = valida_dados($_GET["input_periodo"]);

    if (strlen($input_turma) != 4) {
        $turma_erro = "O ano deve possuir 4 números.";
    } else {
        $val_ano_turma = true;
    }
    if (strlen($input_periodo) > 1) {
        $periodo_erro = "O período deve possuir 1 número.";
    } else {
        $val_periodo_turma = true;
    }

    if (empty($input_turma)) {
        $turma_erro = "Campo Obrigatório!";
    }

    if (empty($input_periodo)) {
        $periodo_erro = "Campo Obrigatório!";
    }
    if (!empty($input_periodo) && !empty($input_turma) && $val_ano_turma === true && $val_periodo_turma === true) {
        if (!$turma_obj->verifica_existencia($input_turma, $input_periodo)) {
            $turma_obj->insere_turma($input_turma, $input_periodo);
        } else {
            $add_turma_erro = "Essa turma já está cadastrada!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Font Awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Importação CSS-->
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="stylesheet" href="./css/colors.css">
    <link rel="stylesheet" href="./css/navbar.css">

    <!-- icon -->
    <link rel="icon"href="./img/circulo.png">

    <!--Importação JQUERY-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--Importação JavaScript-->
    <script src="./javascript/inicio.js"></script>
    <script src="./javascript/alert.js"></script>

    <!--Importação ScrollReveal-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Início - MobileHub</title>
</head>

<body>
    <header>
        <nav id="navbar">
            <img src="./img/mobile-hub-logo.png" alt="">

            <ul id="nav-list">
                <li class="nav-item active">
                    <a href="#home">Início</a>
                </li>
                <li class="nav-item">
                    <a href="#classes">Turmas</a>
                </li>
                <li class="nav-item">
                    <a href="#about">Sobre a disciplina</a>
                </li>
                <li class="nav-item">
                    <a href="#devs">Desenvolvedoras</a>
                </li>
                
            </ul>
            <?php if ($permissao === true): ?>
                    <button class="button-default" onclick="window.location='adicionar_projeto.php'">Adicionar aplicativo</button>
                <?php endif; ?>

            <button id="mobile-button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>

        <div id="mobile-menu">
            <ul id="mobile-nav-list">
                <li class="nav-item">
                    <a href="#home">Início</a>
                </li>
                <li class="nav-item">
                    <a href="#classes">Turmas</a>
                </li>
                <li class="nav-item">
                    <a href="#about">Sobre a disciplina</a>
                </li>
                <li class="nav-item">
                    <a href="#devs">Desenvolvedoras</a>
                </li>
            </ul>
            <?php if ($permissao === true): ?>

                <button class="button-default" onclick="window.location='adicionar_projeto.php'">Adicionar
                    aplicativo</button>

            <?php endif; ?>

        </div>
    </header>
    <main id="content">
        <section id="home">
            <div id="cta">
                <h1 class="title">Mobile Hub</h1>
                <p class="description"> Aqui são disponibilizados os aplicativos feitos pelos alunos da disciplina de
                    Tópicos Especiais, os quais foram feitos com muito esforço e trabalho em equipe. Graças a isso, é
                    notável o poder da colaboração e da tecnologia na transformação da educação.
                </p>

                <!--Botões-->
                <div class="links-buttons">
                    <!--Moodle-->
                    <a href="https://presencial.ifpb.edu.br/login/index.php">Moodle</a>

                    <!--Suap-->
                    <a href="https://suap.ifpb.edu.br/accounts/login/?next=/">Suap</a>

                    <!--Site-->
                    <a href="https://www.ifpb.edu.br/">Site IFPB</a>
                </div>
            </div>

            <!--Imagem-->
            <div id="banner">
                <img src="./img/inicio/celular-home.png" alt="Celular">
            </div>
        </section>

        <section id="classes">
            <h3 class="section-subtitle">Confira os aplicativos dos alunos</h3>

            <div id="container">
                <!-- Início do foreach para gerar vários cards de turmas dinamicamente-->
                <?php foreach ($turmas as $turma): ?>
                    <div class="card card0">
                        <div class="card-content">
                            <!--Título-->
                            <h3 class="card-title">Turma <?= $turma['ano'] . "." . $turma['periodo']; ?></h3>
                            <p class="card-description">Ministrada pelo Prof. Alexandre Costa</p>
                            <!--Botão-->
                            <button class="button-default"
                                onclick="window.location = 'apps.php?ano=<?= $turma['ano']; ?>&periodo=<?= $turma['periodo']; ?>'">Ver
                                aplicativos</button>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!--CARD PARA ADICIONAR TURMA-->
                <?php if ($permissao === true): ?>
                    <div class="card add-class">
                        <div class="card-content">
                            <form method="get" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <!--Título-->
                                <h3 class="card-title">Nova Turma</h3>

                                <input style="margin-bottom: 0px;" type="number" id="input_turma" name="input_turma"
                                    placeholder="Ano da turma (Ex.: 2022)">
                                <small class="text-danger" style="color: red;">*<?= $turma_erro; ?></small>

                                <input style="margin-bottom: 0px;" type="number" id="input_periodo" name="input_periodo"
                                    placeholder="Período da turma (Ex.: 1, 2)">
                                <small class="text-danger" style="color: red;">*<?= $periodo_erro; ?></small>

                                <!--Botão-->
                                <button class="button-default add-turma-button" name="enviar_turma" type="submit"
                                    style="margin-top: 10px;">Adicionar turma</button>
                                <small class="text-danger" style="color: red;"><?= $add_turma_erro; ?></small>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section id="about">
            <img src="./img/inicio/android_studio.png" id="about-img" alt="">
            <div id="about-content">
                <h2 class="section-title">Sobre a disciplina</h2>
                <h3 class="section-subtitle">Conheça Tópicos Especiais</h3>
                <p class="description">Na disciplina de Tópicos Especiais no curso técnico em informática os alunos são
                    incentivados a organizar seus projetos de forma eficiente utilizando diversas linguagens de
                    programação e garantindo que os aplicativos atendam às demandas específicas dos usuários. Isso
                    inclui desde a concepção da ideia inicial, passando pelo design da interface, até a implementação e
                    testes finais</p>
                <p class="description">Dessa forma, os alunos não apenas adquirem habilidades técnicas, mas também
                    desenvolvem competências essenciais para o mercado de trabalho, como a capacidade de resolver
                    problemas, trabalhar em grupo e adaptar-se a novas tecnologias.</p>
            </div>
        </section>

        <!-- ####################### alterações DEVS ######################## -->
        <section id="devs">
            <div class="wrapper">
                <h3 class="section-subtitle">Desenvolvedoras</h3>
        
                <div class="container">
                    <!--Vitória-->
                    <div class="card-dev">

                        <div class="dev-img">
                            <img src="./img/devs/vitoria.jpg" alt="">
                        </div>

                        <div class="content">
                            <div class="content-box">
                                <h3>Vitória Ketillyn<br><span>Analista de Requisitos</span></h3>
                            </div>
                            <ul class="social">
                                <li style="--i: 1">
                                    <a href="https://www.instagram.com/ketillyn_12_?igsh=ZTRobGxpenN0amdk" target=”_blank”><i class="fa-brands fa-instagram" style="color: var(--white);"></i></a>
                                </li>
                                <li style="--i: 2">  
                                    <a href= "<?="https://mail.google.com/mail/?view=cm&fs=1&to=".$email_vitoria."&su=Assunto%20do%20E-mail&body=Texto%20do%20corpo"?>" target=”_blank”>
                                        <i class="fa-regular fa-envelope" style="color: var(--white);"></i></a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    <!--Rebeca-->
                    <div class="card-dev" id="rebeca">

                        <div class="dev-img">
                            <img src="./img/devs/rebeca.jpg" alt="">
                        </div>

                        <div class="content">
                            <div class="content-box">
                                <h3>Rebeca Medeiros<br><span>Desenvolvedora Front-end</span></h3>
                            </div>
                            <ul class="social">
                                <li style="--i: 1">
                                    <a href="https://www.instagram.com/rebecamdrs?igsh=MTJicWxzdmVpM3A1eg%3D%3D&utm_source=qr " target=”_blank”><i class="fa-brands fa-instagram" style="color: var(--white);"></i></a>
                                </li>
                                <li style="--i: 2">  
                                    <a href= "<?="https://mail.google.com/mail/?view=cm&fs=1&to=".$email_rebeca."&su=Assunto%20do%20E-mail&body=Texto%20do%20corpo"?>" target=”_blank”>
                                        <i class="fa-regular fa-envelope" style="color: var(--white);"></i></a>
                                </li>
                                <li style="--i: 3">
                                    <a href="https://www.linkedin.com/in/rebeca-silva-4557502a1?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app " target=”_blank”><i class="fa-brands fa-linkedin-in" style="color: var(--white);"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--Monick-->
                    <div class="card-dev" id="monick">

                        <div class="dev-img">
                            <img src="./img/devs/monick.jpg" alt="">
                        </div>

                        <div class="content">
                            <div class="content-box">
                                <h3>Monick Évellyn<br><span>Desenvolvedora Back-end</span></h3>
                            </div>
                            <ul class="social">
                                <li style="--i: 1">
                                    <a href="https://www.instagram.com/monickevs/profilecard/?igsh=eW81YnVydmVkaW1y" target=”_blank”><i class="fa-brands fa-instagram" style="color: var(--white);"></i></a>
                                </li>
                                <li style="--i: 2">  
                                    <a href= "<?="https://mail.google.com/mail/?view=cm&fs=1&to=".$email_monick."&su=Assunto%20do%20E-mail&body=Texto%20do%20corpo"?>" target=”_blank”>
                                        <i class="fa-regular fa-envelope" style="color: var(--white);"></i></a>
                                </li>
                                <li style="--i: 3">
                                    <a href="https://www.linkedin.com/in/monick-évelyn-36b544339" target=”_blank”><i class="fa-brands fa-linkedin-in" style="color: var(--white);"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ####################### fim das alterações DEVS ######################## -->
    </main>
</body>

</html>