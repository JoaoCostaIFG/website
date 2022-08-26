<?php
// look for code blocks (to include syntax highlighting code)
$args = ['title' => $b->title];
if (strpos($b->content, '```') !== false) {
  $args['css'] = ['resources/css/prism.css'];
  $args['js'] = ['resources/js/prism.js'];
}
?>

@extends('layouts.layout', $args)

@section('content')

<div class="w-full">
  <article class="m-auto relative prose blog line-numbers match-braces">
    @auth
    <a class="absolute top-0 right-0 z-50 icon-btn btn-edit" title="Edit post {{ $b->id }}" href="{{ route('blog_edit', ['id' => $b->id]) }}">
      <i class="fa-solid fa-pen-to-square"></i>
    </a>
    @endauth

    <h1 class="mb-0">{!! Parsedown::instance()->line($b->title) !!}</h1>
    <em class="block muted mb-4">Avg. {{ $b->readingTime() }} minute(s) of reading</em>

    @if (!is_null($b->intro))
    <div class="p-2 rounded-md bg-background-300 dark:bg-background-900">
      {!! Parsedown::instance()->text($b->intro) !!}
    </div>
    @endif

    {!! Parsedown::instance()->text($b->content) !!}
  </article>
</div>

@endsection
