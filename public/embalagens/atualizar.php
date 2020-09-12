<?php

require_once(__DIR__ . '/../../templates/template-html.php');

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Embalagem.php');
require_once(__DIR__ . '/../../dao/DaoEmbalagem.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoEmbalagem = new DaoEmbalagem($conn);
$Embalagem = $daoEmbalagem->porId( $_POST['id'] );
    
if ( $Embalagem )
{  
  $Embalagem->setNome( $_POST['nome'] );
  $daoEmbalagem->atualizar( $Embalagem );
}

header('Location: ./index.php');