<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test CSRF</title>
</head>

<body>
    <?php
    require_once "back/model/Usuario.php";
    $meu_usuario = new Usuario();
    if ($meu_usuario->verificarLogin()) {
        echo "<h3>Conta logada:</h3><pre>";
        print_r($meu_usuario);
        echo "</pre>";
    }else{
        echo "Nenhum usuario logado.";
    }
    ?>
    <h3>Usuarios cadastrados até agora:</h3>
    <pre>
        <?php
        $u = new Usuario();
        $lista_cadastro = $u->todosUsuarios();
        for ($i = 0; $i < count($lista_cadastro); $i++) {
            print_r($lista_cadastro[$i]);
        }
        ?>
    </pre>
    <h3>LOGIN</h3>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" /><br />
        <input type="password" name="senha" placeholder="Senha" ;><br />
        <input type="submit" value="Login" />
    </form>

    <h3>Search:</h3>
    <form action="search.php" method="GET">
        <input type="email" name="email" placeholder="Email" />
        <input type="submit" value="Search user" />
    </form>

    <h3>Cadastrar:</h3>
    <form action="cadastrar.php" method="POST">
        <input type="text" name="nome" placeholder="nome" /><br />
        <input type="email" name="email" placeholder="Email" /><br />
        <input type="password" name="senha" placeholder="Senha" /><br />
        <input type="submit" value="Cadastrar" />
    </form>
</body>

</html>