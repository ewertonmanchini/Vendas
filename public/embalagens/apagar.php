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

// Se for confirmação, apago o registro e redireciono para o index.php
if (isset($_POST['id']) && isset($_POST['confirmacao'])) {
  $embalagem = $daoEmbalagem->porId( $_POST['id'] );
  $daoEmbalagem->remover( $embalagem );
  header('Location: ./index.php');
  exit;  // Termino a execucação desse script
}

// Se não for confirmação, exibo a confirmação
$embalagem = $daoEmbalagem->porId( $_GET['id'] );
if (! $embalagem )
    header('Location: ./index.php');
else {  
    ob_start();
?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Apagar Embalagem</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

              <form action="apagar.php" class="card p-2 my-4" method="POST">
                <input type="hidden" name="id" 
                  value="<?php echo $embalagem->getId(); ?>"
                >
                <div class="form-group">
                  <label for="embalagem">Deseja realmente apagar o embalagem abaixo?</label>
                  <input type="text" class="form-control" id="embalagem" aria-describedby="help" 
                    value="<?php echo $embalagem->getNome();?>" 
                    readonly
                  >
                  <small id="help" class="form-text text-muted">Esta operação não poderá ser desfeita.</small>
                </div>
                <div class="form-row">
                  <input type="submit" class="btn btn-danger ml-1" value="Apagar" name="confirmacao"/>
                  <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>
                </div>
              </form>

            </div>
        </div>
    </div>
<?php
    $content = ob_get_clean();
    echo html( $content );
} // else-if
