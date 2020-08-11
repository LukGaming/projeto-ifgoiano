$(document).ready(mostraSomenteUmProduto);
function mostraSomenteUmProduto() {
    var carousel_imagens = $("#imagens-carrolsel");
    var url = new URL(document.location);
    var id_produto = url.searchParams.get("product");
    var nome = $("#nome");
    var valor = $("#valor");
    var qtd_disponivel = $("#qtd_disponivel");
    var descricao = $("#descricao");
    var vendedor = $("#vendedor");
    var article = $("article")[0];
    if (!id_produto) {
        limpaTela();
    }
    else {
        $.getJSON("../../PHP/index.php",
            "getoneproduct=1"
            + "&id_produto=" + id_produto,
            function (result) {
                if(result.vazio == 0){
                    limpaTela();
                }
                else{
                    $(carousel_imagens).append(
                        "<div class='carousel-item active'>"
                        + "<img class='d-block ' src='../../upload_images/" + result.imagem[0].caminho + "' alt='Second slide'style='height: 390px; width:390px;'>"
                        + "</div>"
                    );
                    var array = [];
                    result.imagem.forEach(item => {
                        array.push(item.caminho);
                    });

                    for (i = 1; i < array.length; i++) {
                        $(carousel_imagens).append("<div class='carousel-item '><img class='d-block' src='../../upload_images/" + array[i] + "' alt='Third slide' style='height: 390px; width:390px;'> </div>");
                    }
                    $(nome).append("<div>" + result[0].nome_produto + "</div>");
                    $(valor).append("<div>" + result[0].valor_produto + "</div>");
                    $(qtd_disponivel).append(result[0].qtd_disponivel);
                    $(descricao).append("<div>" + result.descricao[0] + "</div>");
                    $(vendedor).append("<div>" + result.nome_vendedor + "</div>");
                    
                }
                    
            }
        );
    }
    function limpaTela() {
        $(article).empty();
        $(article).append("Nenhum Produto Encontrado");
    }

}
