<?php

namespace App\Services;

use App\Models\User;

class Auth {
	protected static $user = null;

	public static function attempt(string $email, string $password, bool $remember): bool {
		$user = User::findByEmail($email);
		if ($user && password_verify($password, $user->password)) {
			// Mark the user as being signed in
			session_regenerate_id(true); // Regenerate session ID to prevent session fixation
			$_SESSION['user_id'] = $user->id;
			// Authentication successful
			if ($remember) {
				// If remember me is checked, create a remember token
				RememberMe::createToken($user->id);
			}
			return true;
		}

		// Authentication failed
		return false;
	}

	public static function user(): ?User {
		if (static::$user === null) {
			$userId = $_SESSION['user_id'] ?? null;
			static::$user = $userId ? User::find($userId) : RememberMe::user();
			// if (!isset($_SESSION['user_id']) && static::$user) {
			// 	// If user is found via RememberMe, set session user_id
			// 	$_SESSION['user_id'] = static::$user->id;
			// }
		}
		return static::$user;
	}

	public static function logout(): void {
		// Clear the session and remember me token
		RememberMe::clearToken();
		session_unset();
		session_destroy();
		static::$user = null;
	}

	public static function increase(): int {
		if (!isset($_SESSION['incInt'])) {
			$_SESSION['incInt'] = 0;
		}
		
		return $_SESSION['incInt']++;
	}

}
