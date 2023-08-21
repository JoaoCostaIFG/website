@extends('layouts.layout', [ 'title' => 'Blog'])

@section('content')

<?php

use App\Models\Blog; ?>

<div class="relative max-w-prose m-auto">
  @auth
  <a class="absolute right-0 icon-btn btn-info" title="Create new blog post" href="{{ route('blog_new') }}">
    <i class="fa-solid fa-plus"></i>
  </a>
  @endauth

  <h1>All of my blog posts</h1>

  <div class="grid grid-cols-1 gap-y-4">
    @each('partials.blog.entry', Blog::allAuth(), 'b')
  </div>
</div>


@endsection
