var ProductElements = $("article")[1];

var inputBuscar = $("#input-buscar");

$(document).ready(mostraTodosProdutos);

function mostraTodosProdutos() {
    $(ProductElements).empty();
    $.getJSON("../../PHP/index.php",
    "getListofProducts=1",
        function (data) { 
            data.forEach(item => {
                $(ProductElements).append(
                    "<div class='div-produto'>"
                    + "<div class='imagem-produto'>"
                    + "<img src='../../upload_images/"+item.id_produto+"-0.png' width='256' height='256'>"
                    + "</div>"
                    + "<div class='dados-produto'>"
                    + "<div class='h3 font-weight-bold'>R$ " + item.valor_produto + "</div>"
                    + "<div class='h6 font-weight-bold'>" + item.nome_produto + "</div>  "
                    + "</div>  "
                    + "</div>"
                );
            });
        }
    );
}
$(inputBuscar).keyup(buscarProdutoPorNome);

function buscarProdutoPorNome() {
    if(inputBuscar.val() !== "") {
        $(ProductElements).empty();
        $.getJSON("../../PHP/index.php",
            "getListofProducts=0"       
            +"&keyword="+inputBuscar.val(),
            function (result) {
                if(result.length > 0){                    
                    result.forEach(item => {                                       
                        $(ProductElements).append(
                            "<div class='div-produto'>"
                            + "<div class='imagem-produto'>"
                            + "<img src='../../upload_images/"+item.id_produto+"-0.png' width='256' height='256'>"
                            + "</div>"
                            + "<div class='dados-produto'>"
                            + "<div class='h3 font-weight-bold'>R$ " + item.valor_produto + "</div>"
                            + "<div class='h6 font-weight-bold'>" + item.nome_produto + "</div> "
                            + "</div>"
                            + "</div>"
                        );
                    });

                }
            }
        );
    }
    if(inputBuscar.val() == ""){
        mostraTodosProdutos();
    }
}
