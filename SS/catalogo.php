<div class="no-view">
    <?php
    require_once '../Config/config.php';
    require_once 'App/Controller/controller.php';

    session_start();

    $livroController = new LivroController($pdo);
    $emprestimoController = new EmprestimoController($pdo);

    $livros = $livroController->listarLivros();

    $livrosPorCategoria = [];
    foreach ($livros as $livro) {
        $categoria = $livro['categoria'];
        if (!isset($livrosPorCategoria[$categoria])) {
            $livrosPorCategoria[$categoria] = [];
        }
        $livrosPorCategoria[$categoria][] = $livro;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emprestar'])) {
        $livroID = $_POST['livro_id'];
        $livroNome = $_POST['nome'];
        $usuarioNome = $_SESSION['usuarioNomedeUsuario'];

        $emprestimoController->emprestarLivro($livroID, $livroNome, $usuarioNome);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
        $livroID = $_POST['livro_id'];

        $emprestimoController->devolverLivro($livroID);
    }

    ?>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="Public/Js/script.js"></script>
    <link rel="stylesheet" href="Public/Css/catalogo.css">
    <link rel="stylesheet" href="Public/Css/cab-rod.css">
    <title>Catálogo</title>
</head>
<body>
    <div class="grid">
    <header>
        <nav>
            <div class="logo">
                <img src="../SS/Public/Assets/vetor-livro.png" alt="logo">
            </div>
            <ul class="nav-menu">
                <li class="nav-button"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-button"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
            </ul>
            <div class="user-icon" id="user-icon" onclick="showUserInfo()">
                <img class="img-perfil" src="../SS/Public/Assets/vetor-perfil.png" alt="Perfil">
            </div>
            <div class="user-info" id="user-info">
                <?php
                    include '../Login/verifica_login.php'
                ?>
                <h4>Olá <?php echo $_SESSION['usuarioNomedeUsuario'] , "!"; ?> </h4>
                <h4>Livros Emprestados</h4><br>
                    <ul>
                        <?php $livrosEmprestados = $emprestimoController->listarLivrosEmprestados($_SESSION['usuarioNomedeUsuario']); ?>
                        <?php foreach ($livrosEmprestados as $emprestimo): ?>
                            <li>
                                <?php echo "<strong>ID do Livro: </strong>" . $emprestimo['livro_emprestimo']; ?> <br>
                                <?php echo "<strong>Livro: </strong>" . $emprestimo['nome_livro']; ?> <br>
                                <?php echo "<strong>Nome do Usuário: </strong>" . $emprestimo['aluno_emprestimo']; ?>
                                <form method="post" action="catalogo.php">
                                    <input type="hidden" name="livro_id" value="<?php echo $emprestimo['emprestimo_id']; ?>">
                                    <button type="submit" name="devolver">Devolver</button><br>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <button id="log" onclick="logout()"><img class="deslog" src="../SS/Public/Assets/vetor-deslog.png" alt="deslog"></button>
            </div>
        </nav>
    </header>
    <section>
        <div class="catalogo">
            <h2>Nosso Catálogo:</h2>
            <?php foreach ($livrosPorCategoria as $categoria => $livrosNaCategoria): ?>
                <div class="categoria" id="<?php echo $categoria; ?>">
                   <div class="categoria-ttl"><?php echo $categoria; ?></div>
                   <div class="livros">
                    <ul>
                        <?php foreach ($livrosNaCategoria as $livro): ?>
                            <li>
                                <div class="livro-container">
                                    <?php
                                    if (!empty($livro['imagem'])) {
                                        echo '<img src="' . $livro['imagem'] . '" alt="Imagem do Livro">';
                                    } else {
                                        echo 'Sem Imagem';
                                    }
                                    ?>
                                    <?php echo $livro['nome']; ?><br>
                                    <strong><?php echo $livro['quantidade']; ?> Livro(s)</strong> Disponíveis
                                    <form method="post" action="catalogo.php">
                                        <input type="hidden" name="livro_id" value="<?php echo $livro['livro_id']; ?>">
                                        <input type="hidden" name="nome" value="<?php echo $livro['nome']; ?>">
                                        <button type="submit" name="emprestar">Emprestar</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                </div>
            <?php endforeach; ?>
            
        </div>
    </section>
    <footer>
        <div class="redes-nav">
                <div class="redes-sociais">
                    <div class="redes-t">Redes Sociais</div>

                    <div class="redes-columns">

                    <div class="redes-column">
                        <a href="https://www.whatsapp.com"><img class="redes-button" src="../SS/Public/Assets/vetor-zap.png" alt="Whatsapp"></a>
                    </div>

                    <div class="redes-column">
                        <a href="https://instagram.com"><img class="redes-button" src="../SS/Public/Assets/vetor-insta.avif" alt="Instagram"></a>
                    </div>
                            
                     <div class="redes-column">
                        <a href="https://twitter.com"><img class="redes-button" src="../SS/Public/Assets/vetor-twitter.png" alt="Twitter"></a>
                    </div>

                    <div class="redes-column">
                        <a href="https://gmail.com"><img class="redes-button" src="../SS/Public/Assets/vetor-gmail.png" alt="Gmail"></a>
                    </div>

                    </div>
                </div>

                <div class="nav_rod">
                    <div class="nav_rod-ttl">
                        Navegue em nossas páginas:
                    </div>
                    <div class="nav_rod-columns">

                        <div class="nav_rod-column">
                            <a class="nav_rod-t" href="index.php">Página Inicial</a>
                            <a class="nav_rod-link" href="index.php#Tutorial">Tutorial</a>
                        </div>

                        <div class="nav_rod-column">
                            <a class="nav_rod-t" href="catalogo.php">Catálogo</a>
                            <?php foreach ($livrosPorCategoria as $categoria => $livrosNaCategoria): ?>
                            <?php echo '<a class="nav_rod-link" href="catalogo.php#' . $categoria . '">' . $categoria . '</a>'; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
