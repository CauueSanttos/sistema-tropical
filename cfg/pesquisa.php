<?php

require('conexao.php');

$sNomeUsuario = $_POST['nomeUsuario'];

$sSql = "SELECT * 
           FROM web.tbcliente   
          WHERE clinome LIKE '%".$sNomeUsuario."%'
          LIMIT 10";

$aDados = [];

if($oResultado = pg_query($oConexao, $sSql)) {
    while($oUsuario = pg_fetch_assoc($oResultado)){
        $aDados[] = $oUsuario;
    }
}
echo json_encode($aDados);
