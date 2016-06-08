<?php
namespace Dev\Interfaces;

interface Model {
	/**
	 * Get all models from the database
	 * @return Dev\Interfaces\Model
	 */
	public function all();

	/**
	 * Find a model by the ID
	 * @param  number $id
	 * @return Dev\Interfaces\Model
	 */
	public function findOne($id);
}