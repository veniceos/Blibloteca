<?php
require_once 'App\Model\model.php';


class UserController {
    private $userModel;

    public function __construct($pdo) {

        $this->userModel = new UserModel($pdo);
    }

    public function criarUser($nome, $email, $senha, $tipo_usuario) {
        $this->userModel->criarUser($nome, $email, $senha, $tipo_usuario);
    }

    public function listarUsers() {
        return $this->userModel->listarUsers();
    }

    public function exibirListaUsers() {
        $users = $this->userModel->listarUsers();
        include 'App/View/Usuarios/lista.php';
    }

    public function atualizarUser($id, $nome, $email, $senha, $tipo_usuario) {
        $this->userModel->atualizarUser($id, $nome, $email, $senha, $tipo_usuario);
    }
    
    public function excluirUser ($id) {
        $this->userModel->excluirUser($id);
    }
}

class LivroController {
    private $livroModel;

    public function __construct($pdo) {
        $this->livroModel = new LivroModel($pdo);
    }

    public function criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id) {
        $this->livroModel->criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id);
    }

    public function listarLivros() {
        return $this->livroModel->listarLivros();
    }

    public function exibirListaLivros() {
        $livros = $this->livroModel->listarLivros();
        include 'App/View/Livros/lista.php';
    }

    public function atualizarlivros($livro_id, $nome, $categoria, $quantidade, $categoria_id) {
        $this->livroModel->atualizarlivros($livro_id, $nome, $categoria, $quantidade, $categoria_id);
    }

    public function excluirLivros($livro_id) {
        $this->livroModel->excluirLivros($livro_id);
    }
}

class EmprestimoController {
    private $emprestimoModel;

    public function __construct($pdo) {
        $this->emprestimoModel = new EmprestimoModel($pdo);
    }

    public function emprestarLivro($livroID, $livroNome, $usuarioNome) {
        if ($this->emprestimoModel->emprestarLivro($livroID, $livroNome, $usuarioNome)) {
            header('Location: book.php');
            exit();
        } else {
            echo "Não foi possível realizar o empréstimo.";
        }
    }

    public function devolverLivro($livroID) {
        if ($this->emprestimoModel->devolverLivro($livroID)) {
            header('Location: book.php');
            exit();
        } else {
            echo "Não foi possível realizar a devolução.";
        }
    }
    public function listarLivrosEmprestados($usuarioNome) {
        return $this->emprestimoModel->listarLivrosEmprestados($usuarioNome);
    }
    public function listarHistorico() {
        return $this->emprestimoModel->listarHistorico();
    }
    
}
?>