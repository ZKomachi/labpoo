<?php
session_start();
require_once "back/model/Usuario.php";
$meu_usuario = new Usuario();
if ($meu_usuario->verificarLogin()) {
    $meu_usuario->logout();
}
header("Location: teste-csrf.php");
exit();
