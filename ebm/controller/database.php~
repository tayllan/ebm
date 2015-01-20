<?php

class Conexao {

    private $conexao;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=ebm';
        try {
            $this->conexao = new PDO(
                $dsn,
                'root',
                'tolkien'
            );
            $this->conexao->query("SET CHARSET 'utf8'");
        }
        catch (PDOException $exception) {
            echo 'Erro na hora de conectar no banco!';
        }
    }

    public function getConexao() {
        return $this->conexao;
    }

}

abstract class DAO {

    protected $conexao;

    public function __construct() {
        $obj = new Conexao();

        $this->conexao = $obj->getConexao();
    }

}
