@extends('layouts.workshop', [ 'name' => $name ])

@section('content')

<textarea id="source"></textarea>

<script src="https://remarkjs.com/downloads/remark-latest.min.js"></script>
<script>
  var slideshow = remark.create({
    sourceUrl: '{{ Storage::url("workshops/$name.md") }}',
    highlightStyle: 'atom-one-dark',
  });
</script>

@endsection
