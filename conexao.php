<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_alunos";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error){
    die("falha na conexão: " . $conexao->connect_error);
}
?>
