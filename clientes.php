<!DOCTYPE html>
<html lang="pt-BR">
    <?php
    require 'cfg/conexao.php';
    session_start();

    if (isset($_SESSION['login'])) {} else {
        header('location: index.php');
    }
    //PAGINAÇÃO/////////////////////////////////////
    $iRegistrosPorPagina = 10;
    
    $sSqlTotal = "SELECT COUNT(*) as quantidadeReg
                    FROM web.tbcliente";
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
               FROM web.tbcliente 
              LIMIT {$iRegistrosPorPagina} OFFSET {$iPagina}";
    if($oResult = pg_query($oConexao, $sSql)){
        while($oRetorno = pg_fetch_assoc($oResult)){
            $aDados[] = $oRetorno;
        }
    }
    
    include 'cfg/head.html';
    ?>
    <head>
        <style>
            tr td button{
                font-size: 15px !important;
                color: #066600 !important;
            }
        </style>
        <link href="est/css/gerenciar.css" rel="stylesheet" type="text/css"/>
        <script src="est/js/ajaxExcluir.js" type="text/javascript"></script>
    </head>
    <body>
        <div>
            <h3 class="direction h3-d">Clientes</h3>
            <div class="direction limite-historico">
                <a href="inicio.php"><input class="sair" type="button" value="Voltar"></a>
            </div>
            <div class="container">
                <div class="row">
                    <table id="tabela-hist" class="table table-bordered table-hover">
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Telefone</th>
                            <th>Empresa</th>
                            <th>Crédito</th>
                            <th>Mensalista</th>
                            <th>Excluir</th>
                        </tr>
                        <?php
                            foreach ($aDados as $aLinha){
                                $sTipo = $aLinha['clitipo'] == 1 ? 'NORMAL' : 'MENSALISTA';
                                echo "<tr>";
                                  echo "<td>{$aLinha['clinome']}</td>";
                                  echo "<td>{$sTipo}</td>";
                                  echo "<td>{$aLinha['clitelefone']}</td>";
                                  echo "<td>{$aLinha['cliempresa']}</td>";
                                  echo "<td>{$aLinha['clicredito']}</td>";
                                  echo "<td>{$aLinha['climensalista']}</td>";
                                  echo "<td><a><button value='{$aLinha['clicodigo']}' class='glyphicon glyphicon-trash'></button></a></td>";
                                echo "</tr>";
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
                            
                            echo "<li class='page-item {$sClassEstilo}'><a class='page-link' href='./clientes.php?pag={$iPag}'>{$iPag}</a></li>";
                        }

                    ?>
                </ul>
            </div>
        </div>
    </body>
</html>