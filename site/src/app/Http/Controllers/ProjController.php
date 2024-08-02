<?php

namespace App\Http\Controllers;

use App\Models\Proj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjController extends Controller
{
    private static function imgName(string $title, string $hashName): string
    {
        $cleanTitle = strtolower(preg_replace("/[^A-Za-z0-9\-_]/", '', $title));

        return "{$cleanTitle}_{$hashName}";
    }

    public function new(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'url' => ['required', 'url'],
            'description' => ['nullable', 'string'],
            'img' => ['required', 'image'],
        ]);

        if (! isset($validatedData['description'])) {
            unset($validatedData['description']);
        }

        $imgFile = $request->file('img');
        $validatedData['img'] = $this->imgName($validatedData['title'], $imgFile->hashName());
        Proj::create($validatedData);
        $imgFile->storeAs('projects', $validatedData['img']);

        return redirect(route('projects'));
    }

    public function editForm(Proj $p)
    {
        return view('pages.proj.edit', ['p' => $p]);
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

        if (isset($validatedData['img'])) {
            $imgFile = $request->file('img');
            $imgFileName = $this->imgName($validatedData['title'], $imgFile->hashName());
            Storage::delete("projects/{$p->img}");

            $imgFile->storeAs('projects', $imgFileName);
            $p->img = $imgFileName;
            $p->save();
        }

        return redirect(route('projects'));
    }
}
