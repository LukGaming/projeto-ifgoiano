$nome = $("#nome");
$data_nascimento = $("#date");
$email = $("#email");
$.post("../../PHP/index.php",
    "request_user_data=1",
    function (retorno) {
        user_data = JSON.parse(retorno);
        if (user_data.vazio == 0) {
            window.location = "../login/index.html";
        }
        else {
            $nome.val(user_data.nome.toUpperCase());
            var data_completa = user_data.data_nascimento.split("-");
            var data_para_mostrar = data_completa[2] + "/" + data_completa[1] + "/" + data_completa[0];
            $data_nascimento.val(data_para_mostrar);
            $email.val(user_data.email);
        }
    }
);
$btn_editar_senha = $("#editar-senha");
$div_editar_senha = $("#div-editar-senha");
$btn_cancelar = $("#cancelar");
$btn_salvar = $("#salvar");
$($btn_salvar).click(validar_edicao);
cancelar_editar_senha();
$($btn_editar_senha).click(aparece_editar_senha);
$($btn_cancelar).click(cancelar_editar_senha);
function aparece_editar_senha() {
    $($div_editar_senha).show();
    $($btn_editar_senha).hide();
    $($btn_cancelar).show();
}
function cancelar_editar_senha() {
    $($div_editar_senha).hide();
    $($btn_cancelar).hide();
    $($btn_editar_senha).show();
}
function validar_edicao() {
    if ($($btn_editar_senha).css('display') == "block") {
        $nome = $("#nome");
        $data_nascimento = $("#date");
        $email = $("#email");
        var count1 = 0;
        var count2 = 0;
        $erro_nome = $("#erro-nome");
        $erro_data = $("#erro-data");
        var desfazendo_data = $data_nascimento.val().split("/");
        var data_final = desfazendo_data[2] + "-" + desfazendo_data[1] + "-" + desfazendo_data[0];
        if ($nome.val().length < 4) {
            $erro_nome.html("Nome Inválido");
            count1 = -1;
        }
        else {
            $erro_nome.html("");
            count1 = 0;
        }
        if ($data_nascimento.val() == "" || desfazendo_data[2].includes("y")) {
            $erro_data.html("Data Inválida");
            count2 = -1;
        }
        else {
            $erro_data.html("");
            count2 = 0
        }
        var conta_final = count1 + count2;
        if (conta_final == 0) {
            $.post("../../PHP/index.php",
                 "editar_usuario=0"
                +"&nome=" + $nome.val()
                +"&data_nascimento="+data_final,
                function (retorno) {
                    resultado = JSON.parse(retorno);
                    if(resultado.edicao == 0){
                        alert("nenhuma modificação efetuada");
                    }
                    else{
                        alert("modificação efetuada com sucesso");
                    }
                }
            );
        }
    }
    else {

    }
}