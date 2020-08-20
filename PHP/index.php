<?php
require_once("config.php");
session_start();


//////USUARIO
if(isset($_POST['login'])){
    $sql = new Sql();
    $email = $_POST['email'];
    $password = $_POST['senha'];
    if(count(Usuario::verificaEmail($email)) == 0){
        echo json_encode(0);
    }
    else{
        $sql = new Sql();
        $dados_usuario = $sql->select("select * from usuario WHERE email = :EMAIL", array(
            ":EMAIL"=>$email
        ));
        $senha_banco = $dados_usuario[0]["senha"];
            if(password_verify($password, $senha_banco)){
            //Criptografando a sessão do usuário
            session_put_user_data($dados_usuario[0]["id_usuario"],$dados_usuario[0]["nome"],$dados_usuario[0]["email"]);
            echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }
    }
}
//DESLIGANDO USUÁRIO
if(isset($_POST['deslogando'])){
    logout();
    if(!isset($_SESSION['user_data'])){
        $resultado = array(
            "resultado"=>1
        );
    }
    else{
        $resultado = array(
            "resultado"=>0
        );
    }
    echo json_encode($resultado);
}
//CADASTRANDO USUÁRIO
if(isset($_POST['cadastro'])){
    //Primeiro verificaremos se existe algum email
    if(count(Usuario::verificaEmail($_POST['email'])) == 1){
        echo json_encode(1);
    }
    else{
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $new_user = new Usuario($_POST['nome'], $_POST['data_nascimento'], $_POST['email'], $senha);
        $new_user->insert();
        echo json_encode(0);
    }
    
}
//Verificando se usuário está logado
if(isset($_POST["verifica_sessao"])){
    echo json_encode(verify_user_session());
}
//Pegando dados do usuário para ser editado
if(isset($_POST['request_user_data'])){
    if(isset($_SESSION['user_data'])){   
    $sql = new Sql();
    $consulta = $sql->select("select nome, email, data_nascimento from usuario WHERE id_usuario = :ID_USUARIO",
    array(
        ":ID_USUARIO"=>$_SESSION['user_data']['id']
    ));
    echo json_encode($consulta[0]);
    }
    else{
        echo json_encode(array(
            "vazio"=>0
        ));
    }
}
//EDITANDO USUÁRIO
if(isset($_POST['editar_usuario'])){
    if(isset($_SESSION['user_data'])){
        if($_POST['editar_usuario'] == 0){//Se for zero editaremos somente Nome e data de nascimento
            $sql = new Sql();
            $consulta = $sql->select("SELECT nome, data_nascimento FROM usuario WHERE id_usuario = :ID_USUARIO",
            array(
                ":ID_USUARIO"=>$_SESSION['user_data']['id']
            ));
            if($consulta[0]['nome'] != $_POST['nome'] ||  $consulta[0]['data_nascimento'] != $_POST['data_nascimento']){
                $sql->query("UPDATE usuario SET nome = :NOME, data_nascimento = :DATA_NASCIMENTO WHERE id_usuario = :ID_USUARIO"
                ,array(
                    ":NOME"=>$_POST['nome'],
                    ":DATA_NASCIMENTO"=>$_POST['data_nascimento'],
                    ":ID_USUARIO"=>$_SESSION['user_data']['id']
                ));
                $_SESSION['user_data']['nome'] = $_POST['nome'];
                echo json_encode(array(
                    "edicao"=>1,
                    "alterar_nome"=>$_SESSION['user_data']['nome']
                ));
            }
            else{
                echo json_encode(array(
                    "edicao"=>0
                ));
            }
        }
        else{//Se nao for zero editaremos a senha do usuário também
            $sql = new Sql();
            $consulta = $sql->select("SELECT * FROM usuario WHERE id_usuario = :ID_USUARIO", array(
                ":ID_USUARIO"=>$_SESSION['user_data']['id']
            ));
            if(password_verify($_POST['old_senha'], $consulta[0]['senha'])){
                $sql->query("UPDATE usuario SET nome = :NOME, data_nascimento = :DATA_NASCIMENTO, senha = :SENHA WHERE id_usuario = :ID_USUARIO"
                ,array(
                    ":NOME"=>$_POST['nome'],
                    ":DATA_NASCIMENTO"=>$_POST['data_nascimento'],
                    ":SENHA"=>password_hash($_POST['new_senha'], PASSWORD_DEFAULT),
                    ":ID_USUARIO"=>$_SESSION['user_data']['id']
                ));
                $_SESSION['user_data']['nome'] = $_POST['nome'];
                echo json_encode(array(
                    "edicao"=>1,
                    "alterar_nome"=>$_SESSION['user_data']['nome']
                ));
            }            
            else{
                echo json_encode(array(
                    "edicao"=>0
                ));
            }
        }
    }
    else{
        echo json_encode(array(
            "vazio"=>0
        ));
    }
}


