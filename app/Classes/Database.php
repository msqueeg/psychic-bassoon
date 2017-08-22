<?php
namespace Msqueeg\Classes;
/**
* 
*/
class Database
{
	protected $pdo;
	protected $tableName;
	
	function __construct($pdo)
	{
		$this->pdo = $pdo;
		$this->$tableName = get_class($this);
	}

	protected function _bindFields($fields)
	{
		end($fields); $lastField = key($fields);
		$bindString = '';

		foreach($fields as $field=>$data) {
			$bindString .= $field . '=:' . $field;
			$bindString .=($field === $lastField ? '' : ',');
		}

		return $bindString;
	}

	public function getAll($orderby)
	{
		$sth = $this->pdo->prepare("SELECT * FROM $this->tableName ORDER BY ". $orderby);
		$sth->execute();
		return $sth->fetchAll();
		
	}

	public function getByField(Array $fieldValueArray)
	{
		$field = key($fieldValueArray);
		$value = $fieldValueArray[$field];

		$sql = "SELECT * FROM $this->tableName WHERE $field = :value";

		$sth = $this->pdo->prepare($sql);
		$sth->bindParam("value",$value);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function getById($id)
	{
		$sth = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE ".$this->tableName."_id = :id");
		$sth->bindParam("id", $id);
		$sth->execute();
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}


}