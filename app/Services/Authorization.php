<?php

namespace App\Services;

use App\Models\Post;
use Core\Router;

class Authorization {
	public static function verify(string $action, mixed $resource = null): void {
		if (!static::check($action, $resource)) {
			Router::forbidden();
		}
	}

	public static function check(string $action, mixed $resource = null): bool {
		$user = Auth::user();

		if (!$user) {
			return false; // Not logged in
		}

		if ('admin' === $user->role) {
			return true; // Admins have all permissions
		}

		return match($action) {
			'dashboard' => in_array($user->role, ['admin', 'superadmin']),
			'edit_post', 'delete_post' => $resource instanceof Post && $resource->user_id === $user->id 
			|| in_array($user->role, ['admin', 'superadmin']),
			'comment', 'create_post' => true, // All authenticated users can comment
			default => false
		};
	}
}
