<?php
class Produto{
    private $id;
    private $nome;
    private $qtd_disponivel;
    private $descricao;
    private $valor_produto;
    private $id_vendedor;
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
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }
    public function getValorProduto(){
        return $this->valor_produto;
    }
    public function setValorProduto($valor_produto){
        $this->valor_produto = $valor_produto;
    }
    public function getIdVendedor(){
        return $this->id_vendedor;
    }
    public function setIdVendedor($id_vendedor){
        $this->id_vendedor = $id_vendedor;
    }
    public function getQtdDisponivel(){
        return $this->qtd_disponivel;
    }
    public function setQtdDisponivel($qtd_disponivel){
        $this->qtd_disponivel = $qtd_disponivel;
    }
    static function getListofProducts(){
        $sql = new Sql();
        return $sql->select("select * from produto");
    }
    public function getProductById($id_produto){
        $sql = new Sql();
        $resultado = $sql->select("select * from produto WHERE id_produto = :ID_PRODUTO", array(
            ":ID_PRODUTO"=>$id_produto
        ));
        if(count($resultado)>0){
            $row = $resultado[0];
            $this->constructProduto($row);
        }
        else{
            echo "Produto nao encontrado";
        }
    }
    static function searchProduto($keyword){
        $sql = new Sql();
        $resultado = $sql->select("SELECT * FROM produto WHERE nome_produto LIKE :NOME_PRODUTO or descricao_produto LIKE :DESCRICAO_PRODUTO",
        array(
            ":NOME_PRODUTO"=>"%".$keyword."%",
            ":DESCRICAO_PRODUTO"=>"%".$keyword."%"
        ));
        if(count($resultado)>0){
            return $resultado;
        }
        else{
            return array();
        }
    }
    public function update($nome,$qtd_disponivel, $descricao, $valor_produto, $id_vendedor){
        if($nome != $this->getNome()){
            $this->setNome($nome);
        }
        if($qtd_disponivel != $this->getQtdDisponivel()){
            $this->setQtdDisponivel($qtd_disponivel);
        }
        if($descricao != $this->getDescricao()){
            $this->setDescricao($descricao);
        }
        if($valor_produto != $this->getValorProduto()){
            $this->setValorProduto($valor_produto);
        }
        if($id_vendedor != $this->getIdVendedor()){
            $this->setIdVendedor($id_vendedor);
        }
        $sql = new Sql();
        $sql->query("UPDATE produto SET
        nome_produto = :NOME_PRODUTO, 
        qtd_disponivel = :QTD_DISPONIVEL, 
        descricao_produto = :DESCRICAO_PRODUTO,
        valor_produto = :VALOR_PRODUTO,
        id_vendedor = :ID_VENDEDOR
        WHERE id_produto = :ID_PRODUTO",
        array(            
            ":NOME_PRODUTO"=>$this->getNome(),
            ":QTD_DISPONIVEL"=>$this->getQtdDisponivel(),
            ":DESCRICAO_PRODUTO"=>$this->getDescricao(),
            ":VALOR_PRODUTO"=>$this->getValorProduto(),
            ":ID_VENDEDOR"=>$this->getIdVendedor(),
            ":ID_PRODUTO"=>$this->getId()
        ));
    }
    public function insert(){
        $sql = new Sql();
        $sql->query("INSERT INTO produto(nome_produto,qtd_disponivel,descricao_produto,valor_produto,id_vendedor )
        VALUES(:NOME_PRODUTO, :QTD_DISPONIVEL,:DESCRICAO_PRODUTO,:VALOR_PRODUTO,:ID_VENDEDOR)",
        array(
            ":NOME_PRODUTO"=>$this->getNome(),
            ":QTD_DISPONIVEL"=>$this->getQtdDisponivel(),
            ":DESCRICAO_PRODUTO"=>$this->getDescricao(),
            ":VALOR_PRODUTO"=>$this->getValorProduto(),
            ":ID_VENDEDOR"=>$this->getIdVendedor(),
        ));
        return $sql->returnLastId();
    }
    public function delete(){
        $sql = new Sql();
        $sql->query("DELETE FROM produto WHERE id_produto = :ID_PRODUTO",
            array(
                ":ID_PRODUTO"=>$this->getId()
            )
        );
        $this->setId(NULL);
        $this->setNome(NULL);
        $this->setQtdDisponivel(NULL);
        $this->setDescricao(NULL);
        $this->setIdVendedor(NULL);
        $this->setValorProduto(NULL);
    }
    public function constructProduto($data){
        $this->setId($data['id_produto']);
        $this->setNome($data['nome_produto']);
        $this->setQtdDisponivel($data['qtd_disponivel']);
        $this->setDescricao($data['descricao_produto']);
        $this->setIdVendedor($data['id_vendedor']);
        $this->setValorProduto($data['valor_produto']);
    }
    public function __toString(){
        return json_encode(array(
            "id"=>$this->getId(),
            "nome"=>$this->getNome(),
            "qtd_disponivel"=>$this->getQtdDisponivel(),
            "valor"=>$this->getValorProduto(),
            "descricao"=>$this->getDescricao(),
            "id_vendedor"=>$this->getIdVendedor()
        ));
    }
    public function __construct($nome = "",$qtd_disponivel = "", $descricao = "", $valor_produto = "", $id_vendedor = ""){
        $this->nome = $nome;
        $this->qtd_disponivel = $qtd_disponivel;
        $this->descricao = $descricao;
        $this->id_vendedor = $id_vendedor;
        $this->valor_produto = $valor_produto;
    }
}


?>
