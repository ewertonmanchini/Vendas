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
$embalagens = $daoEmbalagem->todos();

ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Embalagem</h2>
        </div>
        <div class="row mb-2">
            <div class="col-md-12" >
                <a href="novo.php" class="btn btn-primary active" role="button" aria-pressed="true">Nova Embalagem</a>
            </div>
        </div>

<?php 
    if (count($embalagens) >0) 
    {
?>
        <div class="row">
            <div class="col-md-12" >

                <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
<?php 
        foreach($embalagens as $e) {
?>                    
                    <tr>
                        <th scope="row"><?php echo  $e->getId(); ?></th>
                        <td><?php echo $e->getNome(); ?></td>
                        <td>
                            <a class="btn btn-danger btn-sm active" 
                                href="apagar.php?id=<?php echo $e->getId();?>">
                                Apagar
                            </a>
                            <a class="btn btn-secondary btn-sm active" 
                                href="editar.php?id=<?php echo $e->getId();?>">
                                Editar
                            </a>                        
                        </td>
                    </tr>
<?php
        } // foreach
?>                    
                </tbody>
                </table>

            </div>
        </div>
<?php 
    
    }  // if 
?>        
    </div>
<?php

$content = ob_get_clean();
echo html( $content );
    
?>


