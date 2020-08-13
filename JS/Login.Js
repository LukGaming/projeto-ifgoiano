$(document).ready(verificaSessao);
function verificaSessao() {
    $.post("../../PHP/index.php",
        "verifica_sessao=1",
        function (retorno) {
            data = JSON.parse(retorno);
            if (data == 0) {
                
            }
            else {
                window.location = "../home/index.html";
            }
    });
}

var btnClicado = $("#login");
btnClicado.click(function () {
    var count = 0;
    var email = $("#email").val();
    var senha = $("#senha").val();
    var erro = $("#erro");
    if (email == "") {
        count = -1;
        event.preventDefault();
        erro.html("Email ou senha incorretos");
    }
    else {
        count = 0;
    }
    if (senha.length < 8) {
        count = -1;
        erro.html("Email ou senha incorretos");
        event.preventDefault();
    }
    else {
        count = 0;
    }
    if (count == -1) {
        event.preventDefault();
    }
    else {
        event.preventDefault();
        $.post("../../PHP/index.php",
            "login=1" +
            "&email=" + email +
            "&senha=" + senha,
            function (retorno) {
                //console.log(retorno);
                console.log(retorno.replace("/"));
                if (retorno == 0) {
                    erro.html("Email ou senha incorretos");
                }
                else {
                    window.location = "../home/index.html";
                }
            });
    }
});