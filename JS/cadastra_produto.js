
$(document).ready(verificaSessao);
function verificaSessao() {
  $.post("../../PHP/index.php",
    "verifica_sessao=1",
    function (retorno) {
      data = JSON.parse(retorno);
      if (data == 0) {
        window.location = "../login/index.html?cadastro_produto=1";
      }
      else {
        
      }
    });
  }
  
  $('#submit').click(cadastrarProduto);
  function cadastrarProduto() {
    var form_data = new FormData();//IMAGEM
    var totalfiles = document.getElementById('files').files.length;//Imagem
    var input_imagens = document.getElementById('files');
    var nome = $("#nome");
    var quantidade = $("#quantidade");
    //var descricao = $("#descricao");
    var content = document.querySelector(".getcontent");
    var editorContent = document.querySelector(".editor");
    var s = editorContent.innerHTML;
    content.textContent = s;
    var descricao = editorContent.innerHTML;
    var valor = $("#valor");
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
    console.log(encodeURIComponent(descricao));
    var span_sucesso = $("#span-sucesso");
    if (nome.val().length < 4) {
      erro_nome.html("Nome Invalido");
      count1 = -1;
    }
    else {
      erro_nome.html("");
      count1 = 0;
    }
    if (quantidade.val() == 0) {
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

    if (valor.val() == 0) {
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
      ////////////CODIGO DA IMAGEM//////////////
      for (var index = 0; index < totalfiles; index++) {
        form_data.append("files[]", document.getElementById('files').files[index]);
      }
      var data = [nome, quantidade, descricao, valor];
      form_data.append("nome", nome.val());
      form_data.append("qtd_disponivel", quantidade.val());
      form_data.append("descricao", descricao);
      form_data.append("valor", valor.val());
      
      // AJAX request
      $.ajax({
        url: '../../PHP/index.php',
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
          /*for (var index = 0; index < response.length; index++) {
            var src = response[index];
            // Add img element in <div id='preview'>
            //Aqui seria onde a imagem seria vista
            //$('#preview').append('<img src="../' + src + '" width="200px;" height="200px">');
          }*/
          span_sucesso.append(
            "'<div class='alert' role='alert' style='margin-bottom: 5px; background-color: rgb(0, 179, 134)'> "
            + "Produto Criado com sucesso!"
            + "<a href='../visualizar_produto/?product=" + response.last_id + "' class='alert-link'> Clique para acessar o produto</a>"
            + "</div>"
          );
        }
      });
      nome.val("");
      quantidade.val("");
      editorContent.innerHTML = "";
      valor.val("");
      input_imagens.value = "";
    }
}