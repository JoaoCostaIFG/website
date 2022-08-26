<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
  public function show($id)
  {
    $b = Blog::find($id);
    return view("pages.blog.post", ['b' => $b]);
  }

  public function edit($id)
  {
    $b = Blog::find($id);
    return view("pages.blog.edit", ['b' => $b]);
  }
}
