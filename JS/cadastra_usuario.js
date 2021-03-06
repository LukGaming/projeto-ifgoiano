$(document).ready(verificaSessao);
function verificaSessao() {
  $.post("../../PHP/index.php",
    "verifica_sessao=1",
    function (retorno) {
      data = JSON.parse(retorno);
      console.log(data);
      if (data == 0) {
       
      }
      else {
        window.location = "../home/index.html";
      }
    });
  }
var btnClicado = $("#cadastrar");
btnClicado.click(function () {
    var count = 0;
    var nome = $("#nome").val();
    var erro_nome = $("#erro-nome");
    //Verificando se o nome tiver menos que 4 caracteres
    if (nome.length <= 4) {
        erro_nome.html("Insira um nome Valido");
        count = -1;
    }
    else {
        erro_nome.html("");
        count = 0;
    }
    var data = $("#date").val();
    var data_completa = data.split("/");
    var erro_data = $("#erro-data");
    var data_final = data_completa[2] + "-" + data_completa[1] + "-" + data_completa[0];
    //Verificando se a data é valida
    if (data == "" || data_completa[2].includes("y")) {
        erro_data.html("Insira uma data valida");
        count = -1;
    }
    else {
        erro_data.html("");
        count = 0;
    }
    var email = $("#email").val();
    var erro_email = $("#erro-email");
    if (email == "") {
        erro_email.html("Insira um Email valido");
        count = -1;
    }
    else {
        erro_email.html("")
        count = 0;
    }
    var senha = $("#senha").val();
    var erro_senha = $("#erro-senha");
    if (senha.length < 8) {
        erro_senha.html("A senha deve conter no mínimo 08 Dígitos");
        count = -1;
    }
    else {
        erro_senha.html("");
        count = 0;
    }
    if (count == -1) {
        event.preventDefault();
    }
    else {
        event.preventDefault();
        $.post("../../PHP/index.php",
            "cadastro=1"
            + "&nome=" + nome +
            "&data_nascimento=" + data_final +
            "&email=" + email +
            "&senha=" + senha,
            function (retorno) {
                if (retorno == 1) {
                    erro_email.html("Este email já está sendo utilizado");
                }
                else {
                    window.location = "../login/index.html?cadastro=1";
                }
        });
    }
});
