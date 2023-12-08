<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Model para criar Users
    public function criarUser($nome, $email, $senha, $tipo_usuario) {
        $sql = "INSERT INTO users (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha, $tipo_usuario]);
    }

    // Model para listar Users
    public function listarUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Model para atualizar Users
    public function atualizarUser($id, $nome, $email, $senha, $tipo_usuario){
        $sql = "UPDATE users SET nome = ?, email = ?, senha = ?, tipo_usuario = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha, $tipo_usuario, $id]);
    }
    
    // Model para deletar User
    public function excluirUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
    
}

class LivroModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Model para criar Livros
    public function criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id) {
        $sql = "INSERT INTO livros (nome, categoria, quantidade, imagem, categoria_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $categoria, $quantidade, $imagem, $categoria_id]);
    }

    // Model para listar Livros
    public function listarLivros() {
        $sql = "SELECT L.*, CL.nome AS categoria_nome FROM livros L 
                INNER JOIN categoria_livros CL ON L.categoria_id = CL.id 
                ORDER BY CL.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarlivros($livro_id, $nome, $categoria, $quantidade, $categoria_id) {
        $sql = "UPDATE livros SET nome = ?, categoria = ?, quantidade = ?, categoria_id = ? WHERE livro_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $categoria, $quantidade, $categoria_id, $livro_id]);
    }

    public function excluirLivros($livro_id) {
        $sql = "DELETE FROM livros WHERE livro_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$livro_id]);
    }
}

class EmprestimoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function emprestarLivro($livroID, $livroNome, $usuarioNome) {
        $consultaLivro = $this->pdo->prepare("SELECT quantidade FROM livros WHERE livroID = ?");
        $consultaLivro->execute([$livroID]);
        $livro = $consultaLivro->fetch(PDO::FETCH_ASSOC);

        if ($livro && $livro['quantidade'] > 0) {
            $novaQuantidade = $livro['quantidade'] - 1;
            $this->atualizarQuantidade($livroID, $novaQuantidade);

            $inserirEmprestimo = $this->pdo->prepare("INSERT INTO emprestimos (livro_emprestimo, nome_livro, aluno_emprestimo, data_emprestimo) VALUES (?, ?, ?, NOW())");
            $inserirEmprestimo->execute([$livroID, $livroNome, $usuarioNome]);

            return true;
        }

        return false;
    }

    public function devolverLivro($emprestimoID) {
        $consultaEmprestimo = $this->pdo->prepare("SELECT livro_emprestimo, nome_livro, aluno_emprestimo FROM emprestimos WHERE emprestimo_id = ?");
        $consultaEmprestimo->execute([$emprestimoID]);
        $emprestimo = $consultaEmprestimo->fetch(PDO::FETCH_ASSOC);

        if ($emprestimo) {
            $livroID = $emprestimo['livro_emprestimo'];
            $livroNome = $emprestimo['nome_livro'];
            $usuarioNome = $emprestimo['aluno_emprestimo'];

            $consultaLivro = $this->pdo->prepare("SELECT quantidade FROM livros WHERE livroID = ?");
            $consultaLivro->execute([$livroID]);
            $livro = $consultaLivro->fetch(PDO::FETCH_ASSOC);

            if ($livro) {
                $novaQuantidade = $livro['quantidade'] + 1;
                $this->atualizarQuantidade($livroID, $novaQuantidade);

                // Adicionar o código para inserir no histórico
                $this->registrarHistorico($emprestimoID, $livroID, $livroNome, $usuarioNome);

                // Remover o empréstimo da tabela emprestimos
                $excluirEmprestimo = $this->pdo->prepare("DELETE FROM emprestimos WHERE emprestimo_id = ?");
                $excluirEmprestimo->execute([$emprestimoID]);

                return true;
            }
        }

        return false;
    }

    private function atualizarQuantidade($livroID, $novaQuantidade) {
        $atualizarQuantidade = $this->pdo->prepare("UPDATE livros SET quantidade = ? WHERE livroID = ?");
        $atualizarQuantidade->execute([$novaQuantidade, $livroID]);
    }
    public function listarLivrosEmprestados($usuarioNome) {
        $consultaLivrosEmprestados = $this->pdo->prepare("SELECT * FROM emprestimos WHERE aluno_emprestimo = ?");
        $consultaLivrosEmprestados->execute([$usuarioNome]);
    
        return $consultaLivrosEmprestados->fetchAll(PDO::FETCH_ASSOC);
    }
    private function registrarHistorico($emprestimoID, $livroID, $nomeLivro, $nomeUsuario) {
        $inserirHistorico = $this->pdo->prepare("INSERT INTO historico (emprestimo_id, livroID, nome_livro, nome_aluno) VALUES (?, ?, ?, ?)");
        $inserirHistorico->execute([$emprestimoID, $livroID, $nomeLivro, $nomeUsuario]);
        $dataRegistrada = $this->pdo->query("SELECT hora FROM historico WHERE emprestimo_id = $emprestimoID")->fetchColumn();
    }  
    public function listarHistorico() {
        $sql = "SELECT * FROM historico";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>