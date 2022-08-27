<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Proj;

class ProjController extends Controller
{
  public function new(Request $request)
  {
    $validatedData = $request->validate([
      'title' => ['required', 'string'],
      'url' => ['required', 'url'],
      'description' => ['nullable', 'string'],
      'img' => ['required', 'image'],
    ]);

    if (!isset($validatedData['description'])) {
      unset($validatedData['description']);
    }

    print_r($request->file('img')->path());
    print_r($request->file('img')->extension());
    die();
    Proj::create($validatedData);

    return redirect(route('projects'));
  }

  public function editForm($id)
  {
    $p = Proj::find($id);
    return view("pages.proj.edit", ['p' => $p]);
  }

  public function edit(Request $request)
  {
    $validatedData = $request->validate([
      'id' => ['required', 'integer'],
      'title' => ['nullable', 'string'],
      'url' => ['nullable', 'url'],
      'description' => ['nullable', 'string'],
      'img' => ['nullable', 'image'],
    ]);

    $p = Proj::find($validatedData['id']);

    if (isset($validatedData['title'])) {
      $p->title = $validatedData['title'];
    }
    if (isset($validatedData['url'])) {
      $p->url = $validatedData['url'];
    }
    if (isset($validatedData['description'])) {
      $p->description = $validatedData['description'];
    }

    $p->save();
    return redirect(route('projects'));
  }
}
