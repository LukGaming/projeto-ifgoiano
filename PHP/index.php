<?php
require_once("config.php");
///Mostra um usuário especifico pelo Id.
/*$mostra_usuario = new Usuario();
$mostra_usuario->getUserById(1);
echo $mostra_usuario;*/
//Mostra todos os usuarios
//echo json_encode(Usuario::ListALlUsers());
//Procura um usário a partir do nome do usuário
//echo json_encode(Usuario::searchUserByName("ju"));
//Traz todos os dados do usuário a partir de uma autenticacao de email e senha
/*$getuserByauth = new Usuario();
$getuserByauth->getUserByAuth("juliO@gmail.com", "49:50:51:52:53:54:55:56");
echo $getuserByauth;*/
//INSERT NA TABELA DOS USUARIOS
/*$insert_user  = new Usuario("MARIA DE FATIMA FERREIRA MENDES","1962-05-06","fatimatiana_@hotmail.com","123456789");
$insert_user->insert();*/
//FAZ UPDATE NOS DADOS DO USUÁRIO
/*$update_usuario = new Usuario();
$update_usuario->getUserById(1);
echo $update_usuario;
$update_usuario->update("Paulo Antonio", "1998-06-11","thelukgaming333@gmail.com","123456");
echo $update_usuario;*/
//DELETANDO UM USUÁRIO
/*$deleta_usuario = new Usuario();
$deleta_usuario->getUserById(11);
echo $deleta_usuario;
$deleta_usuario->deleteUser();*/
//PRODUTO//
//Listando todos os produtos
if(isset($_GET['getListofProducts'])){
    $getListOfProducts = $_GET['getListofProducts'];
    if($getListOfProducts == 1){
        $todos_produtos = Produto::getListofProducts();
        $sql = new Sql();
        for($i=0;$i<count($todos_produtos); $i++){
                $consulta = $sql->select("SELECT caminho from imagens WHERE id_produto = :ID_PRODUTO",array(
                ":ID_PRODUTO"=>$todos_produtos[$i]['id_produto']));
               $imagem = $consulta[0];
               $todos_produtos[$i]['imagem'] = $imagem;
        }
        echo json_encode($todos_produtos);
    }
    else{    
        $keyword = $_GET['keyword'];
        $todos_produtos = Produto::searchProduto($keyword); 
        $sql = new Sql();
        for($i=0;$i<count($todos_produtos); $i++){
        $consulta = $sql->select("SELECT caminho from imagens WHERE id_produto = :ID_PRODUTO",array(
            ":ID_PRODUTO"=>$todos_produtos[$i]['id_produto']));
        $nome_imagem = $consulta[0];
        $todos_produtos[$i]['imagem'] = $nome_imagem;
        }
        if(count($todos_produtos) > 0){
            echo json_encode($todos_produtos);
        }
        else{
            echo json_encode(array("vazio"=>"vazio"));
        }
        
    }
}
//CADASTRANDO PRODUTO
if(isset($_FILES['files']['name'])){//$countfiles = count($_FILES['files']['name'])
    $novo_produto = new Produto(
        $_POST['nome'],
        $_POST['qtd_disponivel'],
        $_POST['descricao'],
        $_POST['valor'],
        1   //este é o id do usuário
    );
    $lastId = $novo_produto->insert();
    //var_dump($_POST['nome']['nome']);
    //Count total files
    $countfiles = count($_FILES['files']['name']);
    // Upload directory
    $upload_location = "../upload_images/";
    if(!is_dir($upload_location)){
        mkdir($upload_location);
    }
    // To store uploaded files path
    $files_arr = array();
    // Loop all files
    
    for($index = 0;$index < $countfiles;$index++){
    
    // File name
    $filename = $_FILES['files']['name'][$index];
    // Get extension
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    // Valid image extension
    $valid_ext = array("png","jpeg","jpg");
    $sql = new Sql();
    // Check extension
        if(in_array($ext, $valid_ext)){
            // File path
            $path = $upload_location.$filename;
        
            // Upload file
            if(move_uploaded_file($_FILES['files']['tmp_name'][$index], $path)){
                $new_file_name = $lastId."-".$index.".".pathinfo($filename, PATHINFO_EXTENSION);
                rename($path, $upload_location.DIRECTORY_SEPARATOR.$new_file_name);
                $files_arr[] = $upload_location.DIRECTORY_SEPARATOR.$new_file_name;
                $sql->query("INSERT INTO imagens(caminho, id_produto) VALUES (:CAMINHO, :ID_PRODUTO)",
                array(
                    ":CAMINHO"=>$new_file_name,
                    ":ID_PRODUTO"=>$lastId,
                ));
            }
        }
    }    
echo json_encode($files_arr);
}
//Buscando dados somente de um produto pelo ID.  

 /*   $buscar_produto_id = new Produto();
    $retorno = $buscar_produto_id->getProductById(487);
    if($retorno == 0){
        echo json_encode(array(
            "vazio"=>0
        ));
    }else{
        $sql = new Sql();
        $consulta = $sql->select("SELECT caminho from imagens WHERE id_produto = :ID_PRODUTO",array(
            ":ID_PRODUTO"=>$buscar_produto_id->getId()));
        for($i=0; $i<count($consulta); $i++){
            $retorno['imagem'][$i] = $consulta[$i];
        }
        $nome_vendedor = $sql->select("select nome from usuario where id_usuario = :ID_USUARIO",
        array(
            "ID_USUARIO"=>$retorno[0]['id_vendedor']
            ));
        $retorno['nome_vendedor'] = $nome_vendedor[0]['nome'];
        echo json_encode($retorno);
    }*/
    






if(isset($_GET['getoneproduct'])){
    $buscar_produto_id = new Produto();
    $retorno = $buscar_produto_id->getProductById($_GET['id_produto']);
    if($retorno == 0){
        echo json_encode(array(
            "vazio"=>0
        ));
    }else{
        $sql = new Sql();
        $consulta = $sql->select("SELECT caminho from imagens WHERE id_produto = :ID_PRODUTO",array(
            ":ID_PRODUTO"=>$buscar_produto_id->getId()));
        for($i=0; $i<count($consulta); $i++){
            $retorno['imagem'][$i] = $consulta[$i];
        }
        $nome_vendedor = $sql->select("select nome from usuario where id_usuario = :ID_USUARIO",
        array(
            "ID_USUARIO"=>$retorno[0]['id_vendedor']
            ));
        $retorno['nome_vendedor'] = $nome_vendedor[0]['nome'];
        echo json_encode($retorno);
    }
}

//Buscando um Produto pelo nome ou Pela descricao do produto
/*$search_produto = new Produto();
echo json_encode($search_produto->searchProduto("produto"));*/
//Alterando os dados do produto UPDATE
/*$update_produto = new Produto();
$update_produto->getProductById(7);
echo $update_produto;
$update_produto->update("New Name","8","new description" , "999","1");
echo $update_produto;*/
//Criando um Produto***************** O TIPO DO VALOR DO PRODUTO DEVE SER FLOAT

//Deletando um produto
/*$produto = new Produto();
$produto->getProductById(22);
$produto->delete();
echo $produto;*/