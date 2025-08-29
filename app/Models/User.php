<?php

namespace App\Models;

use Core\App;
use Core\Model;
//** @var $db = core\Database */

class User extends Model {
	protected static $table = 'users';
	
	// public int $id;
	public string $name;
	public string $email;
	public string $password;
	public string $role;
	public string $created_at;

	public static function findByEmail(string $email):?User {
		$db = App::get('database');
		$queryString = "SELECT * FROM " . static::$table . " WHERE email = ?";
		$user = $db->fetch($queryString, [$email], static::class);
		return $user ? $user : null;
	}

}
