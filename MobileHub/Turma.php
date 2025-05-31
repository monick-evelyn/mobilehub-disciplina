<?php
class Turma {
    private $mysql;

    public function __construct(mysqli $mysql) {
        $this -> mysql = $mysql;
    }

    /**
     * Método responsável por retornar elementos do array $projetos.
     * 
     * @return array informações de projetos.
     */
    public function get_turmas(): array {
        $sql = 'SELECT ano, periodo FROM turma';
        // consulta que seleciona as colunas da tabela projetos.

        $resultado = $this->mysql->query($sql);
        // a consulta SQL é executada usando o método query de um objeto
        
        $turmas = $resultado->fetch_all(MYSQLI_ASSOC);
        // retorna todas as linhas do resultado como um array associativo, onde cada linha é representada por um array e as chaves correspondem aos nomes das colunas selecionadas.
        
        return $turmas;
    }

    public function insere_turma($ano, $periodo): void {
        $sql = "INSERT INTO turma (ano, periodo) VALUES (?,?)";
        $stmt = $this->mysql->prepare($sql);

        // configura parâmetros e executa a query
        $stmt->bind_param("ii", $ano, $periodo); //correspondência dos parâmetros
        $stmt->execute();

        $stmt->close();
        $this->mysql->close();
    }

    public function verifica_existencia($input_turma, $input_periodo)  {
        $sql = "SELECT ano, periodo FROM turma WHERE ano = ? AND periodo = ?";
        // consulta que seleciona as colunas da tabela turma.

        $stmt = $this->mysql->prepare($sql);
        $stmt->bind_param("ii", $input_turma, $input_periodo); //correspondência dos parâmetros
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->num_rows > 0; // Retorna true se encontrou resultados
    }

    public function apagar_turma($ano, $periodo): void {
        $sql = "DELETE FROM turma WHERE ano = ? AND periodo = ?";

        $stmt = $this->mysql->prepare($sql);
        // configura parâmetros e executa a query
        $stmt->bind_param("ii", $ano, $periodo); //correspondência dos parâmetros
        $stmt->execute();

        $stmt->close();
        $this->mysql->close();
    }
}