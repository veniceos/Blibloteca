<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Public/Css/login.css">
    <script src="Public/Js/script.js"></script>
    <title>Login</title>
</head>
<body>
    <header>
    </header>
    <section class="login_section">

        <div class="cad">
            <h2>Login</h2>
            <form action="loginconfig.php" method="POST">
                <input type="text" name="email" placeholder="E-mail ou Nome de Usuário">
                <input type="password" name="senha" placeholder="Senha">
                <div class="button">
                    <button type="submit">Login</button>
            </form>
                    <form action="cadastro.php">
                    <button>Crie sua conta</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
