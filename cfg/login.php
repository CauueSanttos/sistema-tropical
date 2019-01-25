<?php
session_start();
require('conexao.php');

$sUser  = $_POST['user'];
$sSenha = MD5($_POST['pass']);

$sSql = "SELECT geruser, gerpass
           FROM web.tbgerencia
          WHERE geruser = '$sUser'
            AND gerpass = '$sSenha'";

$oQuery = pg_query($oConexao, $sSql);
$iNumRows = pg_num_rows($oQuery);

if ($iNumRows > 0) {
    $_SESSION['login'] = $sUser;
    header('location: ../inicio.php');
} else {
    ?>
        <script>
            alert('Login ou Senha inválidos');
            window.location = ('../index.php');
        </script>
    <?php
}