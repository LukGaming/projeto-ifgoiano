
$(document).ready(function () {
  $('#submit').click(function () {
    var form_data = new FormData();//IMAGEM
    var totalfiles = document.getElementById('files').files.length;//Imagem
    var nome = $("#nome").val();
    var quantidade = $("#quantidade").val();
    var descricao = $("#descricao").val();
    var valor = $("#valor").val();
    var erro_nome = $("#erro-nome");
    var erro_quantidade = $("#erro-quantidade");
    var erro_descricao = $("#erro-descricao");
    var erro_valor = $("#erro-valor");
    var erro_imagens = $("#erro-imagens");
    var count1 = 0;
    var count2 = 0;
    var count3 = 0;
    var count4 = 0;
    var count5 = 0;
    if (nome.length < 4) {
      erro_nome.html("Nome Invalido");
      count1 = -1;
    }
    else {
      erro_nome.html("");
      count1 = 0;
    }
    if (quantidade == 0) {
      count2 = -1;
      erro_quantidade.html("Quantidade Invalida")
    }
    else {
      erro_quantidade.html("");
      count2 = 0;
    }
    if (descricao.length < 4) {
      erro_descricao.html("Descricao Invalida");
      count3 = -1
    }
    else {
      erro_descricao.html("");
      count3 = 0;
    }
    if (valor == 0) {
      erro_valor.html("Valor Invalido");
      count4 = -1;
    }
    else {
      erro_valor.html("");
      count4 = 0;
    }
    if (totalfiles == 0) {
      erro_imagens.html("O produto deve Conter No mínimo uma imagem");
      count5 = -1;
    }
    else {
      erro_imagens.html("");
      count5 = 0;
    }
    var somaConta = count1 + count2 + count3 + count4 + count5;
    if (somaConta == 0) {
      /*//Enviando os dados para criacao do produto
      var lastIdInserted = [];
      $.post("../../PHP/index.php",
        "createProduct=1"+
        "&nome=" + nome +
        "&qtd_disponivel=" + quantidade +
        "&descricao=" + descricao +
        "&valor=" + valor+
        "&form_data="+form_data,
        function(retorno) {
          console.log(retorno);
        }        
      );*/     
      $.ajax({
        url: '../../PHP/index.php',
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          for (var index = 0; index < response.length; index++) {
            console.log(response[index]);
            var src = response[index];

            // Add img element in <div id='preview'>
            //Aqui seria onde a imagem seria vista
            $('#preview').append('<img src="../../' + src + '" width="200px;" height="200px">');
          }
        }
      });
    }
  });
});
