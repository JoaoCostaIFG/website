@extends('layouts.layout', [ 'title' => 'Workshops'])

@section('content')

<h1>My workshop presentations material</h1>

<ul>
  @include('partials.workshop.entry', ['w' => [
    'name' => 'shellscript',
    'title' => 'Shell scripting workshop',
    'date' => '2020-11-01']])
  @include('partials.workshop.entry', ['w' => [
    'name' => 'intropython3',
    'title' => 'Introduction to python3 workshop',
    'date' => '2019-11-15']])
</ul>

@endsection
