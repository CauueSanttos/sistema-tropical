$(document).ready(function () {

    $('#adicionar').click(function () {
        let fValorCliente = parseFloat($('#saldoAtual').val());
        let fValorAdd = parseFloat($('[name=credito-modal]').val());

        if (fValorAdd > 0) {
            $('[name=tipoHistorico]').val(1);
            if(fValorCliente == ''){
                $('#saldoAtual').val(fValorAdd);
            } else {
                let fValorAdicional = 0;
                if(!fValorCliente == ''){
                    fValorAdicional = fValorCliente;
                }
                $('#saldoAtual').val(fValorAdicional + fValorAdd);
            }
        }
    });

    $('#remover').click(function () {
        let fValorCliente = parseFloat($('#saldoAtual').val());
        let fValorAdd = parseFloat($('[name=credito-modal]').val());

        if (fValorAdd > 0) {
            $('[name=tipoHistorico]').val(2);
            $('#saldoAtual').val(fValorCliente - fValorAdd);
        }
    });
    
    $('#marcar').click(function () {
        let fValorCliente = parseFloat($('#saldoAtual').val());
        let fValorAdd = parseFloat($('[name=credito-modal]').val());

        if (fValorAdd > 0) {
            $('[name=tipoHistorico]').val(3);
            if(fValorCliente == ''){
                $('#saldoAtual').val(fValorAdd);
            } else {
                let fValorAdicional = 0;
                if(!fValorCliente == ''){
                    fValorAdicional = fValorCliente;
                }
                $('#saldoAtual').val(fValorAdd + fValorAdicional);
            }
        }
    });
    
    $('#cad-icon').click(function (){
       window.location = ('gerenciar.php?idCliente=' + $('#idCliente').val()); 
    });

});