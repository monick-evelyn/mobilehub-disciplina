<?php
require './database/config.php';
include 'Projeto.php';

include "Turma.php";
include "./others/valida_dados.php";

$turma_obj = new Turma(mysql: $conexao);
$turmas = $turma_obj->get_turmas();

//inicialização de variáveis
$validacao = false;
$nome_aluno = "";
$nome_app = $turma = $descricao = $download_link = $foto_app = $nome_aluno1 = $nome_aluno2 = $nome_aluno3 = "";

$nome_app_erro = $turma_erro = $descricao_erro = $foto_app_erro = $download_link_erro = $nome_aluno1_erro = $nome_aluno2_erro = $nome_aluno3_erro = "";

$projeto_obj = new Projeto(mysql: $conexao);

define("QTD_ALUNOS", 3);
define("PADRAO_NOME", '/^[a-zA-ZÀ-ú\s]+$/');
define("PADRAO_URL", '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i');

$sucesso = false;

//verifica o envio do formulário
if (isset($_POST['salvar'])) {
    //app
    $nome_app = valida_dados($_POST["nome_app"]);
    $turma = valida_dados($_POST["turma"]);
    $descricao = valida_dados($_POST["descricao"]);
    $download_link = valida_dados($_POST["download_link"]);
    $foto_app = valida_dados($_POST["foto_app"]);

    //alunos 
    $nome_aluno1 = valida_dados($_POST["nome_aluno1"]);
    $nome_aluno2 = valida_dados($_POST["nome_aluno2"]);
    $nome_aluno3 = valida_dados($_POST["nome_aluno3"]);

    //VALIDAÇÃO NOME APP
    if (empty($nome_app)) {
        $nome_app_erro = "Campo Obrigatório!";
    } else if (!preg_match(PADRAO_NOME, $nome_app)) {
        $nome_app_erro = "O nome deve conter apenas letras e espaços em branco.";
    }

    //VALIDAÇÃO TURMA
    if (empty($turma)) {
        $turma_erro = "Campo Obrigatório!";
    }

    //VALIDAÇÃO DESCRIÇÃO
    if (empty($descricao)) {
        $descricao_erro = "Campo Obrigatório!";
    }

    //VALIDAÇÃO DOWNLOAD LINK
    if (empty($download_link)) {
        $download_link_erro = "Campo Obrigatório!";
    } else if (!preg_match(PADRAO_URL, $download_link)) {
        $download_link_erro = "URL inválida!";
    }

    if (empty($foto_app)) {
        $foto_app_erro = "Campo Obrigatório!";
    } else if (!preg_match(PADRAO_URL, $foto_app)) {
        $foto_app_erro = "URL inválida!";
    }

    if (empty($nome_aluno1)) {
        $nome_aluno1_erro = "Campo Obrigatório!";
    } else if (!preg_match(PADRAO_NOME, $nome_aluno1)) {
        $nome_aluno1_erro = "O nome deve conter apenas letras e espaços em branco.";
    }

    if (!empty($nome_aluno2) && !preg_match(PADRAO_NOME, $nome_aluno2)) {
        $nome_aluno2_erro = "O nome deve conter apenas letras e espaços em branco.";
    }

    if (!empty($nome_aluno3) && !preg_match(PADRAO_NOME, $nome_aluno3)) {
        $nome_aluno3_erro = "O nome deve conter apenas letras e espaços em branco.";
    }

    //verifica novamente se não há campos em branco
    if (!empty($nome_app) && !empty($descricao) && !empty($turma) && !empty($download_link) && !empty($foto_app) && !empty($nome_aluno1)
    && empty($nome_app_erro) && empty($descricao_erro) && empty($turma_erro) && empty($download_link_erro)  && empty($foto_app_erro)  && empty($nome_aluno1_erro) && empty($nome_aluno2_erro) && empty($nome_aluno3_erro) && empty($nome_aluno_erro)){
        $validacao = true;
        //verifica a existência de outro projeto no BD
        
    }
}

