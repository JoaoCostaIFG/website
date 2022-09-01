<a class="p-2 rounded-md
    bg-background-200 text-foreground-800 dark:bg-background-900 dark:text-foreground-200
    hover:bg-gray-300 dark:hover:bg-gray-900
    hover:ring-2 hover:ring-primary-500 dark:hover:ring-primary-600" href="{{ route('blog', ['b' => $b]) }}">
  <span class="font-semibold">
    {{ $b->title }}
    @if (!$b->visible)
    <span class="text-red-600 dark:text-red-400"> (hidden)</span>
    @endif
  </span>
  <br>
  <span class="line-clamp-1 lg:line-clamp-2 ml-2 text-foreground-800 dark:text-foreground-400">
    {{ $b->intro }}
  </span>
  <span class="muted">
    {{ $b->getDateStr() }}
  </span>
</a>
