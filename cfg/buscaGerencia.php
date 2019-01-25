<?php

require('conexao.php');

$iCodigoCliente = $_POST['codigo'];

$sSql = 'SELECT * 
           FROM web.tbcliente
          WHERE clicodigo = '. $iCodigoCliente;

$aDados = [];

if($oResultado = pg_query($oConexao, $sSql)) {
    while($oUsuario = pg_fetch_assoc($oResultado)){
        $aDados[] = $oUsuario;
    }
}

echo json_encode($aDados);