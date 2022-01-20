<?php
session_start();
require_once "back/model/Usuario.php";
$meu_usuario = new Usuario();
if ($meu_usuario->verificarLogin()) {
    echo "<h3>Conta logada:</h3><pre>";
    print_r($meu_usuario);
    echo "</pre>";
} else {
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";

    $meu_usuario->login($email, $senha);
    echo "<h3>Conta logada:</h3><pre>";
    print_r($meu_usuario);
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h3>Editar informações: <?php echo $_SESSION['id']; ?></h3>
    <form action="editar.php" method="POST">
        <input type="text" name="nome" value="<?php echo $meu_usuario->getNome(); ?>" /><br />
        <input type="email" name="email" value="<?php echo $meu_usuario->getEmail(); ?>" /><br />
        <input type="password" name="senha" placeholder="Senha" /><br />
        <input type="submit" value="Editar" />
    </form>
    <br />
    <a href="logout.php">Logout</a>
    <a href="teste-csrf.php">Voltar</a>
</body>

</html>