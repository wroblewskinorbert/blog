<?php

namespace App\Midlewares;

use App\Services\Auth as ServicesAuth;
use Core\Middleware;
use Core\View as CoreView;

class View implements Middleware {

  public function handle(callable $next): mixed {
    // Share the user data with the view
		error_log('Uruchomiono View middleware');
    CoreView::share('user', ServicesAuth::user());
    return $next();
  }
}