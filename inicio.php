<!DOCTYPE html>
<html lang="pt-BR">
    <?php
    session_start();

    if (isset($_SESSION['login'])) {
        
    } else {
        header('location: index.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        header('location: index.php');
    }
    
    include 'cfg/head.html';
    ?>
    <head>
        <script src="est/js/atualizarCliente.js" type="text/javascript"></script>
    </head>
    <body class="background img-responsive">
        <div class="container divInicial">   
            <!--Busca-->
            <form autocomplete="off" id="login" class="form-group" method="POST" action="">
                <h2 id="titulo">Tropical Gourmet</h2>
                <label>Nome do Cliente: </label>
                <input name="pesquisaCliente" type="text" maxlength="40" size="60">
                <button id="pesquisaCliente" type="submit">Buscar</button> 
            </form>

            <!--Pesquisa-->
            <div id="pesquisa">
                <table class="table table-bordered center">
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Empresa</th>
                        <th>Tipo</th>
                        <th>Crédito</th>
                        <th>Mensalista</th>
                        <th>Gerenciar</th>
                    </tr>
                    <tbody id="retornoPesquisa"></tbody>
                </table>
            </div>

            <!--Cadastro-->
            <form autocomplete="off" id="cadastro" class="form-group" method="POST" ajax="true">
                <h2 id="titulo">Cadastro</h2>
                <label class="quebraLinha">Nome Completo:</label>
                <input type="text" name="nome" maxlength="40">
                <label class="quebraLinha">Telefone:</label>
                <input type="text" name="telefone" maxlength="15">
                <label class="quebraLinha">Empresa:</label>
                <input type="text" name="empresa" maxlength="40"> 
                <label class="quebraLinha">Tipo do Cliente:</label>
                <select name="tipoCliente">
                    <option value="1">Normal</option>
                    <option value="2">Mensalista</option>
                </select>
                <br>
                <button id="efetuar" class="btnCad">Cadastrar</button> 
            </form>
            <a href="clientes.php"><button class="sair" type="button">Clientes</button></a>
            <button type="button" id="show">Consultar</button>
            <button type="button" id="hide">Cadastrar</button>
            <a href="?logout"><button class="sair" type="button">Sair</button></a>
        </div>

        <!--Modal-->
        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                    </div>
                    <form action="cfg/atualizaSaldo.php" method="POST">
                        <div class="modal-body">
                            <!--Adicionar/Remover crédito, só é mostrado quando ativado-->
                            <div class="div-modal-saldo">
                                <input class="disable input-modal-saldo" name="saldoAtual"  type="text" id="saldoAtual" maxlength="7">
                                <input type="hidden" name="idCliente" id="idCliente" value="0">
                                <input type="hidden" name="tipoClienteModal" value="0">
                                <input type="hidden" name="saldoAnterior" value="0">
                                <input type="hidden" name="tipoHistorico" value="0">
                            </div>
                            <br>
                            <div class="center-modal">
                                <table class="table-responsive">
                                    <tr>
                                        <td>
                                            <input class="input-modal-saldo" type="text" name="credito-modal" maxlength="7">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>    
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button type="button" id="adicionar" class="btn btn-success">Inserir Saldo</button>
                                            <button type="button" id="remover" class="btn btn-danger">Remover Saldo</button>
                                            <button type="button" id="marcar" class="btn btn-primary">Marcar Saldo</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>   
                                <div class="hint align-right">
                                    <span id="cad-icon" class="glyphicon glyphicon-cog"></span>
                                    <span class="hint-texto">Atualizar Cliente</span>
                                </div>
                                <div class="align-right">
                                    <button type="submit" class="btn btn-warning">Confirmar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>