<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use Core\View;
// use Exception;

class HomeController {
  public function index() {
    // throw new Exception("This has happened on the web!");
    $posts = Post::getRecent(5);
    // var_dump($posts); die;
    return View::render(
      template: 'home/index', 
      data: [
        'posts' => $posts
      ], 
      layout: 'layouts/main');
  }
}