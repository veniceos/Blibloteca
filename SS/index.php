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
    <link rel="stylesheet" href="Public/Css/index.css">
    <link rel="stylesheet" href="Public/Css/cab-rod.css">
    <title>Página Inicial</title>
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
        <div class="text-tuto">
            <div class="text-i">
            <h3>Bem-vindo à Biblioteca Online!</h3><br>

            Sua biblioteca local agora está acessível a qualquer momento, em qualquer lugar. Em nosso site, você pode explorar nossa extensa coleção de livros, revistas e recursos multimídia. Embora sejamos uma biblioteca física, facilitamos o acesso aos nossos tesouros literários por meio de empréstimos online.<br><br>

            <h3>Como funciona:</h3><br>

            1. <strong>Explore a Coleção:</strong> Navegue por nossas prateleiras virtuais para descobrir os mais recentes lançamentos, clássicos atemporais e uma variedade de gêneros para todas as idades.<br>

            2. <strong>Faça Login:</strong> Para começar a desfrutar dos benefícios do empréstimo online, faça login em sua conta. Se ainda não tiver uma, é fácil criar uma!<br>

            3. <strong>Escolha Seu Livro:</strong> Selecione os itens que deseja emprestar. Você pode filtrar por autor, gênero ou simplesmente explorar nossas seleções em destaque.<br>

            4. <strong>Empréstimo Simples:</strong> Faça o check-out dos itens desejados com apenas alguns cliques. Escolha a duração do empréstimo de acordo com sua preferência.<br>

            5. <strong>Retire na Biblioteca:</strong> Uma vez que seu pedido estiver pronto, visite nossa biblioteca para retirar fisicamente os materiais. Nossa equipe estará pronta para ajudar!<br>

            6. <strong>Retorno Fácil:</strong> Ao término do empréstimo, devolva os itens na biblioteca física ou, se preferir, utilize nosso serviço de devolução online.<br><br>

            <strong>Explore, leia e mergulhe em mundos imaginários sem sair do conforto de sua casa. A Biblioteca [Nome da Biblioteca] Online está aqui para tornar sua experiência de leitura ainda mais conveniente e acessível. Estamos ansiosos para acompanhá-lo em sua jornada literária!</strong>
            </div>
            <div id="Tutorial" class="tuto">
                <h3>Tutorial: Como Usar o Site da "Blibloteca" para Emprestar Livros</h3><br><br>

                <h3>Passo 1: Faça Cadastro</h3><br>
                
                1. Clique no botão "Cadastre-se" ou "Criar Conta".<br>
                2. Preencha o formulário de cadastro com suas informações pessoais.<br>
                3. Crie um nome de usuário e senha seguros.<br>
                4. Aceite os termos e condições, se aplicável.<br>
                5. Clique em "Registrar" para concluir o cadastro.<br><br>

                <h3>Passo 1: Faça Login</h3><br>

                1. Volte à página inicial e clique em "Login" ou "Entrar".<br>
                2. Insira seu nome de usuário e senha nos campos correspondentes.<br>
                3. Clique em "Entrar" para acessar sua conta.<br><br>

                <h3>Passo 2: Explore a Coleção</h3><br>

                1. Na página inicial, navegue pelas categorias ou use a barra de pesquisa para encontrar livros específicos.<br>
                2. Clique sobre um livro para obter mais informações, como sinopse, autor e disponibilidade.<br>
                3. Use filtros para refinar sua busca por gênero, autor ou outras categorias.<br><br>

                <h3>Passo 3: Empreste</h3><br>

                1. Ao encontrar o livro desejado, clique em "Emprestar" ou "Adicionar ao Carrinho".<br>
                2. Selecione a duração do empréstimo desejada (por exemplo, 14 dias).<br>
                3. Confirme seu pedido e clique em "Finalizar Empréstimo" ou similar.<br><br>

                <h3>Passo 4: Retire na Biblioteca</h3><br>

                1. Aguarde a confirmação do seu pedido.<br>
                2. Vá até a biblioteca física dentro do prazo especificado.<br>
                3. Apresente sua identificação e comprovante de empréstimo no balcão de atendimento.<br>
                4. Retire o livro emprestado e aproveite!<br><br>

                <h3>Passo 5: Aproveite</h3><br>

                1. Desfrute da leitura do seu livro emprestado.<br>
                2. Lembre-se da data de devolução para evitar multas.<br>
                3. Quando terminar, devolva o livro pessoalmente na biblioteca ou, se disponível, utilize o serviço de devolução online.<br><br>
                
                <h3>Parabéns! Você agora está pronto para explorar, emprestar e aproveitar a "Blibloteca" de maneira conveniente e eficiente. Se tiver alguma dúvida, não hesite em contatar o suporte no site. Feliz leitura!</h3>
            </div>
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
                        <a class="nav_rod-link" href="#Tutorial">Tutorial</a>
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