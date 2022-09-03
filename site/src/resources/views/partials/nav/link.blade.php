@if ($selected)
<a class="bg-navbar-900 block text-white px-2 py-2 rounded-md text-sm" href="{{ $href }}" aria-current="page">
  {!! $title !!}
</a>
@else
<a class="text-navbar-300 block hover:bg-gray-700 hover:text-white px-2 py-2 rounded-md text-sm" href="{{ $href }}">
  {!! $title !!}
</a>
@endif
