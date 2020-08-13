$(window).on("load", menuInfo);
$nome_usuario = $("#nome_usuario");
$deslogar = $("#deslogar");
function menuInfo(){   
    $.post("../../PHP/index.php",
    "verifica_sessao=1",
    function (retorno) {
        data = JSON.parse(retorno);
        if (data == 0) {

        }
        else {
            $nome_usuario.html(data.nome.toUpperCase());
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