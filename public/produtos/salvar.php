<?php

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Produto.php');
require_once(__DIR__ . '/../../dao/DaoProduto.php');
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../model/Embalagem.php');
require_once(__DIR__ . '/../../dao/DaoEmbalagem.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);
$daoEmbalagem = new DaoEmbalagem($conn);
$daoProduto = new DaoProduto($conn);

$marca = $daoMarca->porId( $_POST['marca'] );
$embalagem = $daoEmbalagem->porId( $_POST['embalagem'] );

$novoProduto = new Produto($_POST['nome'], $_POST['preco'], $_POST['estoque'], $marca, $embalagem);

if ($daoProduto->inserir( $novoProduto) ) {
    $daoProduto->sincronizarDepartamentos($novoProduto, $_POST['departamentos']);
}
    
header('Location: ./index.php');

?>


