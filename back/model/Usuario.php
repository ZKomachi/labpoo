<?php
require_once "connect.php";

class Usuario
{
    // Atributos:
    private $id;
    private $nome;
    private $email;
    private $senha;

    // Métodos especiais:
    public function __construct($nome = "", $email = "", $senha = "", $id = "")
    {
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
    }

    protected function getId()
    {
        return $this->id;
    }

    private function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    private function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    private function setEmail($email)
    {
        $this->email = $email;
    }

    private function getSenha()
    {
        return $this->senha;
    }

    private function setSenha($senha)
    {
        $this->senha = $senha;
    }

    // Métodos publicos:
    public function login($email, $senha)
    {
        $pdo = new Connect();
        $result = $pdo->selectQuery("SELECT * FROM usuarios WHERE usuario = :u AND senha = :s", array(":u" => $email, ":s" => $senha));
        if ($result) {
            $this->setId($result[0]['id']);
            $this->setNome($result[0]['nome']);
            $this->setEmail($result[0]['usuario']);
            $this->setSenha($result[0]['senha']);

            $_SESSION['id'] = $result[0]['id'];
            $_SESSION['nome'] = $result[0]['nome'];
            $_SESSION['email'] = $result[0]['usuario'];
            $_SESSION['senha'] = $result[0]['senha'];

            return $result;
        } else {
            return "Não existe essa conta.";
        }
    }

    public function search($email)
    {
        $pdo = new Connect();
        $result = $pdo->selectQuery("SELECT * FROM usuarios WHERE usuario = :u", array(":u" => $email));
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function cadastrar($nome, $email, $senha)
    {
        $pdo = new Connect();
        //Primeiro verifica que nao existe email na tabela:
        $verifica = $this->search($email);
        if (!$verifica) {
            $result = $pdo->insertQuery("INSERT INTO usuarios(nome, usuario, senha) VALUES (:n, :u, :s)", array(":n" => $nome, ":u" => $email, ":s" => $senha));
            return "Conta cadastrada.";
        } else {
            echo "Essa conta já existe.";
        }
    }

    public function todosUsuarios()
    {
        $pdo = new Connect();
        $result = $pdo->selectQuery("SELECT * FROM usuarios");
        if ($result) {
            return $result;
        } else {
            return "Não tem usuarios cadastrados.";
        }
    }

    public function logout()
    {
        $this->setId("");
        $this->setNome("");
        $this->setEmail("");
        $this->setSenha("");

        session_unset('id');
        session_unset('nome');
        session_unset('email');
        session_unset('senha');
        session_destroy();
    }

    public function editarConta($nome, $email, $senha)
    {
        $pdo = new Connect();
        if ($this->getId()) {
            $id = $this->getId();
            $result = $pdo->selectQuery("UPDATE usuarios SET nome=:n, usuario=:u, senha=:s WHERE id = :i", array(":n" => $nome, ":u" => $email, ":s" => $senha, ":i" => $id));
            //Atualizar dados da conta:
            $this->setNome($nome);
            $this->setEmail($email);
            $this->setSenha($senha);
            //Atualizar session:
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            return true;
        } else {
            echo false;
        }
    }

    public function verificarLogin()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : false;
        $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : false;
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : false;
        $senha = isset($_SESSION['senha']) ? $_SESSION['senha'] : false;
        if ($id && $nome && $email && $senha) {
            // Se tudo estiver preenchido, verifica que tudo é igual a db:
            $pdo = new Connect();
            $result = $pdo->selectQuery("SELECT * FROM usuarios WHERE id = :i AND nome = :n AND usuario = :u AND senha = :s", array(":i" => $id, ":n" => $nome, ":u" => $email, ":s" => $senha));
            if ($result) {
                $this->setId($id);
                $this->setNome($nome);
                $this->setEmail($email);
                $this->setSenha($senha);
                return true;
            } else {
                return false;
            }
        } else {
            // Não tem conta na session
            return false;
        }
    }
}
