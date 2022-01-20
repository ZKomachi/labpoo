<?php
require_once "back/model/Usuario.php";
$nome = isset($_POST['nome']) ? $_POST['nome'] : false;
$email = isset($_POST['email']) ? $_POST['email'] : false;
$senha = isset($_POST['senha']) ? $_POST['senha'] : false;

if($nome && $email && $senha){
$new = new Usuario();
$new->cadastrar($nome, $email, $senha);
}else{
    echo "Sem dados para cadastrar.";
}
header("Location: teste-csrf.php");
exit();