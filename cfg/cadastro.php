<?php

require_once 'conexao.php';

$sNome = $_POST['nome'];
$sTelefone = $_POST['telefone'];
$sEmpresa = $_POST['empresa'];
$iTipoCliente = $_POST['tipoCliente'];


if ($sNome != '' && $iTipoCliente != '') {
    $sSql = "INSERT INTO web.tbcliente (clinome, clitelefone, cliempresa, clitipo)
              VALUES ('$sNome', '$sTelefone', '$sEmpresa', '$iTipoCliente')";

    if (pg_query($oConexao, $sSql)) {
        echo true;
    } else {
        echo false;
    }
}