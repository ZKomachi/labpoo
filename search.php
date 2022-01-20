<?php
session_start();
require_once "back/model/Usuario.php";
$meu_usuario = new Usuario();
if ($meu_usuario->verificarLogin()) {
    echo "<h3>Conta logada:</h3><pre>";
    print_r($meu_usuario);
    echo "</pre>";
}

$email = isset($_GET['email']) ? $_GET['email'] : "";
$u_search = new Usuario();
$procura = $u_search->search($email);
if ($procura) {
    echo "<h3>Conta procurada: $email</h3><pre>";
    print_r($procura[0]);
    echo "</pre>";
} else {
    echo "Não existe a conta: " . $email;
}
?>
<br />
<a href="teste-csrf.php">Voltar</a>