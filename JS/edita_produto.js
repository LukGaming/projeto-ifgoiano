$(document).ready(verificaSessao);
function verificaSessao() {
  $.post("../../PHP/index.php",
    "verifica_sessao=1",
    function (retorno) {
      data = JSON.parse(retorno);
      if (data == 0) {
        window.location = "../login/index.html";
      }
    });
}
var url = new URL(document.location);
var id_produto = url.searchParams.get("product");
var divedicao_produto = $("#edicao_produto");
var $nome_produto = $("#nome");
var $descricao = $("#descricao");
var $quantidade = $("#quantidade");
var $valor = $("#valor");
var editorContent = document.querySelector(".editor");
var $btnSalvar = $("#salvar");
var $erro_nome = $("#erro-nome");
var $erro_quantidade = $("#erro-quantidade");
var $erro_descricao = $("#erro-descricao");
var $erro_valor = $("#erro-valor");
var $span_sucesso = $("#span-sucesso");
var $div_deletar_produto = $("#deletar_produto");
//$div_deletar_produto.hide();
$(document).ready(buscaDadosProdutoParaEditar);
function buscaDadosProdutoParaEditar() {
  $.post(
    "../../PHP/index.php",
    "editar_produto=1"
    + "&id_produto=" + id_produto,
    function (result) {
      var resultado = JSON.parse(result);
      if (resultado.erro == 1) {
        $(divedicao_produto).empty();
        $(divedicao_produto).append("Voce pode editar somente seus próprios produtos");
      }
      else if (resultado.erro == 2) {
        window.location = "../login/index.html";
      }
      else {
        $nome_produto.val(resultado.nome_produto);
        editorContent.innerHTML = resultado.descricao;
        $quantidade.val(resultado.qtd_disponivel);
        $valor.val(resultado.valor_produto);
      }
    }
  );
}

$($btnSalvar).click(validarEdicoes);
function validarEdicoes() {
  var count1 = 0;
  var count2 = 0;
  var count3 = 0;
  var conta4 = 0;
  if ($nome_produto.val() < 1) {
    $erro_nome.html("Nome Invalido");
    count1 = -1;
  }
  else {
    $erro_nome.html("");
    count1 = 0;
  }
  if ($quantidade.val() == 0) {
    count2 = -1;
    $erro_quantidade.html("Quantidade Invalida")
  }
  else {
   $erro_quantidade.html("");
    count2 = 0;
  }
  if (editorContent.textContent < 4) {
    $erro_descricao.html("Descricao Invalida");
    count3 = -1
  }
  else {
    $erro_descricao.html("");
    count3 = 0;
  }

  if ($valor.val() == 0) {
    $erro_valor.html("Valor Invalido");
    count4 = -1;
  }
  else {
    $erro_valor.html("");
    count4 = 0;
  }
  var somaConta = count1 + count2 + count3 + count4;
  if(somaConta == 0){
    SalvarEdicoes();
  }
}
function deletarProduto(){

}
function SalvarEdicoes() {
    $.post("../../PHP/index.php",
      "editar_produto1=1"
      + "&nome_produto=" + $nome_produto.val()
      + "&qtd_disponivel=" + $quantidade.val()
      + "&valor_produto=" + $valor.val()
      + "&descricao=" + editorContent.innerHTML
      + "&id_produto="+id_produto,
      function (retorno) {
        result = JSON.parse(retorno);
        if(result.vazio == 0){
          $span_sucesso.html("Nenhuma Alteração Efetuada");
        }
        else{
          $span_sucesso.html("Alteração efetuada com Sucesso");
        }

      }
    );
  }
