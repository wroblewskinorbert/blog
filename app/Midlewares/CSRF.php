<?php

namespace App\Midlewares;

use App\Services\CSRF as ServicesCSRF;
use Core\Middleware;
use Core\Router;

class CSRF implements Middleware {
	public function handle(callable $next)
	{
		error_log('Uruchomiono CSRF middleware');
		if(!ServicesCSRF::verify()) {
			Router::pageExpired();
		}
		return $next();
	}
}