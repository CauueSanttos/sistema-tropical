<?php
require './conexao.php';
/**
 * Arquivo que executa o Ajax de Exclusão do Cliente 
 * @author Cauê dos Santos Silva <cauedossantossilva@hotmail.com>
 * @since 16/01/2019
 */

$iCodigoCliente = $_POST['codigoCliente'];
if(isset($iCodigoCliente) && !empty($iCodigoCliente)){
    $sSql = "DELETE FROM web.tbcliente
                   WHERE clicodigo = {$iCodigoCliente}";
                   
    if(pg_query($oConexao, $sSql)){
        echo json_encode(true);
    }
    
}