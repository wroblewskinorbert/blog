<?php

namespace App\Services;


class CSRF {
	private const int CSRF_TOKEN_LENGTH = 32;
	private const int TOKEN_LIFE = 60 * 30;
	public const string TOKEN_FIELD_NAME = '_token';

	public static function getToken(): string {
		if (!isset($_SESSION['csrf_token']) || static::isTokenExpired()) {
			return static::generateToken();
		}
		return $_SESSION['csrf_token']['token'];
	}

	public static function verify(?string $token = null): bool {
		$method = $_SERVER['REQUEST_METHOD'];
		if (in_array($method,['GET', 'HEAD', 'OPTIONS'])) {
			// CSRF token is not required for safe methods
			return true;
		}

		$csrfToken = $token ?? $_POST[static::TOKEN_FIELD_NAME] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

		if (!empty($csrfToken) && !static::isTokenExpired() && hash_equals($csrfToken, $_SESSION['csrf_token']['token'] ?? '')) {
			static::generateToken();
			return true;
		}

		return false;
	}

	private static function isTokenExpired(): bool {
		$expires = $_SESSION['csrf_token']['expires'] ?? null;
		return !isset($expires) || $expires < time();
	}

	private static function generateToken(): string {
		$token = bin2hex(random_bytes(static::CSRF_TOKEN_LENGTH));
		$_SESSION['csrf_token'] = [
			'token' => $token,
			'expires' => time() + static::TOKEN_LIFE,
		];
		return $token;
	}

	// protected static $token = null;

	// 	public static function generateToken(): string {
	// 			if (static::$token === null) {
	// 					static::$token = bin2hex(random_bytes(32));
	// 			}
	// 			return static::$token;
	// 	}

	// 	public static function validateToken(string $token): bool {
	// 			return hash_equals(static::getToken(), $token);
	// 	}

	// 	public static function getToken(): string {
	// 			return static::$token ?? static::generateToken();
	// 	}

	// 	public static function clearToken(): void {
	// 			static::$token = null;
	// 	}
}