/////////////PRODUTOS/////////
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
    //$descricao = str_replace('"', "'", $_POST['descricao']);
    //echo $descricao;
    $novo_produto = new Produto(
        $_POST['nome'],
        $_POST['qtd_disponivel'],
        0,
        $_POST['valor'],
        $_SESSION['user_data']['id']
    );
    $descricao =  $_POST['descricao'];
    $lastId = $novo_produto->insert();
    //Count total files
    //Criando arquivo se ele nao existir
    $dir = "..".DIRECTORY_SEPARATOR."descricao";
    //Caminho onde será salvo o arquivo txt e o nome do arquivo com o nome do ultimo id inserido
    $fileName = $dir.DIRECTORY_SEPARATOR."descricao".$lastId.".txt";
    //se o caminho do arquivo nao existir, será criado
    if(!is_dir($dir)){
        mkdir($dir, 0777);
    }
    //Colocando a  descricao  dentro  do   arquivo
    file_put_contents($fileName,$descricao);
    //Lendo  o arquivo  de volta
    $countfiles = count($_FILES['files']['name']);
    // Upload directory
    $upload_location = "../upload_images/";
    if(!is_dir($upload_location)){
        mkdir($upload_location,0777);
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
    $files_arr['last_id'] = $lastId;
    echo json_encode($files_arr);
}
//Mostrando somente um produto
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
        $fileName = "..".DIRECTORY_SEPARATOR."descricao".DIRECTORY_SEPARATOR."descricao".$retorno[0]['id_produto'].".txt";
        $descricao =  file_get_contents($fileName);
        $retorno['descricao'][0] = $descricao;
        echo json_encode($retorno);
    }
}
//Editando Produto
//Mostrando dados do produto a partir do produto que o usuário criou
if(isset($_POST['produtos_usuario'])){
    $sql = new Sql();
    $consulta = $sql->select("SELECT * FROM produto WHERE id_vendedor = :ID_VENDEDOR", array(
        ":ID_VENDEDOR"=>$_SESSION['user_data']['id']
    ));
    for($i=0; $i<count($consulta); $i++){
        $descricao = file_get_contents("../descricao/descricao".$consulta[$i]['id_produto'].".txt");
        $consulta[$i]['descricao'] = $descricao;
    }
    if(count($consulta) > 0){
        echo json_encode($consulta);
    }
    else{
        echo json_encode(array(
            "vazio"=>0
        ));
    }    
}
//Mostrando os dados do produto para o usuário  poder digitar
if(isset($_POST['editar_produto'])){
    if(!$_SESSION['user_data']){
        echo json_encode(array(
            "erro"=>3
        ));
    }
    else{    
        $sql = new Sql();
        $consulta = $sql->select("SELECT * FROM produto WHERE id_produto = :ID_PRODUTO",array(
            ":ID_PRODUTO"=>$_POST['id_produto']
        ));
        if(count($consulta) > 0){
            if($consulta[0]['id_vendedor'] == $_SESSION['user_data']['id']){
                $descricao = file_get_contents("../descricao/descricao".$consulta[0]['id_produto'].".txt");
                $consulta[0]['descricao'] = $descricao;  
                echo json_encode($consulta[0]);
            }
            else{
                echo json_encode(array(
                    "erro"=>2
                ));
            }
        }
        else{
            echo json_encode(array(
                "erro"=>1
            ));
        }
    }
     
}
//Salvando Edições do produto
if(isset($_POST['editar_produto=1'])){
    $sql = new Sql();
    
}


//FUNÇÕES PARA SESSÃO
function session_put_user_data($id_usuario,$nome_usuario,$email_usuario){          
    $usuario = array(
        "id"=>$id_usuario,
        "nome"=>$nome_usuario,
        "email"=>$email_usuario
    );
   $_SESSION['user_data'] = $usuario;
}
function verify_user_session(){
    if(!$_SESSION){
        return json_encode(0);
    }
    else{
        $usuario = array(
            "id"=>$_SESSION['user_data']['id'],
            "nome"=>$_SESSION['user_data']['nome'],
            "email"=>$_SESSION['user_data']['email']);
        return $usuario;            
    }
}
function logout(){
    unset($_SESSION['user_data']);
}

