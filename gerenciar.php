    <!DOCTYPE html>
<html lang="pt-BR">
    <?php
    require 'cfg/conexao.php';
    session_start();

    if (isset($_SESSION['login'])) {} else {
        header('location: index.php');
    }
    if(!isset($_GET['idCliente'])){
        header('location: bloq.php');
    }
    
    $iCodigoCliente = $_GET['idCliente'];
    $aDados = array();
    
    //PAGINAÇÃO/////////////////////////////////////
    $iRegistrosPorPagina = 10;
    
    $sSqlTotal = "SELECT COUNT(*) as quantidadeReg
                    FROM web.tbhistoricocliente 
                   WHERE clicodigo = {$iCodigoCliente}";
    if($oResultTotal = pg_query($oConexao, $sSqlTotal)){
        if($oRetornoTotal = pg_fetch_assoc($oResultTotal)){
            $iTotalRegistros = $oRetornoTotal['quantidadereg'];
        }
    }
    
    $iTotalPaginas = ceil(($iTotalRegistros / $iRegistrosPorPagina));
    
    $iPg = 1;
    if(isset($_GET['pag']) && !empty($_GET['pag'])){
        $iPg = $_GET['pag'];
    }
    $iPagina = ($iPg - 1) * $iRegistrosPorPagina;
    //////////////////////////////////////////////////////
    
    $sSql = "SELECT * 
               FROM web.tbhistoricocliente 
              WHERE clicodigo = {$iCodigoCliente} 
           ORDER BY hiscodigo DESC
              LIMIT {$iRegistrosPorPagina} OFFSET {$iPagina}";
    if($oResult = pg_query($oConexao, $sSql)){
        while($oRetorno = pg_fetch_assoc($oResult)){
            $aDados[] = $oRetorno;
        }
    }
    
    $sSqlCliente = "SELECT * FROM web.tbcliente WHERE clicodigo = {$iCodigoCliente}";
    if($oResult = pg_query($oConexao, $sSqlCliente)){
        $aDadosCliente = pg_fetch_assoc($oResult);
    }
    
    include 'cfg/head.html';
    ?>
    <head>
        <link href="est/css/gerenciar.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="direction">
            <h3 class="h3-d">Atualizar Cadastro</h3>
            <form action="cfg/atualizarCliente.php" method="POST">
                <input name="nomeCliente" type="text" value="<?= $aDadosCliente['clinome']?>">
                <input name="telCliente" type="text" maxlength="7" value="<?= $aDadosCliente['clitelefone']?>">
                <input name="empCliente" type="text" value="<?= $aDadosCliente['cliempresa']?>">
                <input type="hidden" name="codigoCli" value="<?= $iCodigoCliente ?>">
                <input class="sair" type="submit" value="Atualizar">
            </form>
        </div>
        <div>
            <h3 class="direction h3-d">Histórico do Cliente - <?= $aDadosCliente['clinome']?></h3>
            <div class="direction limite-historico">
                <a href="inicio.php"><input class="sair" type="button" value="Voltar"></a>
            </div>
            <div class="container">
                <div class="row">
                    <?php 
                        if (count($aDados)){ ?>
                    <table id="tabela-hist" class="table table-bordered table-hover">
                        <tr>
                            <th>Tipo</th>
                            <th>Saldo Anterior</th>
                            <th>Valor Recebido / Retirado</th>
                            <th>Saldo Atual</th>
                            <th>Data</th>
                        </tr>
                        <?php
                            foreach ($aDados as $aLinha){
                                if($aLinha['histtipo'] == 1){
                                    $sTipo = '<tr><td class="entrada success">Entrada</td>';
                                } else if($aLinha['histtipo'] == 2) {
                                    $sTipo = '<tr><td class="saida danger">Saída</td>';
                                } else if($aLinha['histtipo'] == 3){
                                    $sTipo = '<tr><td class="danger">Mensalista</td>';
                                }

                                echo $sTipo;
                                echo "<td>{$aLinha['hissaldoanterior']}</td>";
                                echo "<td>{$aLinha['hisentradasaida']}</td>";
                                echo "<td>{$aLinha['hissaldoatual']}</td>";
                                echo "<td>{$aLinha['hisdataentradasaida']}</td></tr>";
                            }
                        ?>
                    </table>
                </div>
                <ul class="pagination">
                    <?php
                        for($iCont = 0; $iCont < $iTotalPaginas; $iCont++){
                            $iPag = $iCont + 1;
                            $sClassEstilo = "";
                            
                            if($iPg == $iPag){
                                $sClassEstilo = "active";
                            }
                            
                            echo "<li class='page-item {$sClassEstilo}'><a class='page-link' href='./gerenciar.php?idCliente={$iCodigoCliente}&pag={$iPag}'>{$iPag}</a></li>";
                        }

                    ?>
                </ul>
            </div>

            <?php } else { ?>
                        <div class="col-md-offset-4">
                            <h2>Este cliente não possui um histórico</h2>
                        </div>
            <?php } ?>
        </div>
    </body>
</html>