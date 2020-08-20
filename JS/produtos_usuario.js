$(document).ready(produtosUsuario);
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
$(document).ready(verificaSessao);
function produtosUsuario() {
  $produtos = $("#produtos");
  $.post("../../PHP/index.php",
    "produtos_usuario=1",
    function (retorno) {
      var result = JSON.parse(retorno);
      if (result.vazio == 0) {

      }
      else {
        for (i = 0; i < result.length; i++) {
          var strippedString = result[i].descricao.replace(/(<([^>]+)>)/gi, "");
          var text = "";
          if (strippedString.length > 200) {
            for (j = 0; j < 200; j++) {
              text += strippedString[j];
            }
            text += "...";
          }
          else {
            text = strippedString;
          }
          $($produtos).append(
            "<div class='each_product_of_user'>"
            + "<div class='imagem_produto'>"
            + "<img src='../../upload_images/" + result[i].id_produto + "-0.jpg' width='100px' height='100px'>"
            + "<div class='nome_descricao w-100'>"
            + "<div class='nome_produto h3'> " + result[i].nome_produto + "</div>"
            + "<div class='descricao_produto'>" + text + "</div>"
            + " </div>"
            + "<div class='btn_editar'>"
            + "<a href='../editar_produto/?product=" + result[i].id_produto + "'>"
            + "<div class='btn btn-success'>Editar Produto</div>"
            + " </a> "
            + "</div>"
            + "</div> "
            + "</div>"
            + "</div>"
          );
        }
        var text = "";
      }
    }
  );
}