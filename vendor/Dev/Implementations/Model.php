<?php
namespace Dev\Implementations;

use Dev\Interfaces\Model as ModelInterface;
use Dev\Interfaces\Config as ConfigInterface;
use Dev\Implementations\Exceptions\DbException;

/**
 * Класс для работы с бд.
 * Для работы с ним необходимо в классах наследниках 
 * переопределить свойство $table
 */
abstract class Model implements ModelInterface
{
	protected $_dbh = null;
	protected $table = null;
	
	function __construct(ConfigInterface $config)
	{
		try {
			$host 	= $config->get("DB_HOST");
			$dbname = $config->get("DB_DATABASE");
			$user 	= $config->get("DB_USERNAME");
			$pass 	= $config->get("DB_PASSWORD");

			// Инициализируем Database Handler
			$this->_dbh = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
			$this->_dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		} catch(\PDOException $e) 
		{
			throw new DbException($e->getMessage(), 500, $e);
		}
	}

	function __destruct()
	{
		$this->_dbh = null;
	}

	/**
	 * Возвращает все записи из таблицы
	 * @return array
	 */
	public function all() 
	{
		try {
			$query = "SELECT * FROM $this->table;";
			$sth = $this->_dbh->query($query);
			$sth->setFetchMode(\PDO::FETCH_ASSOC);

			$arr = array();
			while ($row = $sth->fetch()) {
				$arr[] = $row;
			}

			return $arr;
			
		} catch(\PDOException $e) {
			throw new DbException($e->getMessage(), 500, $e);
		}
	}

	/**
	 * Найти запись по id
	 * @param  int $id
	 * @return
	 */
	public function findOne($id) 
	{
		try {
			if(!is_int($id)) throw new DbException("Wrong parameter", 500);
			
			$query = "SELECT * FROM $this->table WHERE id = :id;";
			
			$sth = $this->_dbh->prepare($query);
			$sth->bindParam('id', $id);
			$sth->setFetchMode(\PDO::FETCH_ASSOC);
			$sth->execute();
			
			return $sth->fetch();

		} catch(\PDOException $e) {
			throw new DbException($e->getMessage(), 500, $e);
		}
	}
}