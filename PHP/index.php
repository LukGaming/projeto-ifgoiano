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
        echo json_encode(Produto::getListofProducts());
    }
    else{    
        $keyword = $_GET['keyword'];    
       echo json_encode(Produto::searchProduto($keyword)); 
    }
}
//CADASTRANDO PRODUTO
if(isset($_POST["createProduct"])){//$countfiles = count($_FILES['files']['name'])
        $novo_produto = new Produto(
        $_POST['nome'],
        $_POST['qtd_disponivel'],
        $_POST['descricao'],
        $_POST['valor'],
        1   //este é o id do usuário
    );
    echo $novo_produto->insert();
}
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
        
        // Check extension
        if(in_array($ext, $valid_ext)){
        
            // File path
            $path = $upload_location.$filename;
        
            // Upload file
            if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$path)){
                $files_arr[] = $path;
            }
        }
        }
        echo json_encode($files_arr);
        die;


//Buscando dados somente de um produto pelo ID.
/*$buscar_produto_id = new Produto();
$buscar_produto_id->getProductById(5);
echo $buscar_produto_id;*/
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