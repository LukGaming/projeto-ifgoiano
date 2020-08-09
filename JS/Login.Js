var btnClicado = $("#login");
btnClicado.click(function(){
    var count = 0;
    var email = $("#email").val();
    var erro_email = $("#erro-email");
    if(email == ""){
        erro_email.html("Insira um Email valido");
        count = -1; 
        event.preventDefault();
    }
    else{
        erro_email.html("")
        count = 0;
    }
    var senha = $("#senha").val();
    var erro_senha = $("#erro-senha");
    if(senha.length < 8){
        erro_senha.html("Senha Invalida");
        count = -1; 
        event.preventDefault();
    }
    else{
        erro_senha.html("");
        count = 0;
    }   
    if(count == -1){
        event.preventDefault(); 
    }
    else{
        event.preventDefault(); 
        $.post("../../PHP/VerificaUsuario.php",        
        "email="+email+
        "&senha="+senha,        
        function(retorno){ 
            console.log(retorno)   
            if(retorno == 0){                
                erro_senha.html("Senha incorreta");                            
            }
            else{        
                window.location.href = "../home/index.html";                
            }         
        });            
    }        
});