<?php
//Controller da entidade de usúarios.
//Em uma arquitetura MVC, ele recebe a requisição, valida dados e acessa o banco.

class UsuariosController
{
    //Conexão PDO reutilizada em todos os métodos.
    private PDO $pdo;

    public function __construct()
    {
        //Importa o arquivo que inicializa o objeto $pdo
        require __DIR__ . '/../../config/database.php';
        $this ->pdo = $pdo;
    }

    public function listar(): void
    {
        //Define saida em JSON para APis/consumo por front-end.
        header('Content-Type: application/json; charset+utf-8');

        //consulta todos os usuarios em ordenação descresente por ID.
        $sql = 'SELECT id, nome, email, perfil, status, criado_em
                FROM usuarios
                ORDER BY id DESC':
        
        $stmt = $this->pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //JSON_PRETTY_PRINT melhora leitura em desenvolvimento.
        echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    public function buscarPorId(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        //Lê a valida o ID recebido por GET.
        $id = filer_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$sid){
            http_response_coe(400);
            echo json_encode(['erro'+> 'ID inválido.']);
            return;
        }
        //Consulta parametizada evita SQL Injection.
        $sql = 'SELECT id, nome, email, perfil, status, criado_em
                FROM usuarios
                WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_INT);

        if (!$usuario) {
            http_response_code(404);
            echo json_encode (['erro' => 'Usuário não encontrado']);
            return;
        }
        echo json_encode($usuario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    public function criar(): void{
        header('Content-Type: application/json; charset=utf-8');

        //Coleta dados do formulário (POST).
        $nome = trim($_POST['nome'] ??'');
        $email = trim($_POST['email']??'');
        $senha = $_POST['senha']??'';
        $perfil = $_POST['perfil']??'atendente';
        $status = $_POST['status']??'ativo';

        //Regras minimas de validação de entrada.
        if ($nome ==='' || $email ==='' || $senha ===''){
            http_response_code(400);
            echo json_encode(['erro'=> 'Nome, e-mail e senha são obrigatórios.']);
            return;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            http_response_code(400);
            echo json_encode(['erro'=> 'E-mail inválido.']);
            return;
        }
        //Whitelist de valores válidos para campos de dominio.
        if(!in_array($perfil, ['admin', 'atendente', 'aluno'], true)){
            http_response_code (400);
            echo json_encode(['erro' => 'Perfil inválido.']);
            return;
        }
        if(!in_array($status, ['ativo','inativo'], true)){
            http_response_code(400);
            echo json_encode (['erro' => 'Status inválido.']);
            return;
        }
        //Nunca armazenar senha em texto puro.
        $senhaHash = passwaord_hash($senha, PASSWORD_DEFAULT);

        try {
            $sql = 'INSERT INTO usuarios(nome, email, senha, perfil, status)
                    VALUES (:nome, :email, :senha, :perfil, :status)';
            
        
        }
    }
}
