@extends('layouts.layout', [ 'title' => 'Login' ])

@section('content')

<h1>Login</h1>

<div class="w-full">
  <form class="m-auto max-w-lg" method="POST" action="{{ route('login_action') }}">
    @csrf
    <div>
      <label class="form-label form-label-required" for="username">Username</label>
      <input class="form-input" id="username" type="text" name="username" placeholder="Enter your username..." required autofocus>
    </div>

    <div class="mt-6">
      <label class="form-label form-label-required" for="password">Password</label>
      <input class="form-input" id="password" type="password" name="password" placeholder="Enter password..." required><br>
    </div>

    <div class="mt-6 text-right">
      <input class="btn btn-primary" type="submit" value="Login">
    </div>
  </form>
</div>

@endsection
