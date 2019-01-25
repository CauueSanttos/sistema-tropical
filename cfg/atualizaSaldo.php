<?php

require './conexao.php';

//Atualização Saldo//////////////////////////////////////
$iCodigoCliente = $_POST['idCliente'];
$sSaldoAtual = $_POST['saldoAtual'];

$iTipoCliente = $_POST['tipoClienteModal'];
if($iTipoCliente == 1){
    $sSql = "UPDATE web.tbcliente
                SET clicredito={$sSaldoAtual}
              WHERE clicodigo={$iCodigoCliente}";
} else {
    $sSql = "UPDATE web.tbcliente
                SET climensalista={$sSaldoAtual}
              WHERE clicodigo={$iCodigoCliente}";
}


if(isset($iCodigoCliente)){
    if(pg_query($oConexao, $sSql)){
        ?>
            <script>
                alert('Saldo Atualizado com Sucesso!');
                window.location = ('../inicio.php');
            </script>
        <?php
        //Inserindo o Histórico do Cliente/////////////////////
        
        $iTipoHistorico = $_POST['tipoHistorico'];
        $sSaldoAnterior = ($_POST['saldoAnterior'] > 0) ? $_POST['saldoAnterior'] : 0;
        $sDataEntradaSaida = date('d-m-Y');
        
        if($sSaldoAtual > $sSaldoAnterior){
            $sEntradaSaida = $sSaldoAtual - $sSaldoAnterior;
        } else {
            $sEntradaSaida = $sSaldoAnterior - $sSaldoAtual;
        }
        
        $sSqlHistorico = "INSERT INTO web.tbhistoricocliente(clicodigo, histtipo, hissaldoanterior, hissaldoatual, hisentradasaida, hisdataentradasaida)
                               VALUES ({$iCodigoCliente}, {$iTipoHistorico}, {$sSaldoAnterior}, {$sSaldoAtual}, {$sEntradaSaida}, '{$sDataEntradaSaida}')";
                               
        if(pg_query($oConexao, $sSqlHistorico)){

        }
        ////////////////////////////////////////////////////////
    }
}
////////////////////////////////////////////////////////

