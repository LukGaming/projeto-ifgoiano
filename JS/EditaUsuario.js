var email = "thelukgaming333@gmail.com";
var spanEmail = $("#span_email");
spanEmail.html(email);
function EditarNome() {
    //alert("Botão Clicado");
    //Pegando Valor Atual da span que contém o nome
    var nome = $("#nome").val();
    //Mostrando o nome no console para verificar se ele foi pego
    console.log(nome);
    //Trocando toda a div que contém o spam por um input text para poder digitar o nome novamente
    $("#nome").val(nome);
    event.preventDefault();
    $.post("../../PHP/EditaUsuario.php",
        "novo_nome=" + nome
        + "&email=" + email,
        function (retorno){
            console.log(retorno);
        });
}
function EditarData() {
    //alert("Botão Clicado");
    //Pegando Valor Atual da span que contém o nome
    var data = $("#data").val();
    console.log(data);
    //Trocando toda a div que contém o spam por um input text para poder digitar o nome novamente
    $("#data").val(data);
    event.preventDefault();
    $.post("../../PHP/EditaUsuario.php",
        "nova_data=" + data +
        "&email=" + email,
        function (retorno) {
            console.log(retorno);
        });
}
function ExcluirConta() {
    event.preventDefault();
    var btnExcluir = $("#btn-Excluir");
    btnExcluir.html("Digite sua Senha: <br><input type='password' placeholder='Senha' id='input-senha'><button id='excluir'>Excluir</button><span id='span-retorno'></span>");
    $("#excluir").click(function () {
        event.preventDefault()
        var senha = $("#input-senha").val();
        var spanRetorno = $("#span-retorno");
        if (senha.length < 8) {
            spanRetorno.css("color", "red");
            spanRetorno.html("&nbsp;  Senha Invalida!");
        }
        else {
            $.post("../../PHP/EditaUsuario.php",
            "senha=" + senha +
            "&email=" + email,
            function (retorno) {
                //console.log(retorno);
                if (retorno == 1) {
                    window.location.href = "../login/index.html";
                }
                if (retorno == 0) {
                    spanRetorno.css("color", "red");
                    spanRetorno.html("&nbsp;  Senha Invalida!");
                }
            });
        }
    })
}

function EditarSenha(){    
    event.preventDefault();
    var divSenha = $("#editar-senha");
    divSenha.html("<div class='form-group'>"
    +"<label for='nome'>Digite Sua senha</label>"
    +   "<input type='text' class='form-control' id='senha1' placeholder='Senha' >"
    +   "<span class='badge badge-danger' id='erro-senha1'></span>"
    +  "</div>"
    +"<div class='form-group'>"
    +"<label for='nome'>Repita a Senha</label>"
    +   "<input type='text' class='form-control' id='senha2' placeholder='Repetir Senha' >"
    +   "<span class='badge badge-danger' id='erro-senha2'></span>"
    +  "</div>"
    +"<div class='form-group'>"
    +"<label for='nome'>Digite a Nova Senha</label>"
    +   "<input type='text' class='form-control' id='nova-senha' placeholder='Nova Senha' >"
    +   "<span class='badge badge-danger' id='erro-senha-nova'></span>"
    +  "</div>"
    +"<button id='salvar-senha'>Salvar</button>"
    );
    $("#salvar-senha").click(function(){
        event.preventDefault();
        //Valor dos inputs
        var senha1 = $("#senha1").val();
        var senha2 = $("#senha2").val();
        var novaSenha = $("#nova-senha").val();
        //Spans que retornarao erro
        var errosenha1 = $("#erro-senha1");
        var errosenha2 = $("#erro-senha2");
        var erroNovaSenha = $("#erro-senha-nova");        
        if(senha1.length < 8){
            errosenha1.html("Senha incorreta");
        }
        else{
            errosenha1.html("");
            if(senha1 != senha2){
                errosenha2.html("As senhas não coincidem");
                errosenha1.html("");
            }
            else if(senha1 == senha2){               
                errosenha2.html("");
                if(novaSenha.length < 8){                    
                   erroNovaSenha.html("A nova senha deve Conter No mínimo 8 Digitos");
                   errosenha1.html("");
                }
                else{
                    erroNovaSenha.html("");
                    $.post("../../PHP/EditaUsuario.php",
                    "senha_antiga="+senha1+
                    "&email="+email+
                    "&nova_senha="+novaSenha,
                    function (retorno){
                        console.log(retorno);
                        if (retorno == 1) {
                            erroNovaSenha.html("Senha trocada!");
                        }
                        if (retorno == 0) {
                            errosenha1.html("Senha incorreta");
                        }
                    });
                }
            }
        }
    })
}
