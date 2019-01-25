<?php

require './conexao.php';

$iCodigoCliente = $_POST['codigoCli'];
$sNomeCliente = $_POST['nomeCliente'];
$sTelefone = $_POST['telCliente'];
$sEmpresa = $_POST['empCliente'];

$sSql = "UPDATE web.tbcliente
            SET clinome='{$sNomeCliente}', clitelefone='{$sTelefone}', cliempresa='{$sEmpresa}'
          WHERE clicodigo = {$iCodigoCliente}";
          
if(pg_query($oConexao, $sSql)){
    ?>
        <script>
            alert('Cliente Atualizado com Sucesso!');
            window.location = ("../gerenciar.php?idCliente=<?=$iCodigoCliente?>");
        </script>
    <?php
}
