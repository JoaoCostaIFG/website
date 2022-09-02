@extends('layouts.layout', [ 'title' => 'New project' ])

@section('content')

<?php

use App\Models\Proj; ?>

<h1>New project</h1>

<div class="w-full">
  <form class="m-auto max-w-prose" method="POST" action="{{ route('project_new_action') }}" enctype="multipart/form-data">
    @csrf
    <div>
      <label class="form-label form-label-required" for="title">Title</label>
      <input class="form-input" id="title" type="text" name="title" placeholder="Project title..." required autofocus>
    </div>

    <div class="mt-6">
      <label class="form-label form-label-required" for="url">Url</label>
      <input class="form-input" id="url" type="url" name="url" placeholder="Project url..." required>
    </div>

    <div class="mt-6">
      <label class="form-label" for="description">Description</label>
      <textarea class="form-input" id="description" name="description" rows="10" placeholder="Project description..."></textarea>
    </div>

    <div class="mt-6">
      <label class="form-label form-label-required" for="img">Img</label>
      <input class="form-file" type="file" id="img" name="img" required>
    </div>

    <div class="mt-6 text-right">
      <input class="btn btn-primary" type="submit" value="Submit">
    </div>
  </form>
</div>

@endsection
