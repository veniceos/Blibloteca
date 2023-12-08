<div class="no-view">
    <?php
    session_start(); // Inicie a sessão no início do arquivo

    require_once '../Config/config.php';
    require_once 'App/Controller/UserController.php';

    $userController = new UserController($pdo);

    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
        $userController->criarUser($_POST['nome'], $_POST['email'], $_POST['senha']);
        header('Location: cadastro.php'); // Redirecione para a página de cadastro
        exit();
    }
    ?>
</div>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Public/Css/cadastro.css">
    <script src="Public/Js/script.js"></script>
    <title>Cadastro</title>
</head>
<body>
    <div class="no-view">

    </div>
    <section>
        <div class="cad">
            <h2>Cadastre-se</h2>
            <form method="post">
                <input type="text" name="nome" placeholder="Nome Usuário" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <div class="button">
                    <button type="submit">Criar</button>
                </form>
                    <form action="login.php">
                        <button>Entre</button>
                </form>
            </div>
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo '<div class="alert"><p>' . $_SESSION['mensagem'] . '</p></div>';
            unset($_SESSION['mensagem']);
        }
        ?>
    </div>    
    </section>
</body>
</html>