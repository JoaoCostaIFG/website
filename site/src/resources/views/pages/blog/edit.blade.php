@extends('layouts.layout', ['title' => 'Edit blog post', 'js' => ['resources/ts/editor.ts', 'resources/ts/blogimg.ts']])

@section('content')

<h1>Edit blog post</h1>

<div class="w-full">
  <form class="mx-auto max-w-prose" method="POST" action="{{ route('blog_edit_action') }}">
    @csrf
    <input type="hidden" id="id" name="id" value="{{ $b->id }}">

    <div>
      <label class="form-label form-label-required" for="title">Title</label>
      <input class="form-input" id="title" type="text" name="title" placeholder="Post title..." required autofocus value="{{ $b->title }}">
    </div>

    <div class="mt-6 w-full flex flex-row flex-wrap items-center gap-2">
      <div class="flex-auto min-w-0">
        <label class="form-label" for="date">Date</label>
        <input class="block form-input" type="date" id="date" name="date" value="{{ $b->getDateStr() }}">
      </div>

      <label>
        <input class="form-checkbox" id="visibility" type="checkbox" name="visibility" <?php if ($b->visible) echo 'checked'; ?>>
        <span class="ml-1">Publicly visible</span>
      </label>
    </div>

    <div class="mt-6">
      <label class="form-label" for="intro">Intro</label>
      <textarea class="form-input" id="intro" name="intro" rows="3" placeholder="Summary/Introduction...">{{ $b->intro }}</textarea>
    </div>

    <textarea class="hidden" id="content" name="content" rows="1" required>{{ $b->content }}</textarea>

    <div class="mt-6 text-right">
      <input class="btn btn-primary" type="submit" value="Submit">
    </div>
  </form>

  <div class="mt-6 mx-auto p-1 max-w-prose bg-white dark:bg-background-900 border border-foreground-600 dark:border-foreground-500 rounded-md flex flex-wrap justify-center gap-2" id="imgContainer">
    <div class="w-full flex flex-row flex-wrap items-center gap-2">
      <hr class="w-full">
      <input class="form-file" type="file" id="img">
    </div>
  </div>

  <div class="mx-auto mt-6" id="editor-container">
  </div>
</div>

@endsection
