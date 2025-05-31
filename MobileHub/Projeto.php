<?php
class Projeto {
    private $mysql;

    public function __construct(mysqli $mysql) {
        $this -> mysql = $mysql;
    }

    /**
     * Método responsável por retornar elementos do array $projetos.
     * 
     * @return array informações de projetos.
     */
    public function get_projetos(): array {
        $sql = 'SELECT nome, descricao, download, image_app, turma, nome_aluno1, nome_aluno2, nome_aluno3 FROM projetos';
        // consulta que seleciona as colunas da tabela projetos.

        $resultado = $this->mysql->query($sql);
        // a consulta SQL é executada usando o método query de um objeto
        
        $projetos = $resultado->fetch_all(MYSQLI_ASSOC);
        // retorna todas as linhas do resultado como um array associativo, onde cada linha é representada por um array e as chaves correspondem aos nomes das colunas selecionadas.
        
        return $projetos;
    }

    public function insere_projeto($nome, $descricao, $image_app, $download, $turma, $nome_aluno1, $nome_aluno2, $nome_aluno3): void {

        $sql = "INSERT INTO projetos (nome, descricao, image_app, download, turma, nome_aluno1, nome_aluno2, nome_aluno3) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->mysql->prepare($sql);

        // configura parâmetros e executa a query
        $stmt->bind_param("ssssssss", $nome, $descricao, $image_app, $download, $turma, $nome_aluno1, $nome_aluno2, $nome_aluno3); //correspondência dos parâmetros
        $stmt->execute();
    }

    public function verifica_existencia($nome_app, $turma)  {
        $sql = "SELECT nome, turma FROM projetos WHERE nome = ? AND turma = ?";
        // consulta que seleciona as colunas da tabela projetos.

        $stmt = $this->mysql->prepare($sql);
        $stmt->bind_param("ss", $nome_app, $turma); //correspondência dos parâmetros
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->num_rows > 0; // Retorna true se encontrou resultados
    }

    public function get_projetos_por_turma($ano, $periodo): array {
        // Usando a consulta com parâmetro para filtrar por turma
        $sql = 'SELECT * FROM projetos WHERE turma = ?';
        
        // Prepara a consulta
        $stmt = $this->mysql->prepare($sql);

        $turma_query = $ano . '.' . $periodo;
        
        // Vincula o parâmetro 'turma_query' à consulta
        $stmt->bind_param("s", $turma_query); // "s" indica que o parâmetro é uma string
        
        // Executa a consulta
        $stmt->execute();
        
        // Obtém o resultado
        $resultado = $stmt->get_result();
        
        // Retorna as linhas do resultado como um array associativo
        $projetos = $resultado->fetch_all(MYSQLI_ASSOC);
        
        return $projetos;
    }

    public function get_projeto_id($id): array {
        // Usando a consulta com parâmetro para filtrar por turma
        $sql = "SELECT * FROM projetos WHERE id_projeto = $id";
        
        // Prepara a consulta
        //$stmt = $this->mysql->prepare($sql);
        
        // Vincula o parâmetro 'id' à consulta
        //$stmt->bind_param("s", $id); // "s" indica que o parâmetro é uma string
        
        // Executa a consulta
        //$stmt->execute();
        
        // Obtém o resultado
        $resultado = $this->mysql->query($sql);
        
        // Retorna as linhas do resultado como um array associativo
        $projeto = $resultado->fetch_array(MYSQLI_ASSOC);
        
        return $projeto;
    }

    public function apagar_projeto($id_projeto): void {
        $sql = "DELETE FROM projetos WHERE id_projeto = ?";

        $stmt = $this->mysql->prepare($sql);
        // configura parâmetros e executa a query
        $stmt->bind_param("i", $id_projeto); //correspondência dos parâmetros
        $stmt->execute();
        $stmt->close();
        $this->mysql->close();
    }

    public function editar_projeto($id_projeto, $nome, $descricao, $image_app, $download, $turma, $nome_aluno1, $nome_aluno2, $nome_aluno3): bool {
        // Cria a consulta preparada com parâmetros marcados como placeholders (?)
        $sql = "UPDATE projetos SET nome = ?, descricao = ?, image_app = ?, download = ?, turma = ?, nome_aluno1 = ?, nome_aluno2 = ?, nome_aluno3 = ? WHERE id_projeto = ?";
        
        $stmt = $this->mysql->prepare($sql);

        if (!$stmt) {
            return false;
        }
        // configura parâmetros e executa a query
        $stmt->bind_param("ssssssssi",$nome, $descricao, $image_app, $download, $turma, $nome_aluno1, $nome_aluno2, $nome_aluno3, $id_projeto); //correspondência dos parâmetros

        // Executa a consulta preparada
        $status = $stmt->execute();

        // Verifica se o execute() foi bem-sucedido
        if (!$status) {
            return false;
        }

        $stmt->close();
        return true;
    }
}