if(isset($_GET['cadastrar']) && $validacao == true) {
    //$sucesso_delete = true;
    if ($projeto_obj->verifica_existencia($nome_app, $turma) == false) {
        //insere no BD caso a condição seja falsa
        $projeto_obj->insere_projeto($nome_app, $descricao, $foto_app, $download_link, $turma, $nome_aluno1, $nome_aluno2, $nome_aluno3);
            $sucesso = true;
    header("location:adicionar_projeto.php");
        //$nome_app = $descricao = $download_link = $foto_app = $turma = $nome_aluno1 = $nome_aluno2= $nome_aluno3 = "";

    } else {
        //do contrário, um erro é mostrado na tela.
        echo "<script>alert('Esse aplicativo já está cadastrado nessa turma!');</script>";
    }
    //header("location:apps.php?ano=".$ano."&periodo=".$periodo."&confirmacao=Confirmacao");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Metadados da página -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


    <!-- icon -->
    <link rel="icon" href="./img/circulo.png">

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

    <!-- CSS -->
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/colors.css">
    <link rel="stylesheet" href="./css/adicionar.css">

    <link rel="stylesheet" href="css/modal2.css">

    <!-- Adiciona o título da página -->
    <title>Cadastro de Aplicativo</title>

</head>

<body>
    <header>
        <nav id="navbar">
            <button class="button-default" onclick="window.location='tela_inicial.php'"
                style="background-color: var(--white); color: var(--blue);">Voltar</button>

            <button id="mobile-button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>

        <div id="mobile-menu">
            <button class="button-default" onclick="window.location='tela_inicial.php'">Voltar</button>
        </div>
    </header>

    <div class="container-xxl my-2">
        <div class="row justify-content-center">
            <!-- Card Adicionar -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <img class="card-img-top">
                        <h2 class="card-title text-center">Cadastro de Projeto</h2>

                        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            enctype="multipart/form-data">
                            <hr class="mt-3 mb-4">
                            <section>
                                <fieldset>
                                    <legend>Informações do Projeto</legend>
                                    <!--campo de nome do projeto -->
                                    <div class="form-group">
                                        <label for="nome">Nome </label>
                                        <input type="text" class="form-control" name="nome_app" id="nome_app"
                                            placeholder="Nome do projeto" value="<?= $nome_app ?>">
                                        <small class="text-danger">*<?= $nome_app_erro; ?></small>
                                    </div>

                                    <!-- campo de turma -->
                                    <div class="form-group">
                                        <label for="turma">Turma</label>
                                        <select class="form-control" name="turma" id="turma">
                                            <option value="">Selecione...</option>
                                            <?php for ($i = 0; $i < count($turmas); $i++): ?>
                                                <option value="<?= $turmas[$i]['ano'] . "." . $turmas[$i]['periodo']; ?>">
                                                    <?= $turmas[$i]['ano'] . "." . $turmas[$i]['periodo']; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <small class="text-danger">*<?= $turma_erro; ?></small>
                                    </div>

                                    <!-- campo de descrição do projeto -->
                                    <p> </p>
                                    <label for="Descricao"> Descrição</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Descrição</span>
                                        </div>
                                        <textarea class="form-control" aria-label="Com textarea" id="descricao"
                                            name="descricao"><?= $descricao;?></textarea>
                                        <p></p>
                                    </div>
                                    <small class="text-danger">*<?= $descricao_erro; ?></small>
                                </fieldset>
                            </section>

                            <!-- campo de download do projeto -->
                            <label for="basic-url">Link para Download na Play Store</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">link</span>
                                </div>
                                <input type="text" class="form-control" id="download_link" name="download_link" value="<?= $download_link?>"
                                    placeholder="Insira o link" aria-describedby="basic-addon3">
                            </div>
                            <small class="text-danger">*<?= $download_link_erro; ?></small>

                            <!-- UPLOAD FOTO APP --->
                            <br>
                            <div class="form-group">
                                <label for="nome">URL da foto do aplicativo </label>
                                <input type="text" class="form-control" name="foto_app" id="foto_app" value="<?= $foto_app?>"
                                    placeholder="URL da foto do app">
                                <small class="text-danger">*
                                    <?= $foto_app_erro; ?>
                                </small>
                            </div>
                            <!-- FIM DO UPLOAD DE FOTO DE APP -->

                            <hr class="mt-3 mb-4">
                            <legend>Informações dos desenvolvedores</legend>

                            <!-- for para a quantidade de alunos, repetindo os campos -->
                            <?php for ($i = 1; $i <= QTD_ALUNOS; $i++): ?>
                                <!-- campo de nome do aluno -->
                                <div class="form-group">
                                    <label for="Alunos"><strong>Aluno <?= $i ?></strong></label>
                                    <?PHP $nome_aluno = 'nome_aluno' . $i ?>
                                    <input type="text" class="form-control" name="nome_aluno<?= $i ?>"
                                        id="nome_aluno<?= $i ?>" placeholder="Nome do Aluno <?= $i ?>" value="<?= $$nome_aluno ?>">
                                    <?php $nome_aluno_erro = 'nome_aluno' . $i . '_erro' ?>
                                </div>
                                <small class="text-danger">*<?= $$nome_aluno_erro; ?></small>
                                <hr class="mt-3 mb-4">
                            <?php endfor; ?>
                            <!-- Fim do for para gerar vários cards de questões -->

                            <!-- Butão de cadastro de formulário -->
                            <button type="submit" name="salvar" class="button-default" onclick="abrirFormModal()">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card ver -->
            <?php if ($sucesso == true): ?>
                <!-- MODAL FORM-->
                <div class="modal" id="modal-form">
                <article class="modal-container">

                    <header class="modal-container-header">

                    <!-- Titulo -->
                    <h1 class="modal-container-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#034dc9" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24l0 112c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-112c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
                        Pré-visualização
                    </h1>
                    </header>
                    
                    <section class="modal-container-body rtf">

                    <h2>Informações do Projeto</h2>
                    <p class="nome"><strong>Nome: </strong><?= $nome_app?></p>
                    <p class="turma"><strong>Turma: </strong><?= $turma?></p>
                    <p><strong>Descrição</strong></p>
                    <p class="descricao"><?= $descricao?></p>

                    <p><strong>Link para Download: </strong></p>
                    <a href="<?= $download_link?>"><?= $download_link?></a>

                    <p><strong>Foto do Aplicativo</strong></p>
                    <img src="<?= $foto_app?>" alt="imagem_<?= $nome_app?>">


                    <h2>Desenvolvedores</h2>

                    <?php for ($i = 1; $i <= QTD_ALUNOS; $i++): ?>
                        <p><strong>Nome do aluno <?= $i ?>: </strong> <?php $nome_aluno = 'nome_aluno' . $i;
                            echo $$nome_aluno; ?></p>
                    <?php endfor; ?>

                    </section>
                    <footer class="modal-container-footer">
                    <button class="button-default close-btn" id="fechar">Voltar</button>
                    <button class="button-default" name="cadastrar" onclick="window.location = 'adicionar_projeto.php?&concluir=Concluir'">Cadastrar</button>
                    </footer>
                </article>
                </div> 
            <?php endif; ?>
        </div>
    </div>

    <!-- HTML para mostrar popup -->
    <?php if (isset($_POST['cadastrar']) && $sucesso) : ?>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastro de projeto
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Projeto cadastrado com sucesso!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    </div>
                </div>
            </div>
        </div>
        

    <?php elseif (isset($_POST['cadastrar']) && !$sucesso) : ?>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Atenção!
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Erro ao cadastrar projeto!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- Script javascript para mostrar popup -->
    <script src="javascript/popup.js"></script> 
    <script src="javascript/modal2.js"></script>
</body>

</html>