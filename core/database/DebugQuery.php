<?php 
namespace App\Core\Database;

use PDOStatement;

class DebugQuery extends PDOStatement
{
  protected $_debugValues = null;

  protected function __construct()
  {
   
  }

  public function execute($values=array())
  {
    $this->_debugValues = $values;
    try {
      $t = parent::execute($values);
    } catch (PDOException $e) {
      throw $e;
    }

    return $t;
  }

  public function _debugQuery($replaced=true)
  {
    $q = $this->queryString;

    if (!$replaced) {
      return $q;
    }

    return preg_replace_callback('/:([0-9a-z_]+)/i', array($this, '_debugReplace'), $q);
  }

  protected function _debugReplace($m)
  {
    $v = $this->_debugValues[$m[1]];
    if ($v === null) {
      return "NULL";
    }
    if (!is_numeric($v)) {
      $v = str_replace("'", "''", $v);
    }

    return "'". $v ."'";
  }
}