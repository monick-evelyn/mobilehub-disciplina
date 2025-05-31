<?php
require './database/config.php';
include 'Projeto.php';

include "Turma.php";
include "./others/valida_dados.php";

$turma_obj = new Turma(mysql: $conexao);
$turmas = $turma_obj->get_turmas();

//inicialização de variáveis
$periodo = $ano = 0;
$nome_app_novo = $turma_novo = $descricao_novo = $download_link_novo = $foto_app_novo = $nome_aluno1_novo = $nome_aluno2_novo = $nome_aluno3_novo = $nome_aluno_novo =  "";
$nome_app = $turma = $descricao = $download_link = $foto_app = $nome_aluno1 = $nome_aluno2 = $nome_aluno3 = $nome_aluno = "";

$nome_app_erro = $turma_erro = $descricao_erro = $foto_app_erro = $download_link_erro = $nome_aluno1_erro = $nome_aluno2_erro = $nome_aluno3_erro = "";

$mensagem = "";

$projeto_obj = new Projeto(mysql: $conexao);
$sucesso = false;

define("QTD_ALUNOS", 3);
define("PADRAO_NOME", '/^[a-zA-ZÀ-ú\s]+$/');
define("PADRAO_URL", '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i');

$id_projeto = 0;
if (isset($_GET['editar'])) {
    $id_projeto = $_GET['id_projeto'];
    $ano = $_GET['ano'];
    $periodo = $_GET['periodo'];
    //echo $id_projeto;

    $projeto = $projeto_obj->get_projeto_id($id_projeto);
    
    }
    if (isset($_POST['cadastrar'])) {
        //echo $id_projeto;

        //app
        $nome_app_novo = valida_dados($_POST["nome_app"]);
        $turma_novo = valida_dados($_POST["turma"]);
        $descricao_novo  = valida_dados($_POST["descricao"]);
        $download_link_novo = valida_dados($_POST["download_link"]);
        $foto_app_novo = valida_dados($_POST["foto_app"]);

        //alunos 
        $nome_aluno1_novo  = valida_dados($_POST["nome_aluno1"]);
        $nome_aluno2_novo  = valida_dados($_POST["nome_aluno2"]);
        $nome_aluno3_novo  = valida_dados($_POST["nome_aluno3"]);

        //VALIDAÇÃO NOME APP
        if (empty($nome_app_novo )) {
            $nome_app_erro = "Campo Obrigatório!";
        } else if (!preg_match(PADRAO_NOME, $nome_app_novo)) {
            $nome_app_erro = "O nome deve conter apenas letras e espaços em branco.";
        }

        //VALIDAÇÃO TURMA
        if (empty($turma_novo)) {
            $turma_erro = "Campo Obrigatório!";
        }

        //VALIDAÇÃO DESCRIÇÃO
        if (empty($descricao_novo )) {
            $descricao_erro = "Campo Obrigatório!";
        }

        //VALIDAÇÃO DOWNLOAD LINK
        if (empty($download_link_novo )) {
            $download_link_erro = "Campo Obrigatório!";
        } else if (!preg_match(PADRAO_URL, $download_link_novo )) {
            $download_link_erro = "URL inválida!";
        }

        if (empty($foto_app_novo )) {
            $foto_app_erro = "Campo Obrigatório!";
        } else if (!preg_match(PADRAO_URL, $foto_app_novo )) {
            $foto_app_erro = "URL inválida!";
        }

        if (empty($nome_aluno1_novo )) {
            $nome_aluno1_erro = "Campo Obrigatório!";
        } else if (!preg_match(PADRAO_NOME, $nome_aluno1_novo )) {
            $nome_aluno1_erro = "O nome deve conter apenas letras e espaços em branco.";
        }

        if (!empty($nome_aluno2_novo ) && !preg_match(PADRAO_NOME, $nome_aluno2_novo )) {
            $nome_aluno2_erro = "O nome deve conter apenas letras e espaços em branco.";
        }

        if (!empty($nome_aluno3_novo ) && !preg_match(PADRAO_NOME, $nome_aluno3_novo )) {
            $nome_aluno3_erro = "O nome deve conter apenas letras e espaços em branco.";
        }

        if (!empty($nome_app_novo) && !empty($descricao_novo) && !empty($turma_novo) && !empty($download_link_novo) && !empty($foto_app_novo) && !empty($nome_aluno1_novo)) {

            /*if ($nome_app_novo != $nome_app || $descricao_novo != $descricao  || $turma_novo != $turma || $download_link_novo != $download_link  || $foto_app_novo != $foto_app || $nome_aluno1_novo != $nome_aluno1 || $nome_aluno2_novo != $nome_aluno2 || $nome_aluno3_novo != $nome_aluno3) {*/
                
                $sucesso = $projeto_obj->editar_projeto($id_projeto, $nome_app_novo, $descricao_novo, $foto_app_novo, $download_link_novo, $turma_novo, $nome_aluno1_novo, $nome_aluno2_novo, $nome_aluno3_novo);

            $projeto = $projeto_obj->get_projeto_id($id_projeto);
            //echo "Sucesso: ". $sucesso;
            //} 

        }
        /*else {
            $sucesso = false;
            $mensagem = "Nenhuma alteração identificada!";
            echo "Sucesso: ". $sucesso;
        }*/
    
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

          <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Adiciona o título da página -->
    <title>Editar Projeto</title>

</head>

<body>
    <header>
        <nav id="navbar">
            <button class="button-default" onclick="window.location='apps.php?ano=<?= $ano ?>&periodo=<?= $periodo?>'"
                style="background-color: var(--white); color: var(--blue);">Voltar</button>

            <button id="mobile-button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>

        <div id="mobile-menu">
            <button class="button-default" onclick="window.location='apps.php?ano=<?= $ano ?>&periodo=<?= $periodo?>'">Voltar</button>
        </div>
    </header>

    <div class="container-xxl my-2">
        <div class="row justify-content-center">
            <!-- Card Adicionar -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <img class="card-img-top">
                        <h2 class="card-title text-center">Editar Projeto</h2>

                        <form method="post" action=""
                            enctype="multipart/form-data">
                            <hr class="mt-3 mb-4">
                            <section>
                                <fieldset>
                                <legend>Informações do Projeto</legend>
                                    <!--campo de nome do projeto -->
                                    <div class="form-group">
                                        <label for="nome">Nome </label>
                                        <input type="text" class="form-control" name="nome_app" id="nome_app"
                                            placeholder="Nome do projeto" value="<?= $projeto["nome"]; ?>">
                                        <small class="text-danger">*<?= $nome_app_erro; ?></small>
                                    </div>

                                     <!-- campo de turma -->
                                     <div class="form-group">
                                        <label for="turma">Turma</label>
                                        <select class="form-control" name="turma" id="turma">
                                            <option value="<?= $projeto["turma"]; ?>"><?= $projeto["turma"]; ?></option>
                                            <?php for ($i = 0; $i < count($turmas); $i++): ?>
                                                <?php if ($turmas[$i]['ano'] . "." . $turmas[$i]['periodo'] != $projeto["turma"]): ?>
                                                <option value="<?= $turmas[$i]['ano'] . "." . $turmas[$i]['periodo']; ?>">
                                                    <?= $turmas[$i]['ano'] . "." . $turmas[$i]['periodo']; ?>
                                                </option>
                                                <?php endif; ?>
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
                                            name="descricao"><?= $projeto['descricao'];?></textarea>
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
                                <input type="text" class="form-control" id="download_link" name="download_link" 
                                value="<?= $projeto["download"]; ?>" placeholder="Insira o link" aria-describedby="basic-addon3">
                            </div>
                            <small class="text-danger">*<?= $download_link_erro; ?></small>

                            <!-- UPLOAD FOTO APP --->
                            <br>
                            <div class="form-group">
                                <label for="nome">URL da foto do aplicativo </label>
                                <input type="text" class="form-control" name="foto_app" id="foto_app" value="<?= $projeto['image_app']?>"
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
                                    
                                    <input type="text" class="form-control" name="nome_aluno<?= $i ?>"
                                        id="nome_aluno<?= $i ?>" placeholder="Nome do Aluno <?= $i ?>" value="<?= $projeto['nome_aluno'.$i] ?>">
                                    <?php $nome_aluno_erro = 'nome_aluno' . $i . '_erro' ?>
                
                                </div>
                                <small class="text-danger">*<?= $$nome_aluno_erro; ?></small>
                                <hr class="mt-3 mb-4">
                            <?php endfor; ?>
                            <!-- Fim do for para gerar vários cards de questões -->

                            <!-- Butão de cadastro de formulário -->
                            <!--<button type="submit" name="editar_button" class="button-default">Salvar alterações</button>-->
                            <button type="submit" class="button-default" name="cadastrar" value="Cadastrar">Editar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card ver -->
            <!--<div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <img class="card-img-top">
                        <h2 class="card-title text-center">Pré-Visualização</h2>

                        <form method="post" action="" enctype="multipart/form-data">
                            <hr class="mt-3 mb-4">
                            <section>
                                <fieldset>
                                    <legend >Informações do Projeto</legend>

                                    <label for="nome"><strong> Nome: </strong> //$nome_app; </label>
                                    <br>
                                    <label for="nome"><strong> Turma: </strong>  //$turma; </label>
                                    <br>
                                    <label for="nome"><strong> Descrição: </strong> //$descricao; ?></label>
                                    <br>
                                    <label for="nome" ><strong> Link para Download: </strong>
                                        //$download_link; ?></label>
                                    <br>
                                    <label for="nome" ><strong> Foto APP: </strong>
                                    </label>
                                    <br>
                                    <img src="< //$foto_app; ?>" alt="" id="image-app">
                                    <br>
                                    <hr class="mt-3 mb-4" >
                                    <section>
                                        <fieldset>
                                            <legend>Informações dos desenvolvedores</legend>
                                            
                                            < //for ($i = 1; $i <= QTD_ALUNOS; $i++): ?>
                                                <label for="nome"><strong> Nome do Aluno < $i ?>: </strong>
                                                    < //$nome_aluno = 'nome_aluno' . $i;
                                                    //echo $$nome_aluno; ?></label>
                                                <br>
                                            < // endfor; ?>
                                            
                                            
                                        </fieldset>
                                    </section>
                                </fieldset>
                            </section>
                        </form>
                    </div>
                </div>
            </div>-->
        </div>
    </div>

    <!-- HTML para mostrar popup -->
    <?php if (isset($_POST['cadastrar']) && $sucesso = 1) : ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edição de projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Edição realizada com sucesso!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
            </div>
        </div>
    </div>
</div>

<?php elseif (isset($_POST['cadastrar']) && $sucesso = 0) : ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edição de ator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Erro ao editar projeto!
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
</body>

</html>