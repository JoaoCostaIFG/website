@extends('layouts.workshop', [ 'name' => $name ])

@section('content')

<textarea id="source"></textarea>

<script src="https://remarkjs.com/downloads/remark-latest.min.js" nonce="{{ Vite::cspNonce() }}"></script>
<script nonce="{{ Vite::cspNonce() }}">
  var slideshow = remark.create({
    sourceUrl: '{{ asset("workshops/$name.md") }}',
    highlightStyle: 'atom-one-dark',
  });
</script>

@endsection
