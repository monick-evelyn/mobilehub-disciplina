<?php

class Administrador {
    private $mysql;

    public function __construct(mysqli $mysql) {
        $this -> mysql = $mysql;
    }

    /**
     * Método responsável por retornar elementos do array $projetos.
     * 
     * @return array informações de projetos.
     */
    public function get_admins(): array {
        $sql = 'SELECT nome, matricula, senha FROM admin';
        // consulta que seleciona as colunas da tabela projetos.

        $resultado = $this->mysql->query($sql);
        // a consulta SQL é executada usando o método query de um objeto
        
        $admins = $resultado->fetch_all(MYSQLI_ASSOC);
        // retorna todas as linhas do resultado como um array associativo, onde cada linha é representada por um array e as chaves correspondem aos nomes das colunas selecionadas.
        
        return $admins;
    }

    public function get_matriculas(): array {
        $sql = 'SELECT matricula FROM admin';
        // consulta que seleciona o nome da tabela projetos.

        $resultado = $this->mysql->query($sql);
        // a consulta SQL é executada usando o método query de um objeto
        
        $matriculas = $resultado->fetch_all(MYSQLI_ASSOC);
        // retorna todas as linhas do resultado como um array associativo, onde cada linha é representada por um array e as chaves correspondem aos nomes das colunas selecionadas.
        
        return $matriculas;
    }
}
