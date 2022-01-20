<?php
class Connect extends PDO
{
    // Atributos:
    private $conn;

    // Métodos especiais:
    public function __construct()
    {
        try {
            $this->setConn(new PDO("mysql:host=localhost;dbname=labpoo", "root", ""));
        } catch (PDOException $e) {
            echo "Error na base de dados: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error generico: " . $e->getMessage();
        }
    }

    public function getConn()
    {
        return $this->conn;
    }

    protected function setConn($conn)
    {
        $this->conn = $conn;
    }

    // Métodos publicos:
    private function setParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    private function setParams($statement, $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    public function newQuery($newQuery, $params = array())
    {
        $stmt = $this->getConn()->prepare($newQuery);
        $this->setParams($stmt, $params);
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return print_r("Error: " . $stmt->errorInfo());
        }
    }

    public function selectQuery($newQuery, $params = array())
    {
        $stmt = $this->newQuery($newQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertQuery($newQuery, $params = array())
    {
        $stmt = $this->newQuery($newQuery, $params);
        return $stmt;
    }
}
