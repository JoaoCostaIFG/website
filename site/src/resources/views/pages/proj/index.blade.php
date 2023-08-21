@extends('layouts.layout', [ 'title' => 'Projects' ])

@section('content')

<?php

use App\Models\Proj; ?>

<div class="relative">
  @auth
  <a class="absolute right-0 icon-btn btn-info" title="Add new project" href="{{ route('project_new') }}">
    <i class="fa-solid fa-plus"></i>
  </a>
  @endauth

  <h1>Projects</h1>

  <p>
    The following are some projects I've created/worked on that I feel proud of.
  </p>

  <section id="projs-container" class="mt-4 flex flex-row gap-6 flex-wrap justify-center">
    @each('partials.proj.entry', Proj::all(), 'p')
  </section>
</div>

@endsection
