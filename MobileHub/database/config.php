<?php 
$nome_servidor = 'localhost';
$nome_usuario = 'root';
$senha = '';
$nome_db = 'mobile_hub_db';

// Cria uma conexão com o BD
$conexao = mysqli_connect($nome_servidor, $nome_usuario, $senha, $nome_db);

// Configura o charset do BD
$conexao->set_charset('utf8');
