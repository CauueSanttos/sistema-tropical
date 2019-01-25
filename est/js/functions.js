$(document).ready(function () {

    //CONSTANTES
    const TIPO_CAMPO_OBRIGATORIO = 1,
          TIPO_CAMPO_CADASTRO    = 2,
          TIPO_CAMPO_BUSCA       = 3,
          TIPO_LOGIN             = 4;
    ////////////////
    
    //FUNÇÕES QUE PODEM SER UTILIZADAS EM VÁRIOS LUGARES
    function alertCampos(iTipoAlerta) {
        if (iTipoAlerta == TIPO_CAMPO_OBRIGATORIO) {
            swal({
                title: "Campos Obrigatórios",
                text: "Preencha os campos destacado em vermelho!",
                icon: "warning",
                dangerMode: true
            });
        } else if (iTipoAlerta == TIPO_CAMPO_CADASTRO) {
            swal({
                title: "Sucesso!",
                text: 'O cadastro de ' + $('[name=nome]').val() + ' foi efetuado!.',
                icon: "success"
            });
        } else if(iTipoAlerta == TIPO_CAMPO_BUSCA){
            swal({
                title: "Aviso",
                text: "Informe um cliente para realizar a busca!",
                icon: "warning",
                dangerMode: true
            });
        } else if(iTipoAlerta == TIPO_LOGIN){
            swal({
                title: "Login Inválido",
                text: "Usuário ou Senha incorretos!",
                icon: "warning",
                dangerMode: true
            });
        }
        
    }
    
    ////////////////////////////////////////////////////
    
    //MOSTRA O FORMULÁRIO DE CADASTRO
    $("#hide").click(function () {
        $("#cadastro").toggle("slow");
        $("#login").hide();
        $('#pesquisa').hide();
        $("#login").trigger('reset');
    });
    /////////////////////////////////

    //MOSTRA O FORMULÁRIO DE BUSCA
    $("#show").click(function () {
        $("#login").toggle("slow");
        $("#cadastro").hide();
        $('#pesquisa').hide();
        $("table").trigger('reset');
        $("#cadastro").trigger('reset');
        $("#login").trigger('reset');
    });
    /////////////////////////////////

    //DEIXAMOS OS INPUTS EM UPPERCASE
    $('[name=nome], [name=empresa], [name=usuario], [name=pesquisaCliente]').keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
    /////////////////////////////////

    //VALIDAÇÕES DE CAMPOS
    $('[name=nome]').blur(function () {
        if ($('[name=nome]').val() == '') {
            $('[name=nome]').css('border', '1px solid red');
            alertCampos(TIPO_CAMPO_OBRIGATORIO);
        } else {
            $('[name=nome]').css('border', '1px solid #066600');
        }
    });

    $('[name=credito]').blur(function () {
        if ($('[name=credito]').val() == '0,00') {
            $('[name=credito]').css('border', '1px solid red');
            alertCampos(TIPO_CAMPO_OBRIGATORIO);
        } else {
            $('[name=credito]').css('border', '1px solid #066600');
        }
    });
    ////////////////////////////////////

    //MASCARA NOS CAMPOS
    $('[name=telefone]')
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    $("[name=credito]").maskMoney({symbol: 'R$ ',
        showSymbol: false,
        thousands: '',
        decimal: '.',
        symbolStay: true});
    $("[name=credito-modal]").maskMoney({symbol: 'R$ ',
        showSymbol: false,
        thousands: '',
        decimal: '.',
        symbolStay: true});
    $("#saldoAtual").maskMoney({symbol: 'R$ ',
        showSymbol: false,
        thousands: '',
        decimal: '.',
        symbolStay: true});
    /////////////////////////////////////////////////

    //CADASTRO CLIENTE
    $("form[ajax=true]").submit(function (bForm) {
        bForm.preventDefault();
        $.ajax({
            url: 'cfg/cadastro.php',
            type: 'POST',
            datatype: 'JSON',
            data: {
                nome: $('[name=nome]').val(),
                telefone: $('[name=telefone]').val(),
                empresa: $('[name=empresa]').val(),
                tipoCliente: $('[name=tipoCliente]').val()
            },
            success: function () {
                alertCampos(TIPO_CAMPO_CADASTRO);
                $("form[ajax=true]").trigger('reset');
            }
        });
    });
    ///////////////////////////////////////

    //REQUISIÇÃO DE BUSCA
    $("#pesquisaCliente").click(function () {
        event.preventDefault();
        let sNomeUsuario = $("[name=pesquisaCliente]").val();
        
        if(sNomeUsuario != ''){
            $.ajax({
                url: 'cfg/pesquisa.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    'nomeUsuario': sNomeUsuario
                },
                success: function (oRetorno) {
                    $('#retornoPesquisa').empty();
                    $('#pesquisa').show();
                    for (let i in oRetorno) {
                        let sTipo = (oRetorno[i].clitipo == 1 ? 'NORMAL' : 'MENSALISTA');
                        
                        $('#retornoPesquisa').append(
                                $('<tr>').append(
                                    $('<td>', {
                                        text: oRetorno[i].clinome
                                    }),
                                    $('<td>', {
                                        text: oRetorno[i].clitelefone
                                    }),
                                    $('<td>', {
                                        text: oRetorno[i].cliempresa
                                    }),
                                    $('<td>', {
                                        text: sTipo
                                    }),
                                    $('<td>', {
                                        text: oRetorno[i].clicredito
                                    }),
                                    $('<td>', {
                                        text: oRetorno[i].climensalista
                                    }),
                                    $('<td>').append(
                                    $('<button>', {
                                        value: oRetorno[i].clicodigo,
                                        'class': 'btn-gerenciar glyphicon glyphicon-cog',
                                        name: 'valorGerenciar'
                                    })
                                    )
                                )
                        );
                
                        $('#pesquisa td').css('color', 'black');
                        $('.btn-gerenciar').css('color', 'black');
                        $('#pesquisa').css('font-weight', 'bold');

                        //Gerenciamento do cliente
                        $('.btn-gerenciar').click(function () {
                            let iCodigoCliente = $(this).val();

                            $.ajax({
                                url: 'cfg/buscaGerencia.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    codigo: iCodigoCliente
                                },
                                success: function (oRetorno) {
                                    for (let i in oRetorno) {
                                        //Limpar o modal
                                        $('.modal-header').empty();
                                        
                                        $('.modal-header').append(
                                                $('<h4>', {
                                                    'class': 'modal-title',
                                                    text: oRetorno[i].clinome
                                                }),
                                        );
                                        
                                        let iTipoCliente = oRetorno[i].clitipo;
                                        if(iTipoCliente == 2){
                                            $('#adicionar').prop('disabled', true);
                                            $('#marcar').prop('disabled', false);
                                        } else {
                                            $('#adicionar').prop('disabled', false);
                                            $('#marcar').prop('disabled', true);
                                        }
                                        
                                        fSaldoAtual = (oRetorno[i].clicredito != null ? oRetorno[i].clicredito : oRetorno[i].climensalista);
                                        fSaldoAnterior = (oRetorno[i].clicredito != null ? oRetorno[i].clicredito : oRetorno[i].climensalista);
                                        
                                        $('#saldoAtual').val(fSaldoAtual);
                                        $('[name=saldoAnterior]').val(fSaldoAnterior);
                                        $('#idCliente').val(oRetorno[i].clicodigo);
                                        $('[name=tipoClienteModal]').val(oRetorno[i].clitipo);
                                        

                                        //Mostrar o modal
                                        $("#modal").modal();
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }
        else{
            alertCampos(TIPO_CAMPO_BUSCA);
        }
    });
    /////////////////////////////////////////////////////////////////////

});