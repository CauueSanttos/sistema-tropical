$(document).ready(function () {
    $('.glyphicon-trash').click(function (){
        let iCodigoCliente = $(this).val();
        swal({
            title: "Você tem certeza?",
            text: "Após confirmar, o cliente será excluído!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
        .then((bExcluir) => {
          if (bExcluir) {
            swal("O cliente foi excluído com sucesso!", {
              icon: "success"
            });
            excluirCliente();
          } else {
            swal("O cliente não foi excluído!");
          }
        });
        
        function excluirCliente(){
            $.ajax({
               url: 'cfg/excluirCliente.php',
               dataType: 'json',
               async: false,
               type: 'POST',
               data:{
                   'codigoCliente': iCodigoCliente
               },
               success: function(xData){
                   
               }
            });
            
            setInterval(function (){
               $('#container').load('clientes.php').fadeIn('slow') ;
            }, 1000);
        }
        
    });
});