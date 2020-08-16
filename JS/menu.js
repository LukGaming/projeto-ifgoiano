$(window).on("load", menuInfo);
$nome_usuario = $("#nome_usuario");
$deslogar = $("#deslogar");
$deslogado = $("#deslogado");
$logado = $("#logado");
function menuInfo(){   
    $.post("../../PHP/index.php",
    "verifica_sessao=1",
    function (retorno) {
        data = JSON.parse(retorno);
        if (data == 0) {
            $logado.hide();
        }
        else {
            $nome_usuario.html(data.nome.toUpperCase());
            $deslogado.hide();
        }
    });
}
$deslogar.click(deslogar);
function deslogar(){
    $.post("../../PHP/index.php",
    "deslogando=1",
    function (retorno) {
        data = JSON.parse(retorno);
        if (data.resultado == 1) {
            window.location = "../login/index.html";
        }
    });
}