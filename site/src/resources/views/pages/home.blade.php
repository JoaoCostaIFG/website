@extends('layouts.layout', ['title' => 'Homepage'])

@section('content')
  <?php use App\Models\Blog; ?>

  <h1>Welcome to my corner of the Internet!</h1>

  <div class="grid grid-cols-12 gap-x-4 gap-y-4">
    <section class="col-span-12 md:col-span-7">
      <h2>Recent posts</h2>
      <div class="mb-4 grid grid-cols-1 gap-y-1">
        @each('partials.blog.home_entry', Blog::some(3), 'b')
      </div>
      <div class="max-w-xl text-right">
        <a class="btn btn-primary" href="{{ route('blogs') }}">
          Older posts
        </a>
      </div>
    </section>

    <section class="col-span-12 md:col-span-5">
      <h2>About</h2>
      <p class="mb-4">
        Hey! My name is João Costa and this is my personal corner of the internet.
        I'm interested in computer science and electronics, and I enjoy implementing my own solutions to
        problems/needs.
        This page's main focus is for me to share some ideas/processes behind projects that I've worked on.
      </p>
      <div class="text-right">
        <a class="btn btn-primary" href="{{ route('about') }}">
          More About Me
        </a>
      </div>
    </section>

    <section class="col-span-12">
      <h2><a href="https://wiki.joaocosta.dev">Wiki</a></h2>
      <p>
        I manage a small <a class="anchor" href="https://wiki.joaocosta.dev">wiki</a> where I post small "cookbooks",
        "cheat-sheets" and other general guides/annotations. It's basically part of my notes that I decided to make public.
      </p>
    </section>

    <section class="col-span-12">
      <h2>My friends</h2>
      <p>
        This is a list of my friends' websites. Pay them a visit sometime.
        <ul class="list-disc">
          <li><a href="https://educorreia932.dev">educorreia932</a></li>
          <li><a href="https://marceloborges.dev">jmarcelomb</a></li>
        </ul>
      </p>
    </section>
  </div>
@endsection
