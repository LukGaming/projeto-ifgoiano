function verificaSessao() {
    $.post("../../PHP/index.php",
      "verifica_sessao=1",
      function (retorno) {
        data = JSON.parse(retorno);
        if (data.resultado == 0) {
          window.location = "../login/index.html?cadastro_produto=1";
        }
        else {
  
        }
      });
}