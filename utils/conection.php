<?php

// Detalhes da conexão com o MySQL
$host = "127.0.0.1"; // Endereço do servidor MySQL
$port = "3306";      // Porta do MySQL
$dbname = "local";   // Nome do banco de dados
$user = "root";      // Nome de usuário do MySQL
$password = "root";  // Senha do MySQL

// Criando a conexão
$conecta = mysqli_connect($host, $user, $password, $dbname, $port);

// Verificando a conexão
if (!$conecta) {
    die("Não foi possível estabelecer conexão com o banco de dados: " . mysqli_connect_error());
}