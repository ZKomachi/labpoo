<?php
session_start();
require_once 'back/model/Usuario.php';
$nome = isset($_POST['nome']) ? $_POST['nome'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$senha = isset($_POST['senha']) ? $_POST['senha'] : "";

$u = new Usuario();
$u->verificarLogin();
$atualizar = $u->editarConta($nome, $email, $senha);
if ($atualizar) {
    echo "<h3>Conta atualizada:</h3><pre>";
    print_r($u);
    echo "</pre>";
}else{
    echo "Você precisa estar logado para esta ação.";
}
?>
<br />
<a href="logout.php">Logout</a>
<a href="login.php">Voltar</a>