<?php 
require_once(__DIR__ . '/../model/Embalagem.php');
require_once(__DIR__ . '/../db/Db.php');

// Classe para persistencia de Embalagem - copia departamento
// DAO - Data Access Object
class DaoEmbalagem {
    
  private $connection;

  public function __construct(Db $connection) {
      $this->connection = $connection;
  }
  
  public function porId(int $id): ?Embalagem {
    $sql = "SELECT nome FROM embalagens where id = ?";
    $stmt = $this->connection->prepare($sql);
    $dep = null;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $nome = '';
        $stmt->bind_result($nome);
        $stmt->store_result();
        if ($stmt->num_rows == 1 && $stmt->fetch()) {
          $dep = new Embalagem($nome, $id);
        }
      }
      $stmt->close();
    }
    return $dep;
  }

  public function inserir(Embalagem $embalagem): bool {
    $sql = "INSERT INTO embalagens (nome) VALUES(?)";
    $stmt = $this->connection->prepare($sql);
    $res = false;
    if ($stmt) {
      $nome = $embalagem->getNome();
      $stmt->bind_param('s', $nome);
      if ($stmt->execute()) {
          $id = $this->connection->getLastID();
          $embalagem->setId($id);
          $res = true;
      }
      $stmt->close();
    }
    return $res;
  }

  public function remover(Embalagem $embalagem): bool {
    $sql = "DELETE FROM embalagens where id=?";
    $id = $embalagem->getId(); 
    $stmt = $this->connection->prepare($sql);
    $ret = false;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  public function atualizar(Embalagem $embalagem): bool {
    $sql = "UPDATE embalagens SET nome = ? WHERE id = ?";
    $stmt = $this->connection->prepare($sql);
    $ret = false;      
    if ($stmt) {
      $nome = $embalagem->getNome();
      $id   = $embalagem->getId();
      $stmt->bind_param('si', $nome, $id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  
  public function todos(): array {
    $sql = "SELECT id, nome from embalagens";
    $stmt = $this->connection->prepare($sql);
    $embalagem = [];
    if ($stmt) {
      if ($stmt->execute()) {
        $id = 0; $nome = '';
        $stmt->bind_result($id, $nome);
        $stmt->store_result();
        while($stmt->fetch()) {
          $embalagem[] = new Embalagem($nome, $id);
        }
      }
      $stmt->close();
    }
    return $embalagem;
  }

};
