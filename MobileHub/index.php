<?php
session_start();
include "./database/config.php";

//inicialização de variáveis
$login_erro = "";
// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula']; //coleta dados da matricuça
    $senha = $_POST['senha']; //coleta senha

    // Prepara a consulta SQL para buscar o administrador pelo número de matrícula
    $sql = "SELECT * FROM admin WHERE matricula = ?";

    // Prepara a declaração
    if ($stmt = $conexao->prepare($sql)) {
        // Liga os parâmetros
        $stmt->bind_param("s", $matricula);

        // Executa a consulta
        $stmt->execute();

        // Obtém o resultado da consulta
        $result = $stmt->get_result();

        // Verifica se encontrou algum administrador com essa matrícula
        if ($result->num_rows > 0) { //número de linhas encontradas não pode ser 0
            // pega o usuário do banco de dados
            $admin = $result->fetch_assoc();

            // Verifica a senha (a senha deve estar armazenada no banco de dados)
            if ($senha === $admin['senha']) {

                // Inicia a sessão do administrador
                $_SESSION['id_admin'] = $admin['id_admin'];
                $_SESSION['nome'] = $admin['nome'];
                $_SESSION['matricula'] = $admin['matricula'];
                $_SESSION['user_type'] = 'admin';

                // Redireciona para a tela inicial do adm
                header("Location: tela_inicial.php");

                // Verificar se o usuário está autenticado como administrador
        
                exit;
            } else {
                $login_erro = "Senha incorreta.";
            }
        } else {
            $login_erro = "Matrícula não encontrada.";
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        $login_erro = "Erro na consulta SQL.";
    }
} else {
    $_SESSION['user_type'] = 'aluno';
}

?>

<!DOCTYPE html>
<html lang="pt/br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Importação CSS-->
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/colors.css">
    <!-- icon -->
    <link rel="icon"href="./img/circulo.png">

    <!--Importação JS-->
    <script src="./javascript/login.js" defer></script>


    <title>Login - Mobile Hub</title>
</head>

<body>
    <main>
        <!--Base-->
        <div class="login-container" id="login-container">
            <!--Base-->
            <div class="form-container">

                <!--Acesso-->
                <div class="form" id="acess">

                    <h2 class="form-title">Entrar</h2>
                    <p class="form-text">Quem está acessando?</p>

                    <div class="acess-buttons">
                        <!--Botão Aluno-->
                        <button class="form-acess-button" id="aluno-button"
                            onclick="window.location='./tela_inicial.php'">
                            <img id="aluno-icon" class="icon-button" src="./img/login/aluno-azul.png" alt="aluno">
                            <!--Link Imagem: https://www.flaticon.com/br/icone-gratis/alunos_7941558?term=aluno&page=1&position=7&origin=search&related_id=7941558-->
                            <p>Aluno</p>
                        </button>

                        <!--Botão Administrador-->
                        <button class="form-acess-button" id="admin-button">
                            <img id="admin-icon" class="icon-button" src="./img/login/professor-azul.png"
                                alt="administrador">
                            <!--Link Imagem: https://www.flaticon.com/br/icone-gratis/professor-no-quadro_65882?term=professor&page=1&position=8&origin=search&related_id=65882-->
                            <p>Administrador</p>
                        </button>
                    </div>
                </div>

                <!--Login (Administrador)-->
                <form action="" method="post" class="form" id="form-login">

                    <h2 class="form-title">Login</h2>
                    <p class="form-text">Insira suas informações.</p>



                    
                    <div class="input-container">
                        <input type="text" name="matricula" class="form-input" placeholder="Matrícula" required>
                        <input type="password" name="senha" class="form-input" placeholder="Senha" required>
                    </div>


                    <button type="submit" class="form-login-button">Logar</button>

                    <p class="form-text"><?= $login_erro ?></p>

                    <p id="mobile-text">
                        Não é um administrador?
                        <a href="#">Voltar</a>
                    </p>
                </form>
            </div>
            <div class="overlay-container">

                <!-- Tela Administrador -->
                <div class="overlay">
                    <h2 class="form-title form-title-white">Olá, Administrador!</h2>
                    <p class="form-text form-text-white">O Mobile Hub possui o objetivo de criar um ambiente dinâmico e colaborativo, onde aplicativos inovadores que contribuem para o aprendizado de seus colegas é essencial para um bom funcionamento.</p>
                    <button class="form-button form-button-white" id="return-button">Voltar</button>
                </div>

                <!-- Tela Boas-Vindas -->
                <div class="overlay">
                    <h2 class="form-title form-title-white">Bem-vindo(a)!</h2>
                    <p class="form-text form-text-white">Aqui será encontrada uma variedade de aplicativos criativos, projetados para tornar o aprendizado mais acessível e divertido. Os desenvolvedores são estudantes, os quais estão comprometidos em criar soluções práticas para superá-los!</p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
