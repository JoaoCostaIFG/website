<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
  private static string $blogsStorage = "blogs";

  public function show(Blog $b)
  {
    return redirect()->route('blog_pretty', ['b' => $b, 'title' => $b->getCleanTitle()]);
  }

  public function showPretty(Blog $b, string $title)
  {
    $cleanTitle = $b->getCleanTitle();
    if ($title !== $cleanTitle)
      return redirect()->route('blog_pretty', ['b' => $b, 'title' => $cleanTitle]);
    return view("pages.blog.post", ['b' => $b]);
  }

  public function new()
  {
    $b = Blog::factory()->create();
    return redirect(route('blog', ['b' => $b]));
  }

  public function editForm(Blog $b)
  {
    return view("pages.blog.edit", ['b' => $b]);
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
    return redirect(route('blog', ['b' => $b]));
  }

  public function imgUpload(Request $request)
  {
    $validatedData = $request->validate([
      'id' => ['required', 'integer'],
      'img' => ['required', 'image'],
    ]);

    $imgFile = $request->file('img');
    $path = explode("/", $imgFile->store("{$this::$blogsStorage}/{$validatedData['id']}"));
    $path = end($path);

    return response()->json(['path' => $path]);
  }

  public function imgList(int $id)
  {
    $files = array_map(function ($file): string {
      $tokens = explode("/", $file);
      return end($tokens);
    }, Storage::files("{$this::$blogsStorage}/{$id}"));

    return response()->json(['files' => $files]);
  }

  public function imgDelete(int $id, string $name)
  {
    $path = "{$this::$blogsStorage}/{$id}/{$name}";

    if (Storage::exists($path)) {
      Storage::delete($path);
      return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
  }
}
