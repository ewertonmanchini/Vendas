<?php

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Embalagem.php');
require_once(__DIR__ . '/../../dao/DaoEmbalagem.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoEmbalagem = new DaoEmbalagem($conn);
$daoEmbalagem->inserir( new Embalagem($_POST['nome']));
    
header('Location: ./index.php');

?>