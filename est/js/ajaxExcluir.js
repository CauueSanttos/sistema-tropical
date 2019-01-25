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
               data:{
                   'codigoCliente': iCodigoCliente
               },
               success: function(xData){
                   eval(xData);
               }
            });
        }
        
    });
});