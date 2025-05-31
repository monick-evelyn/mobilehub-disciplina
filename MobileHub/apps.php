<?php
session_start();
include "Projeto.php";
include "./database/config.php";

$sucesso_delete = false;
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

####################### VERIFICANDO TURMA PARA O CARD ESPECIFICO ################################
//pega os parametros passados para a URL na tela_inicial.php
$ano = isset($_GET['ano']) ? $_GET['ano'] : '';
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
$turma = $ano . "." . $periodo;

//criação de um novo obj para projeto ligado ao bd
$projeto_obj = new Projeto(mysql: $conexao);

// Verifica se a turma foi especificada
if ($ano && $periodo) {
  $projetos = $projeto_obj->get_projetos_por_turma($ano, $periodo);
} else {
  //caso contrário, busca todos os projetos
  $projetos = $projeto_obj->get_projetos();
}
if(isset($_GET['apagar'])) {
  $id = $_GET['id_projeto'];
  $projeto_obj->apagar_projeto($id);
  $sucesso_delete = true;
  header("location:apps.php?ano=".$ano."&periodo=".$periodo);
  //header("location:apps.php?ano=".$ano."&periodo=".$periodo."&confirmacao=Confirmacao");
}

$projetos = $projeto_obj->get_projetos_por_turma($ano, $periodo);// chama o método get_atores(), que retorna informações do BD
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--Importação CSS-->
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/apps.css">
  <link rel="stylesheet" href="./css/colors.css">
  <link rel="stylesheet" href="./css/navbar.css">

  <link rel="stylesheet" href="css/modal2.css">
  <link rel="stylesheet" href="css/modal_excluir.css">

  
  <!-- icon -->
  <link rel="icon" href="./img/circulo.png">

  <!--Font Awesome CDN-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!--Importação JQUERY-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

        <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>

  <title>Aplicativos</title>
</head>

<body>
  <header>
    <nav id="navbar">
      <img src="./img/mobile-hub-logo.png" alt="">
      <h2> Turma <?= $turma ?></h2> 
      <button class="button-default" onclick="window.location='tela_inicial.php'">Voltar</button>
      <!-- <button class="button-default" onclick="window.location='adicionar_projeto.php'">Adicionar aplicativo</button> -->

      <button id="mobile-button">
        <i class="fa-solid fa-bars"></i>
      </button>
    </nav>

    <div id="mobile-menu">
      <button class="button-default" onclick="window.location = 'tela_inicial.php'">Voltar</button>
    </div>

  </header>
  <div id="cards-apps">

    <!-- Início do foreach para gerar vários cards de turmas dinamicamente-->
    <?php foreach ($projetos as $projeto): ?>
      <div class="card-app card-app0">
        <img id="app-img" src="<?= $projeto['image_app']; ?> " />
        <div>
          <h2><?= $projeto['nome']; ?></h2>
          <p><?= $projeto['descricao']; ?></p>
          <div id="students">
            <div class="student">
              <!-- <img id="img-student" src="./img/estudante-teste.png" alt=""> -->
              <h3><?= $projeto['nome_aluno1']; ?></h3>
            </div>
            <div class="student">
              <!-- <img id="img-student" src="./img/estudante-teste.png" alt=""> -->
              <h3><?= $projeto['nome_aluno2']; ?></h3>
            </div>
            <div class="student">
              <!-- <img id="img-student" src="./img/estudante-teste.png" alt=""> -->
              <h3><?= $projeto['nome_aluno3']; ?></h3>
            </div>
          </div>
          <div class="botoes">

            <button class="button-default">
              <a href="<?= $projeto['download']; ?>">Baixar aplicativo</a>
            </button>

            <?php if ($permissao === true): ?>
              <div class="crud">

              <!-- Botão excluir -->
                <button class="button-default" id="delete_button" name="delete_button" value="delete_button" onclick="window.location = 'apps.php?ano=<?= $_GET['ano'];?>&periodo=<?= $_GET['periodo'];?>&id_projeto=<?= $projeto['id_projeto'];?>&confirmacao=Confirmacao'">
                  <i class="fa-solid fa-trash" style="color: var(--white);"></i>
                </button>

                <!-- Botão editar -->
                <button class="button-default" id="update_button" value="update_button" onclick="window.location = 'editar_projeto.php?ano=<?= $_GET['ano'];?>&periodo=<?= $_GET['periodo'];?>&id_projeto=<?= $projeto['id_projeto'];?>&editar=Editar'">
                  <i class="fa-solid fa-pen" style="color: var(--white);"></i>
                </button>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>


  <!-- HTML para mostrar popup -->
    <?php if (isset($_GET['confirmacao'])) : ?>
        <!-- MODAL FORM-->
    <div class="modal" id="modal-excluir">
      <article class="modal-container">

        <header class="modal-container-header">

          <!-- Titulo -->
          <h1 class="modal-container-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ff0000" d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480L40 480c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24l0 112c0 13.3 10.7 24 24 24s24-10.7 24-24l0-112c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
            Atenção
          </h1>
        </header>
        
        <section class="modal-container-body rtf">
          <p>Você realmente deseja excluir esse projeto?</p>
        </section>
        <footer class="modal-container-footer">
          <button class="button-default close-btn" id="fechar">Cancelar</button>
          <button class="button-default">Excluir</button>
        </footer>
      </article>
    </div>
    <?php endif; ?>

    <!-- Script javascript para mostrar popup -->
    <script src="javascript/modal2.js"></script>
</body>

</html>