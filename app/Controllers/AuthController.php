<?php

namespace App\Controllers;

use App\Services\Auth;
use App\Services\CSRF;
use Core\Router;
use Core\View;

class AuthController {
	public function create() {
		return \Core\View::render(
			template: 'auth/create',
			data: [],
			layout: 'layouts/main'
		);
	}

	public function store() {
		// Todo: CSRF token
		// if (!CSRF::verify()) {
		// 	Router::pageExpired();
		// }
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';
		$remember = isset($_POST['remember']) ? (bool) $_POST['remember'] : false;
		if (Auth::attempt($email, $password, $remember)) {
			Router::redirect('/');
		}
	
		return View::render(
				template: 'auth/create',
				data: [
					'error' => 'Invalid email or password'
				],
				layout: 'layouts/main'
			);
	}

	public function destroy() {
		Auth::logout();
		Router::redirect('/login');
	}
	
}