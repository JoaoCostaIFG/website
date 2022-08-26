<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
  public function show($id)
  {
    $b = Blog::find($id);
    return view("pages.blog.post", ['b' => $b]);
  }

  public function editForm($id)
  {
    $b = Blog::find($id);
    return view("pages.blog.edit", ['b' => $b]);
  }

  public function new(Request $request)
  {
    $validatedData = $request->validate([
      'title' => ['required', 'string'],
      'date' => ['nullable', 'date'],
      'visible' => ['nullable', 'string'],
      'intro' => ['nullable', 'string'],
      'content' => ['required', 'string'],
    ]);

    if (!isset($validatedData['date'])) {
      unset($validatedData['date']);
    }

    if (isset($validatedData['visible']) && $validatedData['visible'] === "on") {
      $validatedData['visible'] = true;
    } else {
      unset($validatedData['visible']);
    }

    $b = Blog::create($validatedData);

    return redirect(route('blog', ['id' => $b->id]));
  }

  public function edit(Request $request)
  {
    $validatedData = $request->validate([
      'id' => ['required', 'integer'],
      'title' => ['nullable', 'string'],
      'date' => ['nullable', 'date'],
      'visible' => ['nullable', 'string'],
      'intro' => ['nullable', 'string'],
      'content' => ['nullable', 'string'],
    ]);

    $b = Blog::find($validatedData['id']);

    if (isset($validatedData['title'])) {
      $b->title = $validatedData['title'];
    }
    if (isset($validatedData['date'])) {
      $b->date = $validatedData['date'];
    }
    if (isset($validatedData['visible']) && $validatedData['visible'] === "on") {
      $validatedData['visible'] = true;
    } else {
      $validatedData['visible'] = false;
    }
    if (isset($validatedData['intro'])) {
      $b->intro = $validatedData['intro'];
    }
    if (isset($validatedData['content'])) {
      $b->content = $validatedData['content'];
    }

    $b->save();
    return redirect(route('blog', ['id' => $b->id]));
  }
}
