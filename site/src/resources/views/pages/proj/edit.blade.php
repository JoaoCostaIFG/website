@extends('layouts.layout', [ 'title' => 'Edit project' ])

@section('content')

<?php

use App\Models\Proj; ?>

<h1>Edit blog post</h1>

<div class="w-full">
  <form class="m-auto max-w-prose" method="POST" action="{{ route('project_edit_action') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="id" name="id" value="{{ $p->id }}">

    <div>
      <label class="form-label form-label-required" for="title">Title</label>
      <input class="form-input" id="title" type="text" name="title" placeholder="Project title..." required autofocus value="{{ $p->title }}">
    </div>

    <div class="mt-6">
      <label class="form-label form-label-required" for="url">Url</label>
      <input class="form-input" id="url" type="url" name="url" placeholder="Project url..." required value="{{ $p->url }}">
    </div>

    <div class="mt-6">
      <label class="form-label" for="description">Description</label>
      <textarea class="form-input" id="description" name="description" rows="10" placeholder="Project description...">{{ $p->description }}</textarea>
    </div>

    <div class="mt-6">
      <label class="form-label" for="img">Img</label>
      <input class="form-file" type="file" id="img" name="img">
    </div>

    <div class="mt-6 text-right">
      <input class="btn btn-primary" type="submit" value="Submit">
    </div>
  </form>
</div>

@endsection
