<?php

namespace App\Midlewares;

use App\Services\Auth as ServicesAuth;
use Core\Middleware;
use Core\Router;

class Auth implements Middleware {
	public function handle(callable $next)
	{
		error_log('Uruchomiono Auth middleware');
		$user = ServicesAuth::user();
		if (!$user) {
			// Redirect to login if not authenticated
			Router::unauthorized();
		}
		return $next();
	}
}