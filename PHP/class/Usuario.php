<?php
class Usuario{
    private $id;
    private $nome;
    private $data_nascimento;
    private $email;
    private $senha;
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getDataNascimento(){
        return $this->data_nascimento;
    }
    public function setDataNascimento($data_nascimento){
        $this->data_nascimento = $data_nascimento;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
         $this->email = $email;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getUserById($id){
        $sql = new Sql();
        $resultado = $sql->select("select * from usuario where id_usuario = :ID", array(
            ":ID"=>$id
        ));
        if(count($resultado) > 0){
            $row = $resultado[0];
            $this->constructUser($row);
        }
    }
    static function verificaEmail($email){
       $sql = new Sql();
       return $sql->select("select email from usuario where email = :EMAIL", array(
           ":EMAIL"=>$email
       ));
    }
    static function searchUserByName($name){
        $sql = new Sql();
        return $sql->select("select * from usuario WHERE nome LIKE :NOME ORDER BY id_usuario" ,array(
            ":NOME"=>"%".$name."%"
        ));
    }
    public function constructUser($data){
        $this->setId($data['id_usuario']);
        $this->setNome($data['nome']);
        $this->setDataNascimento($data['data_nascimento']);
        $this->setEmail($data['email']);
        $this->setSenha($data['senha']);
    }
    public function getUserByAuth($email, $password){
        $sql = new Sql();
        $resultado = $sql->select("select * from usuario WHERE email = :EMAIL AND senha = :SENHA",array(
            ":EMAIL"=>$email,
            ":SENHA"=>$password
        ));
        if(count($resultado) > 0){
            $row = $resultado[0];
            $this->constructUser($row);
        }
        else{
            echo "Email ou senha incorretos";
        }
    }
    public function insert(){
        $sql = new Sql();
        $sql->query("insert into usuario (nome, data_nascimento, email, senha)  values(:NOME,:DATA_NASCIMENTO,:EMAIL,:SENHA)",array(
            ":NOME"=>$this->getNome(),
            ":DATA_NASCIMENTO"=>$this->getDataNascimento(),
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha(),
        ));
    }
    public function update($nome, $data_nascimento, $email, $senha){     
        //Primeiramente ele verifica se as os dados passados são diferentes dos que já estão no objeto
        //Se for diferente ele trocará   
        if($nome != $this->getNome()){
            $this->setNome($nome);
        }
        if($data_nascimento != $this->getDataNascimento()){
            $this->setDataNascimento($data_nascimento);
        }
        if($email != $this->getEmail()){
            $this->setEmail($email);
        }
        if($senha != $this->getSenha()){
            $this->setSenha($senha);
        }
        //Depois que os dados forem trocados ou não, ele executará a query
        $sql = new Sql();
        $sql->query("UPDATE usuario SET nome = :NOME,data_nascimento = :DATA_NASCIMENTO, email = :EMAIL, senha = :SENHA WHERE id_usuario = :ID",
            array(
                ":NOME"=>$this->getNome(),
                ":DATA_NASCIMENTO"=>$this->getDataNascimento(),
                ":EMAIL"=>$this->getEmail(),
                ":SENHA"=>$this->getSenha(),
                ":ID"=>$this->getId()
                )
            );
    }
    public function deleteUser(){
        $sql = new Sql();
        $sql->query("DELETE FROM usuario WHERE id_usuario = :ID",
        array(
            ':ID'=>$this->getId()
        ));
        $this->setId(NULL);
        $this->setNome(NULL);
        $this->setDataNascimento(NULL);
        $this->setEmail(NULL);
        $this->setSenha(NULL);
    }
    public function __toString(){
        return json_encode(array(
            'id'=>$this->getId(),
            'nome'=>$this->getNome(),
            'data_nascimento'=>$this->getDataNascimento(),
            'email'=>$this->getEmail(),
            'senha'=>$this->getSenha(),
        ));
    }
    public function __construct($nome = "", $data_nascimento = "", $email = "", $senha = ""){
        $this->setNome($nome);
        $this->setDataNascimento($data_nascimento);
        $this->setEmail($email);
        $this->setSenha($senha);
    }
}
?>