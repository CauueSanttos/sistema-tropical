<!DOCTYPE html>
<html lang="pt-BR">
    <?php
        include 'cfg/head.html';
    ?>
    <head>
        <link href="est/css/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="background img-responsive">
        <div class="container">
            <form autocomplete="off" class="form-group" method="POST" action="cfg/login.php">
                <h2>Login</h2>
                <label>Usuário: </label>
                <input class="quebraLinha" name="user" type="text" maxlength="12">
                <label>Senha: </label>
                <input class="quebraLinha" name="pass" type="password" maxlength="12">
                <br>
                <input class="btnLogin" type="submit" value="Entrar">
            </form>
        </div>
    </body>
</html>