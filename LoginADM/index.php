<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Public/Js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="Public/Css/index.css">
    <title>ADM</title>
</head>
<body>
    <?php
        session_start();
        include '../Login/verifica_login.php'
    ?>
    <h2>Sejá bem-vindo, <?php echo $_SESSION['usuarioNomedeUsuario'] , "!"; ?> </h2>
    <button id="log" onclick="logout()"><img class="deslog" src="../LoginADM/Public/Assets/vetor-deslog.png" alt="logout"></button><br>
    <div class="container">
        <a href="livro.php">Livros</a>
        <a href="users.php">Users</a>
        <a href="lista.php">Lista</a>
    </div>
</body>
</html>