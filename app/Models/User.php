<?php
namespace Dev\App\Models;

use Dev\Implementations\Model;
use Dev\Implementations\Exceptions\DbException;

class User extends Model
{
	protected $table = "users";

	/**
	 * Возвращает запись с указанным email
	 * @param  string $email
	 * @return array       
	 */
	public function findByEmail($email)
	{
		try {
						
			$query = "SELECT * FROM $this->table WHERE email LIKE :email;";
			
			$sth = $this->_dbh->prepare($query);
			$sth->bindParam('email', $email);
			$sth->setFetchMode(\PDO::FETCH_ASSOC);
			$sth->execute();
			
			return $sth->fetch();

		} catch(\PDOException $e) {
			throw new DbException($e->getMessage(), 500, $e);
		}
	}

	/**
	 * В качестве параметра принимает массив и сохраняет его в базу
	 * возвращает id записи или false в случае неудачи
	 * @param  array  $param
	 * @return int|bool
	 */
	public function storeNew(array $param) 
	{
		try {
			$query = "INSERT INTO $this->table (name, email, image, password) values (?,?,?,?)";

			$sth = $this->_dbh->prepare($query);
			if($sth->execute($param)) 
			{
				return $this->_dbh->lastInsertId();
			} else {
				return false;
			}

		} catch(\PDOException $e) {
			throw $e;
		}
	}
}