<?php

/**
 * User model
 */
class User extends BaseModel{

	// Define neccessary constansts so we know from which table to load data
	const tableName = 'users';
	// ClassName constant is important for find and findOne static functions to work
	const className = 'User';

	// Create getter functions

	public function getName() {
		return $this->getField('name');
	}

	public function getEmail() {
		return $this->getField('email');
	}

	public function getCity() {
		return $this->getField('city');
	}

  public static function findByCity($db, $city) {
    $query = "SELECT `id`, `name`, `email`, `city` FROM `users` WHERE `city` LIKE " . self::escapeValue($city . '%');
    return self::sql($db, $query);
  }

  public static function findAll($db) {
    return self::find($db, '*');
  }
}
