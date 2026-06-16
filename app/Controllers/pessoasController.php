<?php

class PessoasController{

    private PDO $pdo;

   public function __construct(){

       require __DIR__ . '../../config/database.php';
       $this->pdo = $pdo;
   }

   public function listar(): void{

    header('Content-type: application/json; charset=utf-8');

    $sql = 'SELECT id_pessoas, nome, documento, telefone, curso, periodo, status
            FROM pessoas
            ORDER BY id_pessoas DESC';

    $stmt = $this->pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    }

    public function buscarPorId(): void {

        header('Content-type: aplicattions/json; charset=utf-8');

        $id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error'=> 'ID inválido']);
            return;
        }

        $sql = 'SELECT id_pessoas, nome, documento, telefone, curso, periodo, status
            FROM pessoas
            WHERE id_pessoas = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $pessoas = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pessoas) {

            http_response_code(404);
            echo json_encode(['error'=> 'Pessoa não encontrada']);
            return;
        }

        echo json_encode($pessoas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function criar(): void {
        
        header('Content-Type: application/json; charset=utf-8');

        $nome = trim($_POST['nome'] ?? '');
        $documento = trim($_POST['documento'] ??'');
        $telefone = trim($_POST['telefone'] ?? '');
        $curso = $_POST['curso'] ?? '';
        $periodo = $_POST['periodo'] ?? '';
        $status = $_POST['status'] ?? 'ativo';

        if ($nome ==='' || $documento === '' || $curso === '' || $periodo === '') {

            http_response_code(400);
            echo json_encode(['erro' => 'Nome, documento, curso e periodo são obrigatórios']);
            return;
        }
        
        if (!in_array($status, ['ativo', 'inativo'], true)) {

            http_response_code(400);
            echo json_encode(['erro' => 'Status inválido.']);
            return;
        }

        try {

            $sql = 'INSERT INTO usuarios (nome, documento, telefone, curso, periodo status)
                    VALUES (:nome, :documento, :telefone, :curso, :periodo, :status)';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':documento', $documento);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':curso', $curso);
            $stmt->bindValue('periodo', $periodo);
            $stmt->bindValue(':status', $status);
            $stmt->execute();
            

            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Usuário cadastrado com sucesso.',
                'id' => $this->pdo->lastInsertId()
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {

            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastar usuário.']);
        }
    }